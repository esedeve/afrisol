<?php
/**
 * Afrisol Cart Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Cart {
    private $table;
    private $session_id;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_cart';
        $this->session_id = afrisol_get_session_id();
    }

    /**
     * Add item to cart
     */
    public function add_item($product_id, $quantity = 1) {
        global $wpdb;

        // Check if item already exists in cart
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE session_id = %s AND product_id = %d",
            $this->session_id,
            $product_id
        ));

        if ($existing) {
            // Update quantity
            return $wpdb->update(
                $this->table,
                array('quantity' => $existing->quantity + $quantity),
                array('id' => $existing->id)
            );
        } else {
            // Insert new item
            return $wpdb->insert($this->table, array(
                'session_id' => $this->session_id,
                'user_id' => get_current_user_id() ?: null,
                'product_id' => $product_id,
                'quantity' => $quantity
            ));
        }
    }

    /**
     * Update item quantity
     */
    public function update_quantity($item_id, $quantity) {
        global $wpdb;

        if ($quantity <= 0) {
            return $this->remove_item($item_id);
        }

        return $wpdb->update(
            $this->table,
            array('quantity' => $quantity),
            array('id' => $item_id, 'session_id' => $this->session_id)
        );
    }

    /**
     * Remove item from cart
     */
    public function remove_item($item_id) {
        global $wpdb;

        return $wpdb->delete($this->table, array(
            'id' => $item_id,
            'session_id' => $this->session_id
        ));
    }

    /**
     * Get all cart items
     */
    public function get_items() {
        global $wpdb;

        $items = $wpdb->get_results($wpdb->prepare(
            "SELECT c.*, p.post_title as product_name 
             FROM {$this->table} c 
             LEFT JOIN {$wpdb->posts} p ON c.product_id = p.ID 
             WHERE c.session_id = %s",
            $this->session_id
        ));

        // Add product details
        foreach ($items as &$item) {
            $item->price = get_post_meta($item->product_id, '_afrisol_price', true);
            $item->sale_price = get_post_meta($item->product_id, '_afrisol_sale_price', true);
            $item->image = get_the_post_thumbnail_url($item->product_id, 'thumbnail');
            
            // Use sale price if available
            if ($item->sale_price && $item->sale_price < $item->price) {
                $item->final_price = $item->sale_price;
            } else {
                $item->final_price = $item->price;
            }
            
            $item->total = $item->final_price * $item->quantity;
        }

        return $items;
    }

    /**
     * Get cart count
     */
    public function get_count() {
        global $wpdb;

        return (int) $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(quantity) FROM {$this->table} WHERE session_id = %s",
            $this->session_id
        ));
    }

    /**
     * Get cart subtotal
     */
    public function get_subtotal() {
        $items = $this->get_items();
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item->total;
        }

        return $subtotal;
    }

    /**
     * Get cart tax
     */
    public function get_tax() {
        // 7.5% VAT in Nigeria
        return $this->get_subtotal() * 0.075;
    }

    /**
     * Get cart total
     */
    public function get_total() {
        return $this->get_subtotal() + $this->get_tax();
    }

    /**
     * Clear cart
     */
    public function clear() {
        global $wpdb;

        return $wpdb->delete($this->table, array(
            'session_id' => $this->session_id
        ));
    }

    /**
     * Merge guest cart with user cart on login
     */
    public function merge_carts($guest_session_id) {
        global $wpdb;

        if (!is_user_logged_in()) {
            return;
        }

        $user_session_id = 'user_' . get_current_user_id();

        // Get guest cart items
        $guest_items = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE session_id = %s",
            $guest_session_id
        ));

        foreach ($guest_items as $item) {
            // Check if product already in user cart
            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE session_id = %s AND product_id = %d",
                $user_session_id,
                $item->product_id
            ));

            if ($existing) {
                // Update quantity
                $wpdb->update(
                    $this->table,
                    array('quantity' => $existing->quantity + $item->quantity),
                    array('id' => $existing->id)
                );
            } else {
                // Move item to user cart
                $wpdb->update(
                    $this->table,
                    array('session_id' => $user_session_id, 'user_id' => get_current_user_id()),
                    array('id' => $item->id)
                );
            }
        }

        // Delete remaining guest items
        $wpdb->delete($this->table, array('session_id' => $guest_session_id));
    }
}