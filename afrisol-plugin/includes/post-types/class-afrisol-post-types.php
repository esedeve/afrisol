<?php
/**
 * Register custom post types for Afrisol
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Post_Types {

    /**
     * Register all custom post types
     */
    public static function register() {
        self::register_products();
        self::register_services();
        self::register_testimonials();
        self::register_sliders();
        self::register_team();
        self::register_faqs();
        self::register_taxonomies();
    }

    /**
     * Register Products post type
     */
    private static function register_products() {
        $labels = array(
            'name'               => __('Products', 'afrisol'),
            'singular_name'      => __('Product', 'afrisol'),
            'menu_name'          => __('Products', 'afrisol'),
            'add_new'            => __('Add New Product', 'afrisol'),
            'add_new_item'       => __('Add New Product', 'afrisol'),
            'edit_item'          => __('Edit Product', 'afrisol'),
            'new_item'           => __('New Product', 'afrisol'),
            'view_item'          => __('View Product', 'afrisol'),
            'search_items'       => __('Search Products', 'afrisol'),
            'not_found'          => __('No products found', 'afrisol'),
            'not_found_in_trash' => __('No products found in trash', 'afrisol'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'products'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-products',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'       => true,
        );

        register_post_type('afrisol_product', $args);

        // Register product meta fields
        register_post_meta('afrisol_product', '_afrisol_price', array(
            'type' => 'number',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_sale_price', array(
            'type' => 'number',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_sku', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_stock', array(
            'type' => 'integer',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_stock_status', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_brand', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_power_capacity', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_warranty', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_gallery', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_specifications', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_featured', array(
            'type' => 'boolean',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_product', '_afrisol_installment', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
    }

    /**
     * Register Services post type
     */
    private static function register_services() {
        $labels = array(
            'name'               => __('Services', 'afrisol'),
            'singular_name'      => __('Service', 'afrisol'),
            'menu_name'          => __('Services', 'afrisol'),
            'add_new'            => __('Add New Service', 'afrisol'),
            'add_new_item'       => __('Add New Service', 'afrisol'),
            'edit_item'          => __('Edit Service', 'afrisol'),
            'new_item'           => __('New Service', 'afrisol'),
            'view_item'          => __('View Service', 'afrisol'),
            'search_items'       => __('Search Services', 'afrisol'),
            'not_found'          => __('No services found', 'afrisol'),
            'not_found_in_trash' => __('No services found in trash', 'afrisol'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'services'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-admin-tools',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'       => true,
        );

        register_post_type('afrisol_service', $args);

        // Register service meta fields
        register_post_meta('afrisol_service', '_afrisol_service_icon', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_service', '_afrisol_service_price', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_service', '_afrisol_service_timeline', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_service', '_afrisol_service_guarantee', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_service', '_afrisol_before_after_gallery', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
    }

    /**
     * Register Testimonials post type
     */
    private static function register_testimonials() {
        $labels = array(
            'name'               => __('Testimonials', 'afrisol'),
            'singular_name'      => __('Testimonial', 'afrisol'),
            'menu_name'          => __('Testimonials', 'afrisol'),
            'add_new'            => __('Add New Testimonial', 'afrisol'),
            'add_new_item'       => __('Add New Testimonial', 'afrisol'),
            'edit_item'          => __('Edit Testimonial', 'afrisol'),
            'new_item'           => __('New Testimonial', 'afrisol'),
            'view_item'          => __('View Testimonial', 'afrisol'),
            'search_items'       => __('Search Testimonials', 'afrisol'),
            'not_found'          => __('No testimonials found', 'afrisol'),
            'not_found_in_trash' => __('No testimonials found in trash', 'afrisol'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'testimonials'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 7,
            'menu_icon'          => 'dashicons-format-quote',
            'supports'           => array('title', 'editor', 'thumbnail'),
            'show_in_rest'       => true,
        );

        register_post_type('afrisol_testimonial', $args);

        // Register testimonial meta fields
        register_post_meta('afrisol_testimonial', '_afrisol_rating', array(
            'type' => 'integer',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_testimonial', '_afrisol_location', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_testimonial', '_afrisol_designation', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
    }

    /**
     * Register Sliders post type
     */
    private static function register_sliders() {
        $labels = array(
            'name'               => __('Hero Sliders', 'afrisol'),
            'singular_name'      => __('Hero Slider', 'afrisol'),
            'menu_name'          => __('Hero Sliders', 'afrisol'),
            'add_new'            => __('Add New Slide', 'afrisol'),
            'add_new_item'       => __('Add New Slide', 'afrisol'),
            'edit_item'          => __('Edit Slide', 'afrisol'),
            'new_item'           => __('New Slide', 'afrisol'),
            'view_item'          => __('View Slide', 'afrisol'),
            'search_items'       => __('Search Slides', 'afrisol'),
            'not_found'          => __('No slides found', 'afrisol'),
            'not_found_in_trash' => __('No slides found in trash', 'afrisol'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 8,
            'menu_icon'          => 'dashicons-slides',
            'supports'           => array('title', 'thumbnail'),
            'show_in_rest'       => true,
        );

        register_post_type('afrisol_slider', $args);

        // Register slider meta fields
        register_post_meta('afrisol_slider', '_afrisol_slider_subtitle', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_slider', '_afrisol_slider_cta_text', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_slider', '_afrisol_slider_cta_link', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_slider', '_afrisol_slider_order', array(
            'type' => 'integer',
            'single' => true,
            'show_in_rest' => true,
        ));
    }

    /**
     * Register Team Members post type
     */
    private static function register_team() {
        $labels = array(
            'name'               => __('Team Members', 'afrisol'),
            'singular_name'      => __('Team Member', 'afrisol'),
            'menu_name'          => __('Team', 'afrisol'),
            'add_new'            => __('Add New Member', 'afrisol'),
            'add_new_item'       => __('Add New Team Member', 'afrisol'),
            'edit_item'          => __('Edit Team Member', 'afrisol'),
            'new_item'           => __('New Team Member', 'afrisol'),
            'view_item'          => __('View Team Member', 'afrisol'),
            'search_items'       => __('Search Team Members', 'afrisol'),
            'not_found'          => __('No team members found', 'afrisol'),
            'not_found_in_trash' => __('No team members found in trash', 'afrisol'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 9,
            'menu_icon'          => 'dashicons-groups',
            'supports'           => array('title', 'editor', 'thumbnail'),
            'show_in_rest'       => true,
        );

        register_post_type('afrisol_team', $args);

        // Register team meta fields
        register_post_meta('afrisol_team', '_afrisol_position', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_team', '_afrisol_linkedin', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
        register_post_meta('afrisol_team', '_afrisol_twitter', array(
            'type' => 'string',
            'single' => true,
            'show_in_rest' => true,
        ));
    }

    /**
     * Register FAQs post type
     */
    private static function register_faqs() {
        $labels = array(
            'name'               => __('FAQs', 'afrisol'),
            'singular_name'      => __('FAQ', 'afrisol'),
            'menu_name'          => __('FAQs', 'afrisol'),
            'add_new'            => __('Add New FAQ', 'afrisol'),
            'add_new_item'       => __('Add New FAQ', 'afrisol'),
            'edit_item'          => __('Edit FAQ', 'afrisol'),
            'new_item'           => __('New FAQ', 'afrisol'),
            'view_item'          => __('View FAQ', 'afrisol'),
            'search_items'       => __('Search FAQs', 'afrisol'),
            'not_found'          => __('No FAQs found', 'afrisol'),
            'not_found_in_trash' => __('No FAQs found in trash', 'afrisol'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => false,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 10,
            'menu_icon'          => 'dashicons-editor-help',
            'supports'           => array('title', 'editor'),
            'show_in_rest'       => true,
        );

        register_post_type('afrisol_faq', $args);
    }

    /**
     * Register custom taxonomies
     */
    private static function register_taxonomies() {
        // Product Categories
        $labels = array(
            'name'              => __('Product Categories', 'afrisol'),
            'singular_name'     => __('Product Category', 'afrisol'),
            'search_items'      => __('Search Categories', 'afrisol'),
            'all_items'         => __('All Categories', 'afrisol'),
            'parent_item'       => __('Parent Category', 'afrisol'),
            'parent_item_colon' => __('Parent Category:', 'afrisol'),
            'edit_item'         => __('Edit Category', 'afrisol'),
            'update_item'       => __('Update Category', 'afrisol'),
            'add_new_item'      => __('Add New Category', 'afrisol'),
            'new_item_name'     => __('New Category Name', 'afrisol'),
            'menu_name'         => __('Categories', 'afrisol'),
        );

        register_taxonomy('afrisol_product_cat', 'afrisol_product', array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'product-category'),
            'show_in_rest'      => true,
        ));

        // Product Brands
        register_taxonomy('afrisol_brand', 'afrisol_product', array(
            'hierarchical'      => false,
            'labels'            => array(
                'name'          => __('Brands', 'afrisol'),
                'singular_name' => __('Brand', 'afrisol'),
                'search_items'  => __('Search Brands', 'afrisol'),
                'all_items'     => __('All Brands', 'afrisol'),
                'edit_item'     => __('Edit Brand', 'afrisol'),
                'update_item'   => __('Update Brand', 'afrisol'),
                'add_new_item'  => __('Add New Brand', 'afrisol'),
                'new_item_name' => __('New Brand Name', 'afrisol'),
                'menu_name'     => __('Brands', 'afrisol'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'brand'),
            'show_in_rest'      => true,
        ));

        // Service Categories
        register_taxonomy('afrisol_service_cat', 'afrisol_service', array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __('Service Categories', 'afrisol'),
                'singular_name'     => __('Service Category', 'afrisol'),
                'search_items'      => __('Search Service Categories', 'afrisol'),
                'all_items'         => __('All Service Categories', 'afrisol'),
                'parent_item'       => __('Parent Service Category', 'afrisol'),
                'parent_item_colon' => __('Parent Service Category:', 'afrisol'),
                'edit_item'         => __('Edit Service Category', 'afrisol'),
                'update_item'       => __('Update Service Category', 'afrisol'),
                'add_new_item'      => __('Add New Service Category', 'afrisol'),
                'new_item_name'     => __('New Service Category Name', 'afrisol'),
                'menu_name'         => __('Service Categories', 'afrisol'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service-category'),
            'show_in_rest'      => true,
        ));

        // Blog Categories
        register_taxonomy('afrisol_blog_cat', 'post', array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __('Blog Categories', 'afrisol'),
                'singular_name'     => __('Blog Category', 'afrisol'),
                'menu_name'         => __('Afrisol Blog Categories', 'afrisol'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'blog-category'),
            'show_in_rest'      => true,
        ));

        // FAQ Categories
        register_taxonomy('afrisol_faq_cat', 'afrisol_faq', array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __('FAQ Categories', 'afrisol'),
                'singular_name'     => __('FAQ Category', 'afrisol'),
                'menu_name'         => __('FAQ Categories', 'afrisol'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
        ));
    }
}
