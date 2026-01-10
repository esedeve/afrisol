<?php
/**
 * Afrisol Reviews Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Reviews {
    private $table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_reviews';
    }

    /**
     * Create new review
     */
    public function create($data) {
        global $wpdb;

        $result = $wpdb->insert($this->table, array(
            'product_id' => $data['product_id'],
            'user_id' => $data['user_id'] ?: null,
            'reviewer_name' => $data['reviewer_name'],
            'reviewer_email' => $data['reviewer_email'] ?: '',
            'rating' => min(5, max(1, $data['rating'])),
            'review_text' => $data['review_text'] ?: '',
            'status' => 'pending'
        ));

        if ($result) {
            // Update product average rating
            $this->update_product_rating($data['product_id']);
        }

        return $result;
    }

    /**
     * Get product reviews
     */
    public function get_product_reviews($product_id, $args = array()) {
        global $wpdb;

        $defaults = array(
            'status' => 'approved',
            'limit' => 10,
            'offset' => 0
        );

        $args = wp_parse_args($args, $defaults);

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE product_id = %d AND status = %s ORDER BY created_at DESC LIMIT %d OFFSET %d",
            $product_id,
            $args['status'],
            $args['limit'],
            $args['offset']
        ));
    }

    /**
     * Get review count for product
     */
    public function get_product_review_count($product_id) {
        global $wpdb;

        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE product_id = %d AND status = 'approved'",
            $product_id
        ));
    }

    /**
     * Get average rating for product
     */
    public function get_product_rating($product_id) {
        global $wpdb;

        return $wpdb->get_var($wpdb->prepare(
            "SELECT AVG(rating) FROM {$this->table} WHERE product_id = %d AND status = 'approved'",
            $product_id
        ));
    }

    /**
     * Get rating breakdown for product
     */
    public function get_rating_breakdown($product_id) {
        global $wpdb;

        $breakdown = array();
        for ($i = 5; $i >= 1; $i--) {
            $breakdown[$i] = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$this->table} WHERE product_id = %d AND rating = %d AND status = 'approved'",
                $product_id,
                $i
            ));
        }

        return $breakdown;
    }

    /**
     * Update product average rating meta
     */
    private function update_product_rating($product_id) {
        $average = $this->get_product_rating($product_id);
        $count = $this->get_product_review_count($product_id);

        update_post_meta($product_id, '_afrisol_average_rating', $average);
        update_post_meta($product_id, '_afrisol_review_count', $count);
    }

    /**
     * Update review status
     */
    public function update_status($review_id, $status) {
        global $wpdb;

        $result = $wpdb->update(
            $this->table,
            array('status' => $status),
            array('id' => $review_id)
        );

        // Update product rating
        $review = $this->get($review_id);
        if ($review) {
            $this->update_product_rating($review->product_id);
        }

        return $result;
    }

    /**
     * Get review by ID
     */
    public function get($review_id) {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $review_id
        ));
    }

    /**
     * Get all reviews (admin)
     */
    public function get_all($args = array()) {
        global $wpdb;

        $defaults = array(
            'status' => '',
            'limit' => 20,
            'offset' => 0
        );

        $args = wp_parse_args($args, $defaults);

        $where = "1=1";
        if ($args['status']) {
            $where .= $wpdb->prepare(" AND status = %s", $args['status']);
        }

        return $wpdb->get_results($wpdb->prepare(
            "SELECT r.*, p.post_title as product_name 
             FROM {$this->table} r 
             LEFT JOIN {$wpdb->posts} p ON r.product_id = p.ID 
             WHERE {$where} 
             ORDER BY r.created_at DESC 
             LIMIT %d OFFSET %d",
            $args['limit'],
            $args['offset']
        ));
    }

    /**
     * Delete review
     */
    public function delete($review_id) {
        global $wpdb;

        $review = $this->get($review_id);
        $result = $wpdb->delete($this->table, array('id' => $review_id));

        if ($result && $review) {
            $this->update_product_rating($review->product_id);
        }

        return $result;
    }
}