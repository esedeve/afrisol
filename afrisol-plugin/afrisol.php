<?php
/**
 * Plugin Name: Afrisol - Solar Solutions
 * Plugin URI: https://afrisol.com
 * Description: Complete WordPress plugin for Afrisol - Solar Solutions for a Sustainable Africa. Features e-commerce, services booking, solar calculator, customer portal, and more.
 * Version: 1.0.0
 * Author: Afrisol
 * Author URI: https://afrisol.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: afrisol
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Plugin version
define('AFRISOL_VERSION', '1.0.0');
define('AFRISOL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('AFRISOL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AFRISOL_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Plugin activation
 */
function afrisol_activate() {
    // Suppress any output during activation
    ob_start();
    
    // Create custom database tables
    afrisol_create_tables();
    
    // Register custom post types
    require_once AFRISOL_PLUGIN_DIR . 'includes/post-types/class-afrisol-post-types.php';
    Afrisol_Post_Types::register();
    
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default options
    afrisol_set_default_options();
    
    // Clean output buffer
    ob_end_clean();
}
register_activation_hook(__FILE__, 'afrisol_activate');

/**
 * Plugin deactivation
 */
function afrisol_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'afrisol_deactivate');

/**
 * Create custom database tables
 */
function afrisol_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Cart table
    $table_cart = $wpdb->prefix . 'afrisol_cart';
    $sql_cart = "CREATE TABLE IF NOT EXISTS $table_cart (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) DEFAULT NULL,
        session_id varchar(255) NOT NULL,
        product_id bigint(20) NOT NULL,
        quantity int(11) NOT NULL DEFAULT 1,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY session_id (session_id)
    ) $charset_collate;";

    // Orders table
    $table_orders = $wpdb->prefix . 'afrisol_orders';
    $sql_orders = "CREATE TABLE IF NOT EXISTS $table_orders (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) DEFAULT NULL,
        order_number varchar(50) NOT NULL,
        status varchar(50) DEFAULT 'pending',
        subtotal decimal(10,2) NOT NULL,
        tax decimal(10,2) DEFAULT 0,
        shipping decimal(10,2) DEFAULT 0,
        total decimal(10,2) NOT NULL,
        payment_method varchar(50) DEFAULT NULL,
        payment_status varchar(50) DEFAULT 'pending',
        transaction_id varchar(255) DEFAULT NULL,
        billing_address text,
        shipping_address text,
        customer_name varchar(255),
        customer_email varchar(255),
        customer_phone varchar(50),
        notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY order_number (order_number),
        KEY user_id (user_id)
    ) $charset_collate;";

    // Order items table
    $table_order_items = $wpdb->prefix . 'afrisol_order_items';
    $sql_order_items = "CREATE TABLE IF NOT EXISTS $table_order_items (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        order_id bigint(20) NOT NULL,
        product_id bigint(20) NOT NULL,
        product_name varchar(255) NOT NULL,
        quantity int(11) NOT NULL,
        price decimal(10,2) NOT NULL,
        total decimal(10,2) NOT NULL,
        PRIMARY KEY (id),
        KEY order_id (order_id)
    ) $charset_collate;";

    // Quotes table
    $table_quotes = $wpdb->prefix . 'afrisol_quotes';
    $sql_quotes = "CREATE TABLE IF NOT EXISTS $table_quotes (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        quote_number varchar(50) NOT NULL,
        service_type varchar(100) NOT NULL,
        category varchar(100),
        project_details text,
        location text,
        budget_range varchar(100),
        customer_name varchar(255) NOT NULL,
        customer_email varchar(255) NOT NULL,
        customer_phone varchar(50),
        customer_whatsapp varchar(50),
        preferred_contact varchar(50),
        best_time varchar(100),
        status varchar(50) DEFAULT 'pending',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY quote_number (quote_number)
    ) $charset_collate;";

    // Repair requests table
    $table_repairs = $wpdb->prefix . 'afrisol_repairs';
    $sql_repairs = "CREATE TABLE IF NOT EXISTS $table_repairs (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        ticket_number varchar(50) NOT NULL,
        equipment_type varchar(100) NOT NULL,
        brand_model varchar(255),
        problem_description text NOT NULL,
        warranty_status tinyint(1) DEFAULT 0,
        service_type varchar(50) DEFAULT 'onsite',
        urgency varchar(50) DEFAULT 'normal',
        customer_name varchar(255) NOT NULL,
        customer_email varchar(255) NOT NULL,
        customer_phone varchar(50),
        status varchar(50) DEFAULT 'pending',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY ticket_number (ticket_number)
    ) $charset_collate;";

    // Wishlist table
    $table_wishlist = $wpdb->prefix . 'afrisol_wishlist';
    $sql_wishlist = "CREATE TABLE IF NOT EXISTS $table_wishlist (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        product_id bigint(20) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY user_product (user_id, product_id)
    ) $charset_collate;";

    // Reviews table
    $table_reviews = $wpdb->prefix . 'afrisol_reviews';
    $sql_reviews = "CREATE TABLE IF NOT EXISTS $table_reviews (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        product_id bigint(20) NOT NULL,
        user_id bigint(20) DEFAULT NULL,
        reviewer_name varchar(255) NOT NULL,
        reviewer_email varchar(255),
        rating int(1) NOT NULL,
        review_text text,
        status varchar(50) DEFAULT 'pending',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY product_id (product_id)
    ) $charset_collate;";

    // Loyalty points table
    $table_loyalty = $wpdb->prefix . 'afrisol_loyalty';
    $sql_loyalty = "CREATE TABLE IF NOT EXISTS $table_loyalty (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        points int(11) DEFAULT 0,
        total_earned int(11) DEFAULT 0,
        total_redeemed int(11) DEFAULT 0,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY user_id (user_id)
    ) $charset_collate;";

    // Referrals table
    $table_referrals = $wpdb->prefix . 'afrisol_referrals';
    $sql_referrals = "CREATE TABLE IF NOT EXISTS $table_referrals (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        referrer_id bigint(20) NOT NULL,
        referred_id bigint(20) NOT NULL,
        referral_code varchar(50) NOT NULL,
        status varchar(50) DEFAULT 'pending',
        reward_given tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Notify me table
    $table_notify = $wpdb->prefix . 'afrisol_notify';
    $sql_notify = "CREATE TABLE IF NOT EXISTS $table_notify (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        product_id bigint(20) NOT NULL,
        email varchar(255) NOT NULL,
        notified tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_cart);
    dbDelta($sql_orders);
    dbDelta($sql_order_items);
    dbDelta($sql_quotes);
    dbDelta($sql_repairs);
    dbDelta($sql_wishlist);
    dbDelta($sql_reviews);
    dbDelta($sql_loyalty);
    dbDelta($sql_referrals);
    dbDelta($sql_notify);
}

/**
 * Set default plugin options
 */
function afrisol_set_default_options() {
    $defaults = array(
        'company_name' => 'Afrisol',
        'tagline' => 'Solar Solutions for a Sustainable Africa',
        'phone' => '+234 XXX XXX XXXX',
        'email' => 'info@afrisol.com',
        'whatsapp' => '+234 XXX XXX XXXX',
        'address' => 'Suite 15C, Al-Noor Shopping Complex, Al-Noor Mosque, Ahmadu Bello Way Wuse 2, Abuja.',
        'facebook' => 'https://facebook.com/afrisol',
        'instagram' => 'https://instagram.com/afrisol',
        'tiktok' => 'https://tiktok.com/@afrisol',
        'business_hours' => 'Mon-Fri: 8AM-6PM, Sat: 9AM-4PM',
        'primary_color' => '#1B5E20',
        'secondary_color' => '#FF9800',
        'paystack_public_key' => '',
        'paystack_secret_key' => '',
        'google_maps_api_key' => '',
    );
    
    foreach ($defaults as $key => $value) {
        if (get_option('afrisol_' . $key) === false) {
            add_option('afrisol_' . $key, $value);
        }
    }
}

/**
 * Load plugin classes
 */
function afrisol_load_classes() {
    // Post types
    require_once AFRISOL_PLUGIN_DIR . 'includes/post-types/class-afrisol-post-types.php';
    
    // Core classes
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-cart.php';
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-orders.php';
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-quotes.php';
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-repairs.php';
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-reviews.php';
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-wishlist.php';
    require_once AFRISOL_PLUGIN_DIR . 'includes/class-afrisol-loyalty.php';
    
    // Shortcodes
    require_once AFRISOL_PLUGIN_DIR . 'includes/shortcodes/class-afrisol-shortcodes.php';
    
    // Widgets
    require_once AFRISOL_PLUGIN_DIR . 'includes/widgets/class-afrisol-widgets.php';
    
    // API
    require_once AFRISOL_PLUGIN_DIR . 'includes/api/class-afrisol-api.php';
    
    // Admin
    if (is_admin()) {
        require_once AFRISOL_PLUGIN_DIR . 'admin/class-afrisol-admin.php';
    }
}
add_action('plugins_loaded', 'afrisol_load_classes');

/**
 * Register custom post types
 */
function afrisol_register_post_types() {
    if (class_exists('Afrisol_Post_Types')) {
        Afrisol_Post_Types::register();
    }
}
add_action('init', 'afrisol_register_post_types');

/**
 * Enqueue frontend styles and scripts
 */
function afrisol_enqueue_scripts() {
    // Google Fonts - Montserrat and Open Sans
    wp_enqueue_style(
        'afrisol-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap',
        array(),
        AFRISOL_VERSION
    );
    
    // Font Awesome for icons
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
        array(),
        '6.4.2'
    );
    
    // Swiper CSS for sliders
    wp_enqueue_style(
        'swiper',
        'https://cdnjs.cloudflare.com/ajax/libs/Swiper/10.3.1/swiper-bundle.min.css',
        array(),
        '10.3.1'
    );
    
    // Main plugin styles
    wp_enqueue_style(
        'afrisol-main',
        AFRISOL_PLUGIN_URL . 'assets/css/main.css',
        array(),
        AFRISOL_VERSION
    );
    
    // Components styles
    wp_enqueue_style(
        'afrisol-components',
        AFRISOL_PLUGIN_URL . 'assets/css/components.css',
        array('afrisol-main'),
        AFRISOL_VERSION
    );
    
    // Pages styles
    wp_enqueue_style(
        'afrisol-pages',
        AFRISOL_PLUGIN_URL . 'assets/css/pages.css',
        array('afrisol-main'),
        AFRISOL_VERSION
    );
    
    // Swiper JS
    wp_enqueue_script(
        'swiper',
        'https://cdnjs.cloudflare.com/ajax/libs/Swiper/10.3.1/swiper-bundle.min.js',
        array(),
        '10.3.1',
        true
    );
    
    // Main plugin script
    wp_enqueue_script(
        'afrisol-main',
        AFRISOL_PLUGIN_URL . 'assets/js/main.js',
        array('jquery', 'swiper'),
        AFRISOL_VERSION,
        true
    );
    
    // Components script
    wp_enqueue_script(
        'afrisol-components',
        AFRISOL_PLUGIN_URL . 'assets/js/components.js',
        array('jquery', 'afrisol-main'),
        AFRISOL_VERSION,
        true
    );
    
    // Localize script with AJAX URL and other data
    wp_localize_script('afrisol-main', 'afrisol_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('afrisol_nonce'),
        'plugin_url' => AFRISOL_PLUGIN_URL,
        'paystack_key' => get_option('afrisol_paystack_public_key'),
        'currency' => 'NGN',
    ));
}
add_action('wp_enqueue_scripts', 'afrisol_enqueue_scripts');

/**
 * Enqueue admin styles and scripts
 */
function afrisol_admin_enqueue_scripts($hook) {
    // Only load on Afrisol admin pages
    if (strpos($hook, 'afrisol') === false && strpos($hook, 'afrisol') === false) {
        // Also check post type screens
        $screen = get_current_screen();
        if (!$screen || !in_array($screen->post_type, array('afrisol_product', 'afrisol_service', 'afrisol_testimonial'))) {
            return;
        }
    }
    
    // Admin styles
    wp_enqueue_style(
        'afrisol-admin',
        AFRISOL_PLUGIN_URL . 'admin/css/admin.css',
        array(),
        AFRISOL_VERSION
    );
    
    // Media uploader
    wp_enqueue_media();
    
    // Admin scripts
    wp_enqueue_script(
        'afrisol-admin',
        AFRISOL_PLUGIN_URL . 'admin/js/admin.js',
        array('jquery', 'wp-color-picker'),
        AFRISOL_VERSION,
        true
    );
    
    wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'afrisol_admin_enqueue_scripts');

/**
 * Add PWA manifest and site icons
 */
function afrisol_add_pwa_manifest() {
    $images_url = AFRISOL_PLUGIN_URL . 'assets/images/';
    
    // Favicon
    echo '<link rel="icon" type="image/x-icon" href="' . esc_url($images_url) . 'favicon.ico">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url($images_url) . 'favicon-16.png">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($images_url) . 'favicon-32.png">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="48x48" href="' . esc_url($images_url) . 'favicon-48.png">' . "\n";
    
    // PWA manifest
    echo '<link rel="manifest" href="' . esc_url(AFRISOL_PLUGIN_URL) . 'manifest.json">' . "\n";
    echo '<meta name="theme-color" content="#1B5E20">' . "\n";
    
    // Apple specific
    echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($images_url) . 'apple-touch-icon.png">' . "\n";
}
add_action('wp_head', 'afrisol_add_pwa_manifest');

/**
 * Register service worker
 */
function afrisol_register_service_worker() {
    ?>
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('<?php echo AFRISOL_PLUGIN_URL; ?>sw.js')
            .then(function(registration) {
                console.log('Afrisol SW registered:', registration.scope);
            })
            .catch(function(error) {
                console.log('Afrisol SW registration failed:', error);
            });
        });
    }
    </script>
    <?php
}
add_action('wp_footer', 'afrisol_register_service_worker');

/**
 * Add WhatsApp widget to footer
 */
function afrisol_whatsapp_widget() {
    $whatsapp = get_option('afrisol_whatsapp', '+234 XXX XXX XXXX');
    $whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp);
    ?>
    <div class="afrisol-whatsapp-widget">
        <a href="https://wa.me/<?php echo esc_attr($whatsapp_clean); ?>?text=Hello%20Afrisol,%20I%20need%20assistance" 
           target="_blank" 
           rel="noopener noreferrer"
           class="whatsapp-btn"
           aria-label="Chat with us on WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span class="whatsapp-tooltip">Chat with us</span>
        </a>
    </div>
    <?php
}
add_action('wp_footer', 'afrisol_whatsapp_widget');

/**
 * Add scroll to top button
 */
function afrisol_scroll_to_top() {
    ?>
    <div class="afrisol-scroll-top" id="scrollTopBtn">
        <svg class="progress-ring" width="50" height="50">
            <circle class="progress-ring__circle" stroke="#FF9800" stroke-width="3" fill="transparent" r="22" cx="25" cy="25"/>
        </svg>
        <i class="fas fa-arrow-up"></i>
    </div>
    <?php
}
add_action('wp_footer', 'afrisol_scroll_to_top');

/**
 * Add PWA install prompt
 */
function afrisol_pwa_install_prompt() {
    ?>
    <div class="afrisol-pwa-prompt" id="pwaInstallPrompt" style="display: none;">
        <div class="pwa-prompt-content">
            <img src="<?php echo AFRISOL_PLUGIN_URL; ?>assets/images/logo-96.png" alt="Afrisol" class="pwa-logo">
            <div class="pwa-prompt-text">
                <h4>Install Afrisol App</h4>
                <p>Add to your home screen for quick access</p>
            </div>
            <div class="pwa-prompt-buttons">
                <button class="pwa-install-btn" id="pwaInstallBtn">Install</button>
                <button class="pwa-dismiss-btn" id="pwaDismissBtn">Not Now</button>
            </div>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'afrisol_pwa_install_prompt');

/**
 * Start session for cart functionality
 */
function afrisol_start_session() {
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }
    
    if (defined('REST_REQUEST') && REST_REQUEST) {
        return;
    }
    
    if (php_sapi_name() === 'cli') {
        return;
    }
    
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
}
add_action('init', 'afrisol_start_session', 1);

/**
 * Generate session ID for guest users
 */
function afrisol_get_session_id() {
    if (is_user_logged_in()) {
        return 'user_' . get_current_user_id();
    }
    
    // Ensure session is started
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    
    // Use cookie-based fallback if session not available
    if (session_status() !== PHP_SESSION_ACTIVE) {
        if (isset($_COOKIE['afrisol_session'])) {
            return sanitize_text_field($_COOKIE['afrisol_session']);
        }
        $session_id = wp_generate_uuid4();
        if (!headers_sent()) {
            setcookie('afrisol_session', $session_id, time() + (86400 * 30), '/');
        }
        return $session_id;
    }
    
    if (!isset($_SESSION['afrisol_session_id'])) {
        $_SESSION['afrisol_session_id'] = wp_generate_uuid4();
    }
    
    return $_SESSION['afrisol_session_id'];
}

/**
 * Load AJAX handlers
 */
function afrisol_load_ajax_handlers() {
    require_once AFRISOL_PLUGIN_DIR . 'includes/ajax-handlers.php';
}
add_action('init', 'afrisol_load_ajax_handlers');

/**
 * Add custom rewrite rules
 */
function afrisol_rewrite_rules() {
    add_rewrite_rule('^solar-calculator/?$', 'index.php?afrisol_page=solar-calculator', 'top');
    add_rewrite_rule('^get-quote/?$', 'index.php?afrisol_page=get-quote', 'top');
    add_rewrite_rule('^book-repair/?$', 'index.php?afrisol_page=book-repair', 'top');
    add_rewrite_rule('^customer-portal/?$', 'index.php?afrisol_page=customer-portal', 'top');
    add_rewrite_rule('^my-account/?$', 'index.php?afrisol_page=customer-portal', 'top');
    add_rewrite_rule('^cart/?$', 'index.php?afrisol_page=cart', 'top');
    add_rewrite_rule('^checkout/?$', 'index.php?afrisol_page=checkout', 'top');
    add_rewrite_rule('^products/?$', 'index.php?afrisol_page=products', 'top');
    add_rewrite_rule('^services/?$', 'index.php?afrisol_page=services', 'top');
    add_rewrite_rule('^about/?$', 'index.php?afrisol_page=about', 'top');
    add_rewrite_rule('^contact/?$', 'index.php?afrisol_page=contact', 'top');
    add_rewrite_rule('^blog/?$', 'index.php?afrisol_page=blog', 'top');
    add_rewrite_rule('^order-confirmation/?$', 'index.php?afrisol_page=order-confirmation', 'top');
}
add_action('init', 'afrisol_rewrite_rules');

/**
 * Add query vars
 */
function afrisol_query_vars($vars) {
    $vars[] = 'afrisol_page';
    return $vars;
}
add_filter('query_vars', 'afrisol_query_vars');

/**
 * Handle custom page templates
 */
function afrisol_template_include($template) {
    $afrisol_page = get_query_var('afrisol_page');
    
    if ($afrisol_page) {
        $custom_template = AFRISOL_PLUGIN_DIR . 'templates/' . $afrisol_page . '.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    
    return $template;
}
add_filter('template_include', 'afrisol_template_include');