<?php
/**
 * Afrisol Wishlist Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Wishlist {
    private $table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_wishlist';
    }

    /**
     * Add product to wishlist
     */
    public function add($product_id) {
        global $wpdb;

        if (!is_user_logged_in()) {
            return false;
        }

        $user_id = get_current_user_id();

        // Check if already in wishlist
        if ($this->is_in_wishlist($product_id)) {
            return true;
        }

        return $wpdb->insert($this->table, array(
            'user_id' => $user_id,
            'product_id' => $product_id
        ));
    }

    /**
     * Remove product from wishlist
     */
    public function remove($product_id) {
        global $wpdb;

        if (!is_user_logged_in()) {
            return false;
        }

        return $wpdb->delete($this->table, array(
            'user_id' => get_current_user_id(),
            'product_id' => $product_id
        ));
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle($product_id) {
        if ($this->is_in_wishlist($product_id)) {
            $this->remove($product_id);
            return false;
        } else {
            $this->add($product_id);
            return true;
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function is_in_wishlist($product_id) {
        global $wpdb;

        if (!is_user_logged_in()) {
            return false;
        }

        return (bool) $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->table} WHERE user_id = %d AND product_id = %d",
            get_current_user_id(),
            $product_id
        ));
    }

    /**
     * Get user wishlist
     */
    public function get_items($user_id = null) {
        global $wpdb;

        if (!$user_id) {
            if (!is_user_logged_in()) {
                return array();
            }
            $user_id = get_current_user_id();
        }

        $items = $wpdb->get_results($wpdb->prepare(
            "SELECT w.*, p.post_title as product_name 
             FROM {$this->table} w 
             LEFT JOIN {$wpdb->posts} p ON w.product_id = p.ID 
             WHERE w.user_id = %d 
             ORDER BY w.created_at DESC",
            $user_id
        ));

        // Add product details
        foreach ($items as &$item) {
            $item->price = get_post_meta($item->product_id, '_afrisol_price', true);
            $item->sale_price = get_post_meta($item->product_id, '_afrisol_sale_price', true);
            $item->image = get_the_post_thumbnail_url($item->product_id, 'thumbnail');
            $item->stock_status = get_post_meta($item->product_id, '_afrisol_stock_status', true);
        }

        return $items;
    }

    /**
     * Get wishlist count
     */
    public function get_count($user_id = null) {
        global $wpdb;

        if (!$user_id) {
            if (!is_user_logged_in()) {
                return 0;
            }
            $user_id = get_current_user_id();
        }

        return (int) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE user_id = %d",
            $user_id
        ));
    }

    /**
     * Clear wishlist
     */
    public function clear($user_id = null) {
        global $wpdb;

        if (!$user_id) {
            if (!is_user_logged_in()) {
                return false;
            }
            $user_id = get_current_user_id();
        }

        return $wpdb->delete($this->table, array('user_id' => $user_id));
    }
}
