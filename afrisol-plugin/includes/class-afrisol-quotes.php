<?php
/**
 * Afrisol Quotes Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Quotes {
    private $table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_quotes';
    }

    /**
     * Create new quote request
     */
    public function create($data) {
        global $wpdb;

        // Generate quote number
        $quote_number = 'QTE-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $result = $wpdb->insert($this->table, array(
            'quote_number' => $quote_number,
            'service_type' => $data['service_type'],
            'category' => $data['category'] ?: '',
            'project_details' => $data['project_details'] ?: '',
            'location' => $data['location'] ?: '',
            'budget_range' => $data['budget_range'] ?: '',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?: '',
            'customer_whatsapp' => $data['customer_whatsapp'] ?: '',
            'preferred_contact' => $data['preferred_contact'] ?: '',
            'best_time' => $data['best_time'] ?: '',
            'status' => 'pending'
        ));

        if (!$result) {
            return false;
        }

        return array(
            'quote_id' => $wpdb->insert_id,
            'quote_number' => $quote_number
        );
    }

    /**
     * Get quote by ID
     */
    public function get($quote_id) {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $quote_id
        ));
    }

    /**
     * Get quote by number
     */
    public function get_by_number($quote_number) {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE quote_number = %s",
            $quote_number
        ));
    }

    /**
     * Update quote status
     */
    public function update_status($quote_id, $status) {
        global $wpdb;

        return $wpdb->update(
            $this->table,
            array('status' => $status),
            array('id' => $quote_id)
        );
    }

    /**
     * Get all quotes (admin)
     */
    public function get_all($args = array()) {
        global $wpdb;

        $defaults = array(
            'status' => '',
            'limit' => 20,
            'offset' => 0,
            'orderby' => 'created_at',
            'order' => 'DESC'
        );

        $args = wp_parse_args($args, $defaults);

        $where = "1=1";
        if ($args['status']) {
            $where .= $wpdb->prepare(" AND status = %s", $args['status']);
        }

        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderby} LIMIT %d OFFSET %d",
            $args['limit'],
            $args['offset']
        ));
    }

    /**
     * Get quote count
     */
    public function get_count($status = '') {
        global $wpdb;

        if ($status) {
            return $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$this->table} WHERE status = %s",
                $status
            ));
        }

        return $wpdb->get_var("SELECT COUNT(*) FROM {$this->table}");
    }

    /**
     * Delete quote
     */
    public function delete($quote_id) {
        global $wpdb;

        return $wpdb->delete($this->table, array('id' => $quote_id));
    }
}
