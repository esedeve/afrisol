
<?php
/**
 * Afrisol AJAX Handlers
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add to Cart
add_action('wp_ajax_afrisol_add_to_cart', 'afrisol_ajax_add_to_cart');
add_action('wp_ajax_nopriv_afrisol_add_to_cart', 'afrisol_ajax_add_to_cart');

function afrisol_ajax_add_to_cart() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']) ?: 1;
    
    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product'));
    }
    
    $cart = new Afrisol_Cart();
    $result = $cart->add_item($product_id, $quantity);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'Product added to cart',
            'cart_count' => $cart->get_count()
        ));
    } else {
        wp_send_json_error(array('message' => 'Error adding to cart'));
    }
}

// Update Cart
add_action('wp_ajax_afrisol_update_cart', 'afrisol_ajax_update_cart');
add_action('wp_ajax_nopriv_afrisol_update_cart', 'afrisol_ajax_update_cart');

function afrisol_ajax_update_cart() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);
    
    $cart = new Afrisol_Cart();
    $cart->update_quantity($item_id, $quantity);
    
    wp_send_json_success(array(
        'subtotal' => $cart->get_subtotal(),
        'tax' => $cart->get_tax(),
        'total' => $cart->get_total(),
        'cart_count' => $cart->get_count()
    ));
}

// Remove from Cart
add_action('wp_ajax_afrisol_remove_from_cart', 'afrisol_ajax_remove_from_cart');
add_action('wp_ajax_nopriv_afrisol_remove_from_cart', 'afrisol_ajax_remove_from_cart');

function afrisol_ajax_remove_from_cart() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $item_id = intval($_POST['item_id']);
    
    $cart = new Afrisol_Cart();
    $cart->remove_item($item_id);
    
    wp_send_json_success(array(
        'subtotal' => $cart->get_subtotal(),
        'tax' => $cart->get_tax(),
        'total' => $cart->get_total(),
        'cart_count' => $cart->get_count()
    ));
}

// Toggle Wishlist
add_action('wp_ajax_afrisol_toggle_wishlist', 'afrisol_ajax_toggle_wishlist');

function afrisol_ajax_toggle_wishlist() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Please login to add to wishlist'));
    }
    
    $product_id = intval($_POST['product_id']);
    $wishlist = new Afrisol_Wishlist();
    $result = $wishlist->toggle($product_id);
    
    wp_send_json_success(array('added' => $result));
}

// Contact Form
add_action('wp_ajax_afrisol_contact_form', 'afrisol_ajax_contact_form');
add_action('wp_ajax_nopriv_afrisol_contact_form', 'afrisol_ajax_contact_form');

function afrisol_ajax_contact_form() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields'));
    }
    
    $to = get_option('afrisol_email', get_option('admin_email'));
    $email_subject = 'Contact Form: ' . $subject;
    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone: $phone\n\n";
    $email_body .= "Message:\n$message";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email
    );
    
    $sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Message sent successfully'));
    } else {
        wp_send_json_error(array('message' => 'Error sending message'));
    }
}

// Submit Quote
add_action('wp_ajax_afrisol_submit_quote', 'afrisol_ajax_submit_quote');
add_action('wp_ajax_nopriv_afrisol_submit_quote', 'afrisol_ajax_submit_quote');

function afrisol_ajax_submit_quote() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $quotes = new Afrisol_Quotes();
    $result = $quotes->create(array(
        'service_type' => sanitize_text_field($_POST['service_type']),
        'category' => sanitize_text_field($_POST['category']),
        'project_details' => sanitize_textarea_field($_POST['project_details']),
        'location' => sanitize_textarea_field($_POST['location']),
        'budget_range' => sanitize_text_field($_POST['budget_range']),
        'customer_name' => sanitize_text_field($_POST['customer_name']),
        'customer_email' => sanitize_email($_POST['customer_email']),
        'customer_phone' => sanitize_text_field($_POST['customer_phone']),
        'customer_whatsapp' => sanitize_text_field($_POST['customer_whatsapp']),
        'preferred_contact' => sanitize_text_field($_POST['preferred_contact']),
        'best_time' => sanitize_text_field($_POST['best_time'])
    ));
    
    if ($result) {
        // Send notification email
        $to = get_option('afrisol_email', get_option('admin_email'));
        $subject = 'New Quote Request: ' . $result['quote_number'];
        $message = "A new quote request has been submitted.\n\n";
        $message .= "Quote Number: " . $result['quote_number'] . "\n";
        $message .= "Service Type: " . sanitize_text_field($_POST['service_type']) . "\n";
        $message .= "Customer: " . sanitize_text_field($_POST['customer_name']) . "\n";
        $message .= "Email: " . sanitize_email($_POST['customer_email']) . "\n";
        $message .= "Phone: " . sanitize_text_field($_POST['customer_phone']) . "\n";
        
        wp_mail($to, $subject, $message);
        
        wp_send_json_success(array(
            'message' => 'Quote request submitted successfully',
            'quote_number' => $result['quote_number']
        ));
    } else {
        wp_send_json_error(array('message' => 'Error submitting quote request'));
    }
}

// Submit Repair Request
add_action('wp_ajax_afrisol_submit_repair', 'afrisol_ajax_submit_repair');
add_action('wp_ajax_nopriv_afrisol_submit_repair', 'afrisol_ajax_submit_repair');

function afrisol_ajax_submit_repair() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $repairs = new Afrisol_Repairs();
    $result = $repairs->create(array(
        'equipment_type' => sanitize_text_field($_POST['equipment_type']),
        'brand_model' => sanitize_text_field($_POST['brand_model']),
        'problem_description' => sanitize_textarea_field($_POST['problem_description']),
        'warranty_status' => isset($_POST['warranty_status']) ? 1 : 0,
        'service_type' => sanitize_text_field($_POST['service_type']),
        'urgency' => sanitize_text_field($_POST['urgency']),
        'customer_name' => sanitize_text_field($_POST['customer_name']),
        'customer_email' => sanitize_email($_POST['customer_email']),
        'customer_phone' => sanitize_text_field($_POST['customer_phone'])
    ));
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'Repair request submitted successfully',
            'ticket_number' => $result['ticket_number']
        ));
    } else {
        wp_send_json_error(array('message' => 'Error submitting repair request'));
    }
}

// Filter Products
add_action('wp_ajax_afrisol_filter_products', 'afrisol_ajax_filter_products');
add_action('wp_ajax_nopriv_afrisol_filter_products', 'afrisol_ajax_filter_products');

function afrisol_ajax_filter_products() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $args = array(
        'post_type' => 'afrisol_product',
        'posts_per_page' => 12,
        'paged' => intval($_POST['page']) ?: 1
    );
    
    // Category filter
    if (!empty($_POST['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'afrisol_product_cat',
            'field' => 'slug',
            'terms' => array_map('sanitize_text_field', (array)$_POST['category'])
        );
    }
    
    // Brand filter
    if (!empty($_POST['brand'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'afrisol_brand',
            'field' => 'slug',
            'terms' => array_map('sanitize_text_field', (array)$_POST['brand'])
        );
    }
    
    // Price range filter
    if (!empty($_POST['price_min']) || !empty($_POST['price_max'])) {
        $args['meta_query'][] = array(
            'key' => '_afrisol_price',
            'value' => array(
                floatval($_POST['price_min']) ?: 0,
                floatval($_POST['price_max']) ?: 999999999
            ),
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        );
    }
    
    // Power capacity filter
    if (!empty($_POST['power_capacity'])) {
        $args['meta_query'][] = array(
            'key' => '_afrisol_power_capacity',
            'value' => array_map('sanitize_text_field', (array)$_POST['power_capacity']),
            'compare' => 'IN'
        );
    }
    
    // Stock status filter
    if (!empty($_POST['in_stock'])) {
        $args['meta_query'][] = array(
            'key' => '_afrisol_stock_status',
            'value' => 'instock'
        );
    }
    
    // Sorting
    $sort = sanitize_text_field($_POST['sort']) ?: 'date';
    switch ($sort) {
        case 'price_low':
            $args['meta_key'] = '_afrisol_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'price_high':
            $args['meta_key'] = '_afrisol_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'popularity':
            $args['meta_key'] = '_afrisol_sales_count';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'rating':
            $args['meta_key'] = '_afrisol_average_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            afrisol_get_template_part('content', 'product-card');
        }
    } else {
        echo '<p class="afrisol-no-products">No products found matching your criteria.</p>';
    }
    $html = ob_get_clean();
    wp_reset_postdata();
    
    wp_send_json_success(array(
        'html' => $html,
        'count' => $query->found_posts,
        'max_pages' => $query->max_num_pages
    ));
}

// Quick View Product
add_action('wp_ajax_afrisol_get_product_quickview', 'afrisol_ajax_get_product_quickview');
add_action('wp_ajax_nopriv_afrisol_get_product_quickview', 'afrisol_ajax_get_product_quickview');

function afrisol_ajax_get_product_quickview() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    
    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product'));
    }
    
    $product = get_post($product_id);
    if (!$product || $product->post_type !== 'afrisol_product') {
        wp_send_json_error(array('message' => 'Product not found'));
    }
    
    $price = get_post_meta($product_id, '_afrisol_price', true);
    $sale_price = get_post_meta($product_id, '_afrisol_sale_price', true);
    $stock_status = get_post_meta($product_id, '_afrisol_stock_status', true);
    $gallery = get_post_meta($product_id, '_afrisol_gallery', true);
    
    ob_start();
    ?>
    <div class="afrisol-quickview-gallery">
        <?php if (has_post_thumbnail($product_id)) : ?>
            <img src="<?php echo get_the_post_thumbnail_url($product_id, 'large'); ?>" alt="<?php echo esc_attr($product->post_title); ?>">
        <?php endif; ?>
    </div>
    <div class="afrisol-quickview-info">
        <h2><?php echo esc_html($product->post_title); ?></h2>
        
        <div class="afrisol-product-price">
            <?php if ($sale_price && $sale_price < $price) : ?>
                <span class="original">₦<?php echo number_format($price); ?></span>
                <span class="current">₦<?php echo number_format($sale_price); ?></span>
            <?php else : ?>
                <span class="current">₦<?php echo number_format($price); ?></span>
            <?php endif; ?>
        </div>
        
        <div class="afrisol-product-excerpt">
            <?php echo wp_trim_words($product->post_content, 30); ?>
        </div>
        
        <div class="afrisol-product-stock <?php echo esc_attr($stock_status); ?>">
            <?php if ($stock_status === 'instock') : ?>
                <i class="fas fa-check-circle"></i> In Stock
            <?php elseif ($stock_status === 'lowstock') : ?>
                <i class="fas fa-exclamation-circle"></i> Low Stock
            <?php else : ?>
                <i class="fas fa-times-circle"></i> Out of Stock
            <?php endif; ?>
        </div>
        
        <div class="afrisol-product-add-to-cart">
            <div class="afrisol-quantity">
                <button type="button" class="afrisol-quantity-btn">-</button>
                <input type="number" class="afrisol-quantity-input" value="1" min="1">
                <button type="button" class="afrisol-quantity-btn">+</button>
            </div>
            <button class="afrisol-btn afrisol-btn-primary afrisol-add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>">
                <i class="fas fa-shopping-cart"></i> Add to Cart
            </button>
        </div>
        
        <a href="<?php echo get_permalink($product_id); ?>" class="afrisol-btn afrisol-btn-outline">
            View Full Details
        </a>
    </div>
    <?php
    $html = ob_get_clean();
    
    wp_send_json_success(array('html' => $html));
}

// Notify Me
add_action('wp_ajax_afrisol_notify_me', 'afrisol_ajax_notify_me');
add_action('wp_ajax_nopriv_afrisol_notify_me', 'afrisol_ajax_notify_me');

function afrisol_ajax_notify_me() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    global $wpdb;
    
    $product_id = intval($_POST['product_id']);
    $email = sanitize_email($_POST['email']);
    
    if (!$product_id || !is_email($email)) {
        wp_send_json_error(array('message' => 'Invalid data'));
    }
    
    $table = $wpdb->prefix . 'afrisol_notify';
    
    // Check if already subscribed
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table WHERE product_id = %d AND email = %s",
        $product_id,
        $email
    ));
    
    if ($exists) {
        wp_send_json_error(array('message' => 'You are already subscribed'));
    }
    
    $result = $wpdb->insert($table, array(
        'product_id' => $product_id,
        'email' => $email
    ));
    
    if ($result) {
        wp_send_json_success(array('message' => 'Subscription successful'));
    } else {
        wp_send_json_error(array('message' => 'Error subscribing'));
    }
}

// Submit Review
add_action('wp_ajax_afrisol_submit_review', 'afrisol_ajax_submit_review');
add_action('wp_ajax_nopriv_afrisol_submit_review', 'afrisol_ajax_submit_review');

function afrisol_ajax_submit_review() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $reviews = new Afrisol_Reviews();
    $result = $reviews->create(array(
        'product_id' => intval($_POST['product_id']),
        'user_id' => get_current_user_id(),
        'reviewer_name' => sanitize_text_field($_POST['reviewer_name']),
        'reviewer_email' => sanitize_email($_POST['reviewer_email']),
        'rating' => intval($_POST['rating']),
        'review_text' => sanitize_textarea_field($_POST['review_text'])
    ));
    
    if ($result) {
        wp_send_json_success(array('message' => 'Review submitted successfully'));
    } else {
        wp_send_json_error(array('message' => 'Error submitting review'));
    }
}

// Verify Payment
add_action('wp_ajax_afrisol_verify_payment', 'afrisol_ajax_verify_payment');
add_action('wp_ajax_nopriv_afrisol_verify_payment', 'afrisol_ajax_verify_payment');

function afrisol_ajax_verify_payment() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $reference = sanitize_text_field($_POST['reference']);
    $secret_key = get_option('afrisol_paystack_secret_key');
    
    if (!$secret_key) {
        wp_send_json_error(array('message' => 'Payment not configured'));
    }
    
    // Verify with Paystack
    $response = wp_remote_get(
        'https://api.paystack.co/transaction/verify/' . $reference,
        array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $secret_key
            )
        )
    );
    
    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => 'Payment verification failed'));
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if ($body['status'] && $body['data']['status'] === 'success') {
        // Create order
        $orders = new Afrisol_Orders();
        $cart = new Afrisol_Cart();
        
        $order_data = array(
            'user_id' => get_current_user_id(),
            'subtotal' => $cart->get_subtotal(),
            'tax' => $cart->get_tax(),
            'shipping' => floatval($_POST['shipping'] ?? 0),
            'total' => $body['data']['amount'] / 100,
            'payment_method' => 'paystack',
            'payment_status' => 'completed',
            'transaction_id' => $reference,
            'billing_address' => sanitize_textarea_field($_POST['billing_address']),
            'shipping_address' => sanitize_textarea_field($_POST['shipping_address']),
            'customer_name' => sanitize_text_field($_POST['customer_name']),
            'customer_email' => sanitize_email($_POST['email']),
            'customer_phone' => sanitize_text_field($_POST['phone']),
            'notes' => sanitize_textarea_field($_POST['notes'] ?? '')
        );
        
        $order = $orders->create($order_data, $cart->get_items());
        
        if ($order) {
            // Clear cart
            $cart->clear();
            
            // Send confirmation email
            afrisol_send_order_confirmation($order);
            
            wp_send_json_success(array(
                'message' => 'Payment successful',
                'redirect' => home_url('/order-confirmation/?order=' . $order['order_number'])
            ));
        }
    }
    
    wp_send_json_error(array('message' => 'Payment verification failed'));
}

// Apply Coupon
add_action('wp_ajax_afrisol_apply_coupon', 'afrisol_ajax_apply_coupon');
add_action('wp_ajax_nopriv_afrisol_apply_coupon', 'afrisol_ajax_apply_coupon');

function afrisol_ajax_apply_coupon() {
    check_ajax_referer('afrisol_nonce', 'nonce');
    
    $code = sanitize_text_field($_POST['code']);
    
    // Get coupon from database or implement coupon logic
    // For now, return a basic response
    wp_send_json_error(array('message' => 'Invalid coupon code'));
}

// Helper function to send order confirmation
function afrisol_send_order_confirmation($order) {
    $to = $order['customer_email'];
    $subject = 'Order Confirmation - ' . $order['order_number'];
    
    $message = "Thank you for your order!\n\n";
    $message .= "Order Number: " . $order['order_number'] . "\n";
    $message .= "Total: ₦" . number_format($order['total'], 2) . "\n\n";
    $message .= "We will process your order and notify you once it ships.\n\n";
    $message .= "Thank you for choosing Afrisol!";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Afrisol <' . get_option('afrisol_email', get_option('admin_email')) . '>'
    );
    
    wp_mail($to, $subject, $message, $headers);
}

// Helper function to get template part
function afrisol_get_template_part($slug, $name = null) {
    $template = '';
    
    if ($name) {
        $template = AFRISOL_PLUGIN_DIR . "templates/{$slug}-{$name}.php";
    }
    
    if (!$template || !file_exists($template)) {
        $template = AFRISOL_PLUGIN_DIR . "templates/{$slug}.php";
    }
    
    if (file_exists($template)) {
        include $template;
    }
}
