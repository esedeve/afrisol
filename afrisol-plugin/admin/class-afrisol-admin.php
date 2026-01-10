<?php
/**
 * Afrisol Admin Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        // Main menu
        add_menu_page(
            __('Afrisol', 'afrisol'),
            __('Afrisol', 'afrisol'),
            'manage_options',
            'afrisol',
            array($this, 'dashboard_page'),
            'dashicons-admin-home',
            3
        );

        // Dashboard
        add_submenu_page(
            'afrisol',
            __('Dashboard', 'afrisol'),
            __('Dashboard', 'afrisol'),
            'manage_options',
            'afrisol',
            array($this, 'dashboard_page')
        );

        // Orders
        add_submenu_page(
            'afrisol',
            __('Orders', 'afrisol'),
            __('Orders', 'afrisol'),
            'manage_options',
            'afrisol-orders',
            array($this, 'orders_page')
        );

        // Quotes
        add_submenu_page(
            'afrisol',
            __('Quote Requests', 'afrisol'),
            __('Quotes', 'afrisol'),
            'manage_options',
            'afrisol-quotes',
            array($this, 'quotes_page')
        );

        // Repairs
        add_submenu_page(
            'afrisol',
            __('Repair Tickets', 'afrisol'),
            __('Repairs', 'afrisol'),
            'manage_options',
            'afrisol-repairs',
            array($this, 'repairs_page')
        );

        // Reviews
        add_submenu_page(
            'afrisol',
            __('Reviews', 'afrisol'),
            __('Reviews', 'afrisol'),
            'manage_options',
            'afrisol-reviews',
            array($this, 'reviews_page')
        );

        // Settings
        add_submenu_page(
            'afrisol',
            __('Settings', 'afrisol'),
            __('Settings', 'afrisol'),
            'manage_options',
            'afrisol-settings',
            array($this, 'settings_page')
        );

        // Frontend Editor
        add_submenu_page(
            'afrisol',
            __('Frontend Editor', 'afrisol'),
            __('Frontend Editor', 'afrisol'),
            'manage_options',
            'afrisol-frontend-editor',
            array($this, 'frontend_editor_page')
        );
    }

    /**
     * Dashboard page
     */
    public function dashboard_page() {
        $orders = new Afrisol_Orders();
        $quotes = new Afrisol_Quotes();
        $repairs = new Afrisol_Repairs();

        $stats = array(
            'total_orders' => $orders->get_count(),
            'pending_orders' => $orders->get_count('pending'),
            'total_revenue' => $orders->get_total_revenue(),
            'pending_quotes' => $quotes->get_count('pending'),
            'pending_repairs' => $repairs->get_count('pending'),
        );
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Afrisol Dashboard', 'afrisol'); ?></h1>
            
            <div class="afrisol-admin-stats">
                <div class="afrisol-stat-box">
                    <div class="stat-icon"><span class="dashicons dashicons-cart"></span></div>
                    <div class="stat-content">
                        <h3><?php echo number_format($stats['total_orders']); ?></h3>
                        <p><?php _e('Total Orders', 'afrisol'); ?></p>
                    </div>
                </div>
                
                <div class="afrisol-stat-box">
                    <div class="stat-icon"><span class="dashicons dashicons-money-alt"></span></div>
                    <div class="stat-content">
                        <h3>₦<?php echo number_format($stats['total_revenue'], 2); ?></h3>
                        <p><?php _e('Total Revenue', 'afrisol'); ?></p>
                    </div>
                </div>
                
                <div class="afrisol-stat-box">
                    <div class="stat-icon"><span class="dashicons dashicons-format-quote"></span></div>
                    <div class="stat-content">
                        <h3><?php echo number_format($stats['pending_quotes']); ?></h3>
                        <p><?php _e('Pending Quotes', 'afrisol'); ?></p>
                    </div>
                </div>
                
                <div class="afrisol-stat-box">
                    <div class="stat-icon"><span class="dashicons dashicons-admin-tools"></span></div>
                    <div class="stat-content">
                        <h3><?php echo number_format($stats['pending_repairs']); ?></h3>
                        <p><?php _e('Pending Repairs', 'afrisol'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="afrisol-admin-panels">
                <div class="afrisol-panel">
                    <h2><?php _e('Recent Orders', 'afrisol'); ?></h2>
                    <?php
                    $recent_orders = $orders->get_all(array('limit' => 5));
                    if ($recent_orders) : ?>
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th><?php _e('Order', 'afrisol'); ?></th>
                                    <th><?php _e('Customer', 'afrisol'); ?></th>
                                    <th><?php _e('Total', 'afrisol'); ?></th>
                                    <th><?php _e('Status', 'afrisol'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_orders as $order) : ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($order->order_number); ?></strong></td>
                                        <td><?php echo esc_html($order->customer_name); ?></td>
                                        <td>₦<?php echo number_format($order->total, 2); ?></td>
                                        <td><span class="status-<?php echo esc_attr($order->status); ?>"><?php echo esc_html(ucfirst($order->status)); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p><?php _e('No orders yet.', 'afrisol'); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="afrisol-panel">
                    <h2><?php _e('Recent Quote Requests', 'afrisol'); ?></h2>
                    <?php
                    $recent_quotes = $quotes->get_all(array('limit' => 5));
                    if ($recent_quotes) : ?>
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th><?php _e('Quote #', 'afrisol'); ?></th>
                                    <th><?php _e('Customer', 'afrisol'); ?></th>
                                    <th><?php _e('Service', 'afrisol'); ?></th>
                                    <th><?php _e('Status', 'afrisol'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_quotes as $quote) : ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($quote->quote_number); ?></strong></td>
                                        <td><?php echo esc_html($quote->customer_name); ?></td>
                                        <td><?php echo esc_html($quote->service_type); ?></td>
                                        <td><span class="status-<?php echo esc_attr($quote->status); ?>"><?php echo esc_html(ucfirst($quote->status)); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p><?php _e('No quote requests yet.', 'afrisol'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Orders page
     */
    public function orders_page() {
        $orders = new Afrisol_Orders();
        $all_orders = $orders->get_all(array('limit' => 50));
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Orders', 'afrisol'); ?></h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Order', 'afrisol'); ?></th>
                        <th><?php _e('Date', 'afrisol'); ?></th>
                        <th><?php _e('Customer', 'afrisol'); ?></th>
                        <th><?php _e('Email', 'afrisol'); ?></th>
                        <th><?php _e('Total', 'afrisol'); ?></th>
                        <th><?php _e('Payment', 'afrisol'); ?></th>
                        <th><?php _e('Status', 'afrisol'); ?></th>
                        <th><?php _e('Actions', 'afrisol'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($all_orders) : foreach ($all_orders as $order) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($order->order_number); ?></strong></td>
                            <td><?php echo esc_html(date('M j, Y', strtotime($order->created_at))); ?></td>
                            <td><?php echo esc_html($order->customer_name); ?></td>
                            <td><?php echo esc_html($order->customer_email); ?></td>
                            <td>₦<?php echo number_format($order->total, 2); ?></td>
                            <td><span class="payment-<?php echo esc_attr($order->payment_status); ?>"><?php echo esc_html(ucfirst($order->payment_status)); ?></span></td>
                            <td>
                                <select class="afrisol-order-status" data-order-id="<?php echo esc_attr($order->id); ?>">
                                    <option value="pending" <?php selected($order->status, 'pending'); ?>><?php _e('Pending', 'afrisol'); ?></option>
                                    <option value="processing" <?php selected($order->status, 'processing'); ?>><?php _e('Processing', 'afrisol'); ?></option>
                                    <option value="shipped" <?php selected($order->status, 'shipped'); ?>><?php _e('Shipped', 'afrisol'); ?></option>
                                    <option value="delivered" <?php selected($order->status, 'delivered'); ?>><?php _e('Delivered', 'afrisol'); ?></option>
                                    <option value="cancelled" <?php selected($order->status, 'cancelled'); ?>><?php _e('Cancelled', 'afrisol'); ?></option>
                                </select>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=afrisol-orders&view=' . $order->id); ?>" class="button button-small"><?php _e('View', 'afrisol'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr><td colspan="8"><?php _e('No orders found.', 'afrisol'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Quotes page
     */
    public function quotes_page() {
        $quotes = new Afrisol_Quotes();
        $all_quotes = $quotes->get_all(array('limit' => 50));
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Quote Requests', 'afrisol'); ?></h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Quote #', 'afrisol'); ?></th>
                        <th><?php _e('Date', 'afrisol'); ?></th>
                        <th><?php _e('Customer', 'afrisol'); ?></th>
                        <th><?php _e('Service Type', 'afrisol'); ?></th>
                        <th><?php _e('Contact', 'afrisol'); ?></th>
                        <th><?php _e('Status', 'afrisol'); ?></th>
                        <th><?php _e('Actions', 'afrisol'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($all_quotes) : foreach ($all_quotes as $quote) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($quote->quote_number); ?></strong></td>
                            <td><?php echo esc_html(date('M j, Y', strtotime($quote->created_at))); ?></td>
                            <td><?php echo esc_html($quote->customer_name); ?></td>
                            <td><?php echo esc_html($quote->service_type); ?></td>
                            <td>
                                <?php echo esc_html($quote->customer_email); ?><br>
                                <?php echo esc_html($quote->customer_phone); ?>
                            </td>
                            <td>
                                <select class="afrisol-quote-status" data-quote-id="<?php echo esc_attr($quote->id); ?>">
                                    <option value="pending" <?php selected($quote->status, 'pending'); ?>><?php _e('Pending', 'afrisol'); ?></option>
                                    <option value="contacted" <?php selected($quote->status, 'contacted'); ?>><?php _e('Contacted', 'afrisol'); ?></option>
                                    <option value="quoted" <?php selected($quote->status, 'quoted'); ?>><?php _e('Quoted', 'afrisol'); ?></option>
                                    <option value="won" <?php selected($quote->status, 'won'); ?>><?php _e('Won', 'afrisol'); ?></option>
                                    <option value="lost" <?php selected($quote->status, 'lost'); ?>><?php _e('Lost', 'afrisol'); ?></option>
                                </select>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=afrisol-quotes&view=' . $quote->id); ?>" class="button button-small"><?php _e('View', 'afrisol'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr><td colspan="7"><?php _e('No quote requests found.', 'afrisol'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Repairs page
     */
    public function repairs_page() {
        $repairs = new Afrisol_Repairs();
        $all_repairs = $repairs->get_all(array('limit' => 50));
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Repair Tickets', 'afrisol'); ?></h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Ticket #', 'afrisol'); ?></th>
                        <th><?php _e('Date', 'afrisol'); ?></th>
                        <th><?php _e('Equipment', 'afrisol'); ?></th>
                        <th><?php _e('Customer', 'afrisol'); ?></th>
                        <th><?php _e('Urgency', 'afrisol'); ?></th>
                        <th><?php _e('Status', 'afrisol'); ?></th>
                        <th><?php _e('Actions', 'afrisol'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($all_repairs) : foreach ($all_repairs as $repair) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($repair->ticket_number); ?></strong></td>
                            <td><?php echo esc_html(date('M j, Y', strtotime($repair->created_at))); ?></td>
                            <td><?php echo esc_html($repair->equipment_type); ?></td>
                            <td>
                                <?php echo esc_html($repair->customer_name); ?><br>
                                <small><?php echo esc_html($repair->customer_phone); ?></small>
                            </td>
                            <td><span class="urgency-<?php echo esc_attr($repair->urgency); ?>"><?php echo esc_html(ucfirst($repair->urgency)); ?></span></td>
                            <td>
                                <select class="afrisol-repair-status" data-repair-id="<?php echo esc_attr($repair->id); ?>">
                                    <option value="pending" <?php selected($repair->status, 'pending'); ?>><?php _e('Pending', 'afrisol'); ?></option>
                                    <option value="diagnosed" <?php selected($repair->status, 'diagnosed'); ?>><?php _e('Diagnosed', 'afrisol'); ?></option>
                                    <option value="in_progress" <?php selected($repair->status, 'in_progress'); ?>><?php _e('In Progress', 'afrisol'); ?></option>
                                    <option value="completed" <?php selected($repair->status, 'completed'); ?>><?php _e('Completed', 'afrisol'); ?></option>
                                    <option value="cancelled" <?php selected($repair->status, 'cancelled'); ?>><?php _e('Cancelled', 'afrisol'); ?></option>
                                </select>
                            </td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=afrisol-repairs&view=' . $repair->id); ?>" class="button button-small"><?php _e('View', 'afrisol'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr><td colspan="7"><?php _e('No repair tickets found.', 'afrisol'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Reviews page
     */
    public function reviews_page() {
        $reviews = new Afrisol_Reviews();
        $all_reviews = $reviews->get_all(array('limit' => 50));
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Product Reviews', 'afrisol'); ?></h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('Product', 'afrisol'); ?></th>
                        <th><?php _e('Reviewer', 'afrisol'); ?></th>
                        <th><?php _e('Rating', 'afrisol'); ?></th>
                        <th><?php _e('Review', 'afrisol'); ?></th>
                        <th><?php _e('Status', 'afrisol'); ?></th>
                        <th><?php _e('Actions', 'afrisol'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($all_reviews) : foreach ($all_reviews as $review) : ?>
                        <tr>
                            <td><?php echo esc_html($review->product_name); ?></td>
                            <td><?php echo esc_html($review->reviewer_name); ?></td>
                            <td>
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <span class="dashicons dashicons-star-<?php echo $i <= $review->rating ? 'filled' : 'empty'; ?>"></span>
                                <?php endfor; ?>
                            </td>
                            <td><?php echo esc_html(wp_trim_words($review->review_text, 15)); ?></td>
                            <td>
                                <select class="afrisol-review-status" data-review-id="<?php echo esc_attr($review->id); ?>">
                                    <option value="pending" <?php selected($review->status, 'pending'); ?>><?php _e('Pending', 'afrisol'); ?></option>
                                    <option value="approved" <?php selected($review->status, 'approved'); ?>><?php _e('Approved', 'afrisol'); ?></option>
                                    <option value="rejected" <?php selected($review->status, 'rejected'); ?>><?php _e('Rejected', 'afrisol'); ?></option>
                                </select>
                            </td>
                            <td>
                                <button class="button button-small afrisol-delete-review" data-review-id="<?php echo esc_attr($review->id); ?>"><?php _e('Delete', 'afrisol'); ?></button>
                            </td>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr><td colspan="6"><?php _e('No reviews found.', 'afrisol'); ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    /**
     * Settings page
     */
    public function settings_page() {
        if (isset($_POST['afrisol_settings_nonce']) && wp_verify_nonce($_POST['afrisol_settings_nonce'], 'afrisol_save_settings')) {
            // Save settings
            $settings = array(
                'company_name', 'tagline', 'phone', 'email', 'whatsapp', 'address',
                'facebook', 'instagram', 'tiktok', 'business_hours',
                'primary_color', 'secondary_color',
                'paystack_public_key', 'paystack_secret_key', 'google_maps_api_key'
            );

            foreach ($settings as $setting) {
                if (isset($_POST['afrisol_' . $setting])) {
                    update_option('afrisol_' . $setting, sanitize_text_field($_POST['afrisol_' . $setting]));
                }
            }

            echo '<div class="notice notice-success"><p>' . __('Settings saved successfully!', 'afrisol') . '</p></div>';
        }
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Afrisol Settings', 'afrisol'); ?></h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('afrisol_save_settings', 'afrisol_settings_nonce'); ?>
                
                <div class="afrisol-settings-section">
                    <h2><?php _e('Company Information', 'afrisol'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><label for="afrisol_company_name"><?php _e('Company Name', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_company_name" name="afrisol_company_name" value="<?php echo esc_attr(get_option('afrisol_company_name')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_tagline"><?php _e('Tagline', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_tagline" name="afrisol_tagline" value="<?php echo esc_attr(get_option('afrisol_tagline')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_phone"><?php _e('Phone Number', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_phone" name="afrisol_phone" value="<?php echo esc_attr(get_option('afrisol_phone')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_email"><?php _e('Email Address', 'afrisol'); ?></label></th>
                            <td><input type="email" id="afrisol_email" name="afrisol_email" value="<?php echo esc_attr(get_option('afrisol_email')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_whatsapp"><?php _e('WhatsApp Number', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_whatsapp" name="afrisol_whatsapp" value="<?php echo esc_attr(get_option('afrisol_whatsapp')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_address"><?php _e('Address', 'afrisol'); ?></label></th>
                            <td><textarea id="afrisol_address" name="afrisol_address" class="large-text" rows="3"><?php echo esc_textarea(get_option('afrisol_address')); ?></textarea></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_business_hours"><?php _e('Business Hours', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_business_hours" name="afrisol_business_hours" value="<?php echo esc_attr(get_option('afrisol_business_hours')); ?>" class="regular-text"></td>
                        </tr>
                    </table>
                </div>
                
                <div class="afrisol-settings-section">
                    <h2><?php _e('Social Media', 'afrisol'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><label for="afrisol_facebook"><?php _e('Facebook URL', 'afrisol'); ?></label></th>
                            <td><input type="url" id="afrisol_facebook" name="afrisol_facebook" value="<?php echo esc_attr(get_option('afrisol_facebook')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_instagram"><?php _e('Instagram URL', 'afrisol'); ?></label></th>
                            <td><input type="url" id="afrisol_instagram" name="afrisol_instagram" value="<?php echo esc_attr(get_option('afrisol_instagram')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_tiktok"><?php _e('TikTok URL', 'afrisol'); ?></label></th>
                            <td><input type="url" id="afrisol_tiktok" name="afrisol_tiktok" value="<?php echo esc_attr(get_option('afrisol_tiktok')); ?>" class="regular-text"></td>
                        </tr>
                    </table>
                </div>
                
                <div class="afrisol-settings-section">
                    <h2><?php _e('Payment Settings', 'afrisol'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><label for="afrisol_paystack_public_key"><?php _e('Paystack Public Key', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_paystack_public_key" name="afrisol_paystack_public_key" value="<?php echo esc_attr(get_option('afrisol_paystack_public_key')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th><label for="afrisol_paystack_secret_key"><?php _e('Paystack Secret Key', 'afrisol'); ?></label></th>
                            <td><input type="password" id="afrisol_paystack_secret_key" name="afrisol_paystack_secret_key" value="<?php echo esc_attr(get_option('afrisol_paystack_secret_key')); ?>" class="regular-text"></td>
                        </tr>
                    </table>
                </div>
                
                <div class="afrisol-settings-section">
                    <h2><?php _e('API Keys', 'afrisol'); ?></h2>
                    <table class="form-table">
                        <tr>
                            <th><label for="afrisol_google_maps_api_key"><?php _e('Google Maps API Key', 'afrisol'); ?></label></th>
                            <td><input type="text" id="afrisol_google_maps_api_key" name="afrisol_google_maps_api_key" value="<?php echo esc_attr(get_option('afrisol_google_maps_api_key')); ?>" class="regular-text"></td>
                        </tr>
                    </table>
                </div>
                
                <?php submit_button(__('Save Settings', 'afrisol')); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Frontend Editor page
     */
    public function frontend_editor_page() {
        ?>
        <div class="wrap afrisol-admin-wrap">
            <h1><?php _e('Frontend Content Editor', 'afrisol'); ?></h1>
            <p><?php _e('Edit your website content sections here.', 'afrisol'); ?></p>
            
            <div class="afrisol-editor-tabs">
                <button class="afrisol-editor-tab active" data-tab="hero"><?php _e('Hero Section', 'afrisol'); ?></button>
                <button class="afrisol-editor-tab" data-tab="services"><?php _e('Services', 'afrisol'); ?></button>
                <button class="afrisol-editor-tab" data-tab="about"><?php _e('About', 'afrisol'); ?></button>
                <button class="afrisol-editor-tab" data-tab="contact"><?php _e('Contact', 'afrisol'); ?></button>
            </div>
            
            <div class="afrisol-editor-content">
                <div class="afrisol-editor-panel active" id="hero-panel">
                    <h2><?php _e('Hero Section', 'afrisol'); ?></h2>
                    <p><?php _e('Manage hero slides from the Hero Sliders menu.', 'afrisol'); ?></p>
                    <a href="<?php echo admin_url('edit.php?post_type=afrisol_slider'); ?>" class="button button-primary"><?php _e('Manage Hero Slides', 'afrisol'); ?></a>
                </div>
                
                <div class="afrisol-editor-panel" id="services-panel">
                    <h2><?php _e('Services', 'afrisol'); ?></h2>
                    <p><?php _e('Manage services from the Services menu.', 'afrisol'); ?></p>
                    <a href="<?php echo admin_url('edit.php?post_type=afrisol_service'); ?>" class="button button-primary"><?php _e('Manage Services', 'afrisol'); ?></a>
                </div>
                
                <div class="afrisol-editor-panel" id="about-panel">
                    <h2><?php _e('About Section', 'afrisol'); ?></h2>
                    <form method="post" id="afrisol-about-form">
                        <?php wp_nonce_field('afrisol_save_about', 'afrisol_about_nonce'); ?>
                        <table class="form-table">
                            <tr>
                                <th><label><?php _e('About Title', 'afrisol'); ?></label></th>
                                <td><input type="text" name="about_title" value="<?php echo esc_attr(get_option('afrisol_about_title', 'Why Choose Afrisol')); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label><?php _e('About Description', 'afrisol'); ?></label></th>
                                <td><textarea name="about_description" class="large-text" rows="4"><?php echo esc_textarea(get_option('afrisol_about_description')); ?></textarea></td>
                            </tr>
                        </table>
                        <?php submit_button(__('Save About Section', 'afrisol')); ?>
                    </form>
                </div>
                
                <div class="afrisol-editor-panel" id="contact-panel">
                    <h2><?php _e('Contact Section', 'afrisol'); ?></h2>
                    <p><?php _e('Contact information is managed in the Settings page.', 'afrisol'); ?></p>
                    <a href="<?php echo admin_url('admin.php?page=afrisol-settings'); ?>" class="button button-primary"><?php _e('Go to Settings', 'afrisol'); ?></a>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Add meta boxes for custom post types
     */
    public function add_meta_boxes() {
        // Product meta box
        add_meta_box(
            'afrisol_product_details',
            __('Product Details', 'afrisol'),
            array($this, 'product_meta_box'),
            'afrisol_product',
            'normal',
            'high'
        );

        // Service meta box
        add_meta_box(
            'afrisol_service_details',
            __('Service Details', 'afrisol'),
            array($this, 'service_meta_box'),
            'afrisol_service',
            'normal',
            'high'
        );

        // Testimonial meta box
        add_meta_box(
            'afrisol_testimonial_details',
            __('Testimonial Details', 'afrisol'),
            array($this, 'testimonial_meta_box'),
            'afrisol_testimonial',
            'normal',
            'high'
        );

        // Slider meta box
        add_meta_box(
            'afrisol_slider_details',
            __('Slider Details', 'afrisol'),
            array($this, 'slider_meta_box'),
            'afrisol_slider',
            'normal',
            'high'
        );

        // Team meta box
        add_meta_box(
            'afrisol_team_details',
            __('Team Member Details', 'afrisol'),
            array($this, 'team_meta_box'),
            'afrisol_team',
            'normal',
            'high'
        );
    }

    /**
     * Product meta box callback
     */
    public function product_meta_box($post) {
        wp_nonce_field('afrisol_product_meta', 'afrisol_product_nonce');
        
        $price = get_post_meta($post->ID, '_afrisol_price', true);
        $sale_price = get_post_meta($post->ID, '_afrisol_sale_price', true);
        $sku = get_post_meta($post->ID, '_afrisol_sku', true);
        $stock = get_post_meta($post->ID, '_afrisol_stock', true);
        $stock_status = get_post_meta($post->ID, '_afrisol_stock_status', true);
        $brand = get_post_meta($post->ID, '_afrisol_brand', true);
        $power_capacity = get_post_meta($post->ID, '_afrisol_power_capacity', true);
        $warranty = get_post_meta($post->ID, '_afrisol_warranty', true);
        $featured = get_post_meta($post->ID, '_afrisol_featured', true);
        $installment = get_post_meta($post->ID, '_afrisol_installment', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_price"><?php _e('Price (₦)', 'afrisol'); ?></label></th>
                <td><input type="number" id="afrisol_price" name="afrisol_price" value="<?php echo esc_attr($price); ?>" step="0.01" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_sale_price"><?php _e('Sale Price (₦)', 'afrisol'); ?></label></th>
                <td><input type="number" id="afrisol_sale_price" name="afrisol_sale_price" value="<?php echo esc_attr($sale_price); ?>" step="0.01" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_sku"><?php _e('SKU', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_sku" name="afrisol_sku" value="<?php echo esc_attr($sku); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_stock"><?php _e('Stock Quantity', 'afrisol'); ?></label></th>
                <td><input type="number" id="afrisol_stock" name="afrisol_stock" value="<?php echo esc_attr($stock); ?>" class="small-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_stock_status"><?php _e('Stock Status', 'afrisol'); ?></label></th>
                <td>
                    <select id="afrisol_stock_status" name="afrisol_stock_status">
                        <option value="instock" <?php selected($stock_status, 'instock'); ?>><?php _e('In Stock', 'afrisol'); ?></option>
                        <option value="lowstock" <?php selected($stock_status, 'lowstock'); ?>><?php _e('Low Stock', 'afrisol'); ?></option>
                        <option value="outofstock" <?php selected($stock_status, 'outofstock'); ?>><?php _e('Out of Stock', 'afrisol'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="afrisol_brand"><?php _e('Brand', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_brand" name="afrisol_brand" value="<?php echo esc_attr($brand); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_power_capacity"><?php _e('Power Capacity', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_power_capacity" name="afrisol_power_capacity" value="<?php echo esc_attr($power_capacity); ?>" class="regular-text" placeholder="e.g., 5kW, 100Ah"></td>
            </tr>
            <tr>
                <th><label for="afrisol_warranty"><?php _e('Warranty', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_warranty" name="afrisol_warranty" value="<?php echo esc_attr($warranty); ?>" class="regular-text" placeholder="e.g., 2 Years"></td>
            </tr>
            <tr>
                <th><label for="afrisol_installment"><?php _e('Installment Info', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_installment" name="afrisol_installment" value="<?php echo esc_attr($installment); ?>" class="regular-text" placeholder="e.g., Pay in 6 months"></td>
            </tr>
            <tr>
                <th><label for="afrisol_featured"><?php _e('Featured Product', 'afrisol'); ?></label></th>
                <td><input type="checkbox" id="afrisol_featured" name="afrisol_featured" value="1" <?php checked($featured, 1); ?>></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Service meta box callback
     */
    public function service_meta_box($post) {
        wp_nonce_field('afrisol_service_meta', 'afrisol_service_nonce');
        
        $icon = get_post_meta($post->ID, '_afrisol_service_icon', true);
        $price = get_post_meta($post->ID, '_afrisol_service_price', true);
        $timeline = get_post_meta($post->ID, '_afrisol_service_timeline', true);
        $guarantee = get_post_meta($post->ID, '_afrisol_service_guarantee', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_service_icon"><?php _e('Icon Class', 'afrisol'); ?></label></th>
                <td>
                    <input type="text" id="afrisol_service_icon" name="afrisol_service_icon" value="<?php echo esc_attr($icon); ?>" class="regular-text" placeholder="e.g., fas fa-solar-panel">
                    <p class="description"><?php _e('Use Font Awesome icon classes', 'afrisol'); ?></p>
                </td>
            </tr>
            <tr>
                <th><label for="afrisol_service_price"><?php _e('Starting Price', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_service_price" name="afrisol_service_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="e.g., From ₦50,000"></td>
            </tr>
            <tr>
                <th><label for="afrisol_service_timeline"><?php _e('Timeline', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_service_timeline" name="afrisol_service_timeline" value="<?php echo esc_attr($timeline); ?>" class="regular-text" placeholder="e.g., 1-3 days"></td>
            </tr>
            <tr>
                <th><label for="afrisol_service_guarantee"><?php _e('Guarantee', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_service_guarantee" name="afrisol_service_guarantee" value="<?php echo esc_attr($guarantee); ?>" class="regular-text" placeholder="e.g., 1 Year Warranty"></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Testimonial meta box callback
     */
    public function testimonial_meta_box($post) {
        wp_nonce_field('afrisol_testimonial_meta', 'afrisol_testimonial_nonce');
        
        $rating = get_post_meta($post->ID, '_afrisol_rating', true);
        $location = get_post_meta($post->ID, '_afrisol_location', true);
        $designation = get_post_meta($post->ID, '_afrisol_designation', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_rating"><?php _e('Rating', 'afrisol'); ?></label></th>
                <td>
                    <select id="afrisol_rating" name="afrisol_rating">
                        <?php for ($i = 5; $i >= 1; $i--) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> Stars</option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="afrisol_location"><?php _e('Location', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_location" name="afrisol_location" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="e.g., Abuja, Nigeria"></td>
            </tr>
            <tr>
                <th><label for="afrisol_designation"><?php _e('Designation', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_designation" name="afrisol_designation" value="<?php echo esc_attr($designation); ?>" class="regular-text" placeholder="e.g., CEO, ABC Company"></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Slider meta box callback
     */
    public function slider_meta_box($post) {
        wp_nonce_field('afrisol_slider_meta', 'afrisol_slider_nonce');
        
        $subtitle = get_post_meta($post->ID, '_afrisol_slider_subtitle', true);
        $cta_text = get_post_meta($post->ID, '_afrisol_slider_cta_text', true);
        $cta_link = get_post_meta($post->ID, '_afrisol_slider_cta_link', true);
        $order = get_post_meta($post->ID, '_afrisol_slider_order', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_slider_subtitle"><?php _e('Subtitle', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_slider_subtitle" name="afrisol_slider_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_slider_cta_text"><?php _e('CTA Button Text', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_slider_cta_text" name="afrisol_slider_cta_text" value="<?php echo esc_attr($cta_text); ?>" class="regular-text" placeholder="e.g., Get Free Quote"></td>
            </tr>
            <tr>
                <th><label for="afrisol_slider_cta_link"><?php _e('CTA Button Link', 'afrisol'); ?></label></th>
                <td><input type="url" id="afrisol_slider_cta_link" name="afrisol_slider_cta_link" value="<?php echo esc_attr($cta_link); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_slider_order"><?php _e('Display Order', 'afrisol'); ?></label></th>
                <td><input type="number" id="afrisol_slider_order" name="afrisol_slider_order" value="<?php echo esc_attr($order); ?>" class="small-text"></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Team meta box callback
     */
    public function team_meta_box($post) {
        wp_nonce_field('afrisol_team_meta', 'afrisol_team_nonce');
        
        $position = get_post_meta($post->ID, '_afrisol_position', true);
        $linkedin = get_post_meta($post->ID, '_afrisol_linkedin', true);
        $twitter = get_post_meta($post->ID, '_afrisol_twitter', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="afrisol_position"><?php _e('Position/Title', 'afrisol'); ?></label></th>
                <td><input type="text" id="afrisol_position" name="afrisol_position" value="<?php echo esc_attr($position); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_linkedin"><?php _e('LinkedIn URL', 'afrisol'); ?></label></th>
                <td><input type="url" id="afrisol_linkedin" name="afrisol_linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="afrisol_twitter"><?php _e('Twitter URL', 'afrisol'); ?></label></th>
                <td><input type="url" id="afrisol_twitter" name="afrisol_twitter" value="<?php echo esc_attr($twitter); ?>" class="regular-text"></td>
            </tr>
        </table>
        <?php
    }

    /**
     * Save meta boxes
     */
    public function save_meta_boxes($post_id) {
        // Product meta
        if (isset($_POST['afrisol_product_nonce']) && wp_verify_nonce($_POST['afrisol_product_nonce'], 'afrisol_product_meta')) {
            $fields = array('price', 'sale_price', 'sku', 'stock', 'stock_status', 'brand', 'power_capacity', 'warranty', 'installment');
            foreach ($fields as $field) {
                if (isset($_POST['afrisol_' . $field])) {
                    update_post_meta($post_id, '_afrisol_' . $field, sanitize_text_field($_POST['afrisol_' . $field]));
                }
            }
            update_post_meta($post_id, '_afrisol_featured', isset($_POST['afrisol_featured']) ? 1 : 0);
        }

        // Service meta
        if (isset($_POST['afrisol_service_nonce']) && wp_verify_nonce($_POST['afrisol_service_nonce'], 'afrisol_service_meta')) {
            $fields = array('service_icon', 'service_price', 'service_timeline', 'service_guarantee');
            foreach ($fields as $field) {
                if (isset($_POST['afrisol_' . $field])) {
                    update_post_meta($post_id, '_afrisol_' . $field, sanitize_text_field($_POST['afrisol_' . $field]));
                }
            }
        }

        // Testimonial meta
        if (isset($_POST['afrisol_testimonial_nonce']) && wp_verify_nonce($_POST['afrisol_testimonial_nonce'], 'afrisol_testimonial_meta')) {
            $fields = array('rating', 'location', 'designation');
            foreach ($fields as $field) {
                if (isset($_POST['afrisol_' . $field])) {
                    update_post_meta($post_id, '_afrisol_' . $field, sanitize_text_field($_POST['afrisol_' . $field]));
                }
            }
        }

        // Slider meta
        if (isset($_POST['afrisol_slider_nonce']) && wp_verify_nonce($_POST['afrisol_slider_nonce'], 'afrisol_slider_meta')) {
            $fields = array('slider_subtitle', 'slider_cta_text', 'slider_cta_link', 'slider_order');
            foreach ($fields as $field) {
                if (isset($_POST['afrisol_' . $field])) {
                    update_post_meta($post_id, '_afrisol_' . $field, sanitize_text_field($_POST['afrisol_' . $field]));
                }
            }
        }

        // Team meta
        if (isset($_POST['afrisol_team_nonce']) && wp_verify_nonce($_POST['afrisol_team_nonce'], 'afrisol_team_meta')) {
            $fields = array('position', 'linkedin', 'twitter');
            foreach ($fields as $field) {
                if (isset($_POST['afrisol_' . $field])) {
                    update_post_meta($post_id, '_afrisol_' . $field, sanitize_text_field($_POST['afrisol_' . $field]));
                }
            }
        }
    }
}

// Initialize admin
new Afrisol_Admin();