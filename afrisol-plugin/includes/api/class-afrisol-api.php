<?php
/**
 * Afrisol REST API Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_API {

    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    /**
     * Register REST API routes
     */
    public function register_routes() {
        $namespace = 'afrisol/v1';

        // Products
        register_rest_route($namespace, '/products', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_products'),
            'permission_callback' => '__return_true'
        ));

        register_rest_route($namespace, '/products/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_product'),
            'permission_callback' => '__return_true'
        ));

        // Cart
        register_rest_route($namespace, '/cart', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_cart'),
            'permission_callback' => '__return_true'
        ));

        register_rest_route($namespace, '/cart/add', array(
            'methods' => 'POST',
            'callback' => array($this, 'add_to_cart'),
            'permission_callback' => '__return_true'
        ));

        // Orders
        register_rest_route($namespace, '/orders', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_orders'),
            'permission_callback' => array($this, 'check_user_logged_in')
        ));

        // Calculator
        register_rest_route($namespace, '/calculator', array(
            'methods' => 'POST',
            'callback' => array($this, 'calculate_solar'),
            'permission_callback' => '__return_true'
        ));
    }

    /**
     * Get products
     */
    public function get_products($request) {
        $args = array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => $request->get_param('per_page') ?: 12,
            'paged' => $request->get_param('page') ?: 1
        );

        // Category filter
        if ($request->get_param('category')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'afrisol_product_cat',
                'field' => 'slug',
                'terms' => $request->get_param('category')
            );
        }

        $query = new WP_Query($args);
        $products = array();

        foreach ($query->posts as $post) {
            $products[] = $this->format_product($post);
        }

        return rest_ensure_response(array(
            'products' => $products,
            'total' => $query->found_posts,
            'pages' => $query->max_num_pages
        ));
    }

    /**
     * Get single product
     */
    public function get_product($request) {
        $id = $request->get_param('id');
        $post = get_post($id);

        if (!$post || $post->post_type !== 'afrisol_product') {
            return new WP_Error('not_found', 'Product not found', array('status' => 404));
        }

        return rest_ensure_response($this->format_product($post, true));
    }

    /**
     * Format product data
     */
    private function format_product($post, $full = false) {
        $data = array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'slug' => $post->post_name,
            'price' => get_post_meta($post->ID, '_afrisol_price', true),
            'sale_price' => get_post_meta($post->ID, '_afrisol_sale_price', true),
            'stock_status' => get_post_meta($post->ID, '_afrisol_stock_status', true),
            'image' => get_the_post_thumbnail_url($post->ID, 'large'),
            'thumbnail' => get_the_post_thumbnail_url($post->ID, 'thumbnail'),
            'url' => get_permalink($post->ID)
        );

        if ($full) {
            $data['description'] = $post->post_content;
            $data['excerpt'] = $post->post_excerpt;
            $data['sku'] = get_post_meta($post->ID, '_afrisol_sku', true);
            $data['brand'] = get_post_meta($post->ID, '_afrisol_brand', true);
            $data['warranty'] = get_post_meta($post->ID, '_afrisol_warranty', true);
            $data['power_capacity'] = get_post_meta($post->ID, '_afrisol_power_capacity', true);
            $data['specifications'] = get_post_meta($post->ID, '_afrisol_specifications', true);
            $data['gallery'] = get_post_meta($post->ID, '_afrisol_gallery', true);
            
            // Reviews
            $reviews = new Afrisol_Reviews();
            $data['rating'] = $reviews->get_product_rating($post->ID);
            $data['review_count'] = $reviews->get_product_review_count($post->ID);
            
            // Categories
            $categories = get_the_terms($post->ID, 'afrisol_product_cat');
            $data['categories'] = $categories ? wp_list_pluck($categories, 'name') : array();
        }

        return $data;
    }

    /**
     * Get cart
     */
    public function get_cart($request) {
        $cart = new Afrisol_Cart();
        $items = $cart->get_items();

        $formatted_items = array();
        foreach ($items as $item) {
            $formatted_items[] = array(
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->final_price,
                'total' => $item->total,
                'image' => $item->image
            );
        }

        return rest_ensure_response(array(
            'items' => $formatted_items,
            'subtotal' => $cart->get_subtotal(),
            'tax' => $cart->get_tax(),
            'total' => $cart->get_total(),
            'count' => $cart->get_count()
        ));
    }

    /**
     * Add to cart
     */
    public function add_to_cart($request) {
        $product_id = $request->get_param('product_id');
        $quantity = $request->get_param('quantity') ?: 1;

        if (!$product_id) {
            return new WP_Error('invalid_product', 'Invalid product ID', array('status' => 400));
        }

        $cart = new Afrisol_Cart();
        $result = $cart->add_item($product_id, $quantity);

        if ($result) {
            return rest_ensure_response(array(
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $cart->get_count(),
                'cart_total' => $cart->get_total()
            ));
        }

        return new WP_Error('cart_error', 'Error adding to cart', array('status' => 500));
    }

    /**
     * Get user orders
     */
    public function get_orders($request) {
        $user_id = get_current_user_id();
        $orders = new Afrisol_Orders();
        $user_orders = $orders->get_user_orders($user_id, 20);

        $formatted = array();
        foreach ($user_orders as $order) {
            $formatted[] = array(
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => $order->total,
                'created_at' => $order->created_at
            );
        }

        return rest_ensure_response($formatted);
    }

    /**
     * Solar calculator
     */
    public function calculate_solar($request) {
        $monthly_bill = floatval($request->get_param('monthly_bill'));
        $appliances = $request->get_param('appliances') ?: array();

        // Calculate daily consumption
        $daily_kwh = 0;
        
        if (!empty($appliances)) {
            foreach ($appliances as $appliance) {
                $watts = floatval($appliance['watts']);
                $quantity = intval($appliance['quantity']);
                $hours = floatval($appliance['hours']);
                $daily_kwh += ($watts * $quantity * $hours) / 1000;
            }
        } elseif ($monthly_bill > 0) {
            $estimated_monthly_kwh = $monthly_bill / 50;
            $daily_kwh = $estimated_monthly_kwh / 30;
        }

        // Calculate system requirements
        $sun_hours = 5;
        $efficiency = 0.8;
        $panel_wattage = 400;

        $system_size = $daily_kwh / ($sun_hours * $efficiency);
        $panels = ceil($system_size / ($panel_wattage / 1000));
        $battery_size = ceil($daily_kwh * 1.5);

        // Cost estimates
        $panel_cost = $system_size * 1000 * 800;
        $battery_cost = $battery_size * 400000;
        $installation_cost = $system_size * 150000;
        $total_cost = $panel_cost + $battery_cost + $installation_cost;

        // Savings
        $monthly_savings = $monthly_bill ?: ($daily_kwh * 30 * 50);
        $roi_years = $total_cost / ($monthly_savings * 12);
        $co2_savings = $daily_kwh * 365 * 0.4;

        return rest_ensure_response(array(
            'system_size' => round($system_size, 2),
            'panels' => $panels,
            'battery_size' => $battery_size,
            'panel_cost' => $panel_cost,
            'battery_cost' => $battery_cost,
            'installation_cost' => $installation_cost,
            'total_cost' => $total_cost,
            'monthly_savings' => $monthly_savings,
            'roi_years' => round($roi_years, 1),
            'co2_savings' => round($co2_savings, 0)
        ));
    }

    /**
     * Check if user is logged in
     */
    public function check_user_logged_in() {
        return is_user_logged_in();
    }
}

// Initialize API
new Afrisol_API();