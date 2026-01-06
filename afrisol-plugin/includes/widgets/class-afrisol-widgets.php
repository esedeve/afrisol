<?php
/**
 * Afrisol Widgets
 * Register sidebar widgets for Afrisol plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Featured Products Widget
 */
class Afrisol_Featured_Products_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'afrisol_featured_products',
            __('Afrisol Featured Products', 'afrisol'),
            array('description' => __('Display featured products', 'afrisol'))
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Featured Products', 'afrisol');
        $count = !empty($instance['count']) ? intval($instance['count']) : 4;

        $products = get_posts(array(
            'post_type' => 'afrisol_product',
            'posts_per_page' => $count,
            'meta_key' => '_afrisol_featured',
            'meta_value' => '1'
        ));

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];

        if ($products) {
            echo '<ul class="afrisol-widget-products">';
            foreach ($products as $product) {
                $price = get_post_meta($product->ID, '_afrisol_price', true);
                ?>
                <li class="afrisol-widget-product">
                    <a href="<?php echo get_permalink($product->ID); ?>">
                        <?php if (has_post_thumbnail($product->ID)) : ?>
                            <?php echo get_the_post_thumbnail($product->ID, 'thumbnail'); ?>
                        <?php endif; ?>
                        <div class="widget-product-info">
                            <h5><?php echo esc_html($product->post_title); ?></h5>
                            <span class="widget-product-price">₦<?php echo number_format($price); ?></span>
                        </div>
                    </a>
                </li>
                <?php
            }
            echo '</ul>';
        } else {
            echo '<p>' . __('No featured products found.', 'afrisol') . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Featured Products', 'afrisol');
        $count = !empty($instance['count']) ? intval($instance['count']) : 4;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'afrisol'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php _e('Number of products:', 'afrisol'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" min="1" max="10" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['count'] = !empty($new_instance['count']) ? intval($new_instance['count']) : 4;
        return $instance;
    }
}

/**
 * Solar Calculator Widget
 */
class Afrisol_Solar_Calculator_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'afrisol_solar_calculator',
            __('Afrisol Solar Calculator', 'afrisol'),
            array('description' => __('Quick solar savings calculator', 'afrisol'))
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Calculate Your Savings', 'afrisol');

        echo $args['before_widget'];
        ?>
        <div class="afrisol-widget-calculator">
            <h4 class="widget-title"><?php echo esc_html($title); ?></h4>
            <p>Find out how much you can save with solar power.</p>
            <a href="<?php echo home_url('/solar-calculator'); ?>" class="afrisol-btn afrisol-btn-primary afrisol-btn-sm afrisol-btn-block">
                <i class="fas fa-calculator"></i> Calculate Now
            </a>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Calculate Your Savings', 'afrisol');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'afrisol'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Contact Info Widget
 */
class Afrisol_Contact_Info_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'afrisol_contact_info',
            __('Afrisol Contact Info', 'afrisol'),
            array('description' => __('Display contact information', 'afrisol'))
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Contact Us', 'afrisol');

        $phone = get_option('afrisol_phone');
        $email = get_option('afrisol_email');
        $address = get_option('afrisol_address');
        $whatsapp = get_option('afrisol_whatsapp');

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        ?>
        <ul class="afrisol-widget-contact">
            <?php if ($phone) : ?>
            <li>
                <i class="fas fa-phone-alt"></i>
                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>"><?php echo esc_html($phone); ?></a>
            </li>
            <?php endif; ?>
            <?php if ($email) : ?>
            <li>
                <i class="fas fa-envelope"></i>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </li>
            <?php endif; ?>
            <?php if ($whatsapp) : ?>
            <li>
                <i class="fab fa-whatsapp"></i>
                <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $whatsapp); ?>" target="_blank">WhatsApp Us</a>
            </li>
            <?php endif; ?>
            <?php if ($address) : ?>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                <span><?php echo esc_html($address); ?></span>
            </li>
            <?php endif; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Contact Us', 'afrisol');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'afrisol'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p><em><?php _e('Contact info is pulled from plugin settings.', 'afrisol'); ?></em></p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * Register widgets
 */
function afrisol_register_widgets() {
    register_widget('Afrisol_Featured_Products_Widget');
    register_widget('Afrisol_Solar_Calculator_Widget');
    register_widget('Afrisol_Contact_Info_Widget');
}
add_action('widgets_init', 'afrisol_register_widgets');
