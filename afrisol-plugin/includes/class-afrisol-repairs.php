<?php
/**
 * Afrisol Repairs Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Repairs {
    private $table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_repairs';
    }

    /**
     * Create new repair request
     */
    public function create($data) {
        global $wpdb;

        // Generate ticket number
        $ticket_number = 'RPR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $result = $wpdb->insert($this->table, array(
            'ticket_number' => $ticket_number,
            'equipment_type' => $data['equipment_type'],
            'brand_model' => $data['brand_model'] ?: '',
            'problem_description' => $data['problem_description'],
            'warranty_status' => $data['warranty_status'] ?: 0,
            'service_type' => $data['service_type'] ?: 'onsite',
            'urgency' => $data['urgency'] ?: 'normal',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?: '',
            'status' => 'pending'
        ));

        if (!$result) {
            return false;
        }

        return array(
            'repair_id' => $wpdb->insert_id,
            'ticket_number' => $ticket_number
        );
    }

    /**
     * Get repair by ID
     */
    public function get($repair_id) {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $repair_id
        ));
    }

    /**
     * Get repair by ticket number
     */
    public function get_by_ticket($ticket_number) {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE ticket_number = %s",
            $ticket_number
        ));
    }

    /**
     * Update repair status
     */
    public function update_status($repair_id, $status) {
        global $wpdb;

        return $wpdb->update(
            $this->table,
            array('status' => $status),
            array('id' => $repair_id)
        );
    }

    /**
     * Get user repairs
     */
    public function get_user_repairs($email, $limit = 10) {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE customer_email = %s ORDER BY created_at DESC LIMIT %d",
            $email,
            $limit
        ));
    }

    /**
     * Get all repairs (admin)
     */
    public function get_all($args = array()) {
        global $wpdb;

        $defaults = array(
            'status' => '',
            'urgency' => '',
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
        if ($args['urgency']) {
            $where .= $wpdb->prepare(" AND urgency = %s", $args['urgency']);
        }

        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderby} LIMIT %d OFFSET %d",
            $args['limit'],
            $args['offset']
        ));
    }

    /**
     * Get repair count
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
}
