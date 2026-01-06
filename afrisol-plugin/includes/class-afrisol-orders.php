<?php
/**
 * Afrisol Orders Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Orders {
    private $table;
    private $items_table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_orders';
        $this->items_table = $wpdb->prefix . 'afrisol_order_items';
    }

    /**
     * Create new order
     */
    public function create($data, $items) {
        global $wpdb;

        // Generate order number
        $order_number = 'AFR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        $result = $wpdb->insert($this->table, array(
            'user_id' => $data['user_id'] ?: null,
            'order_number' => $order_number,
            'status' => 'pending',
            'subtotal' => $data['subtotal'],
            'tax' => $data['tax'],
            'shipping' => $data['shipping'] ?: 0,
            'total' => $data['total'],
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
            'transaction_id' => $data['transaction_id'] ?: null,
            'billing_address' => $data['billing_address'],
            'shipping_address' => $data['shipping_address'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'notes' => $data['notes'] ?: ''
        ));

        if (!$result) {
            return false;
        }

        $order_id = $wpdb->insert_id;

        // Add order items
        foreach ($items as $item) {
            $wpdb->insert($this->items_table, array(
                'order_id' => $order_id,
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->final_price,
                'total' => $item->total
            ));
        }

        // Award loyalty points
        if ($data['user_id']) {
            $loyalty = new Afrisol_Loyalty();
            $points = floor($data['total'] / 1000); // 1 point per 1000 NGN
            $loyalty->add_points($data['user_id'], $points);
        }

        return array(
            'order_id' => $order_id,
            'order_number' => $order_number,
            'total' => $data['total'],
            'customer_email' => $data['customer_email']
        );
    }

    /**
     * Get order by ID
     */
    public function get($order_id) {
        global $wpdb;

        $order = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE id = %d",
            $order_id
        ));

        if ($order) {
            $order->items = $this->get_items($order_id);
        }

        return $order;
    }

    /**
     * Get order by order number
     */
    public function get_by_number($order_number) {
        global $wpdb;

        $order = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE order_number = %s",
            $order_number
        ));

        if ($order) {
            $order->items = $this->get_items($order->id);
        }

        return $order;
    }

    /**
     * Get order items
     */
    public function get_items($order_id) {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->items_table} WHERE order_id = %d",
            $order_id
        ));
    }

    /**
     * Get user orders
     */
    public function get_user_orders($user_id, $limit = 10) {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE user_id = %d ORDER BY created_at DESC LIMIT %d",
            $user_id,
            $limit
        ));
    }

    /**
     * Update order status
     */
    public function update_status($order_id, $status) {
        global $wpdb;

        return $wpdb->update(
            $this->table,
            array('status' => $status),
            array('id' => $order_id)
        );
    }

    /**
     * Get all orders (admin)
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
     * Get order count
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
     * Get total revenue
     */
    public function get_total_revenue($start_date = '', $end_date = '') {
        global $wpdb;

        $where = "payment_status = 'completed'";
        
        if ($start_date) {
            $where .= $wpdb->prepare(" AND created_at >= %s", $start_date);
        }
        if ($end_date) {
            $where .= $wpdb->prepare(" AND created_at <= %s", $end_date);
        }

        return (float) $wpdb->get_var(
            "SELECT SUM(total) FROM {$this->table} WHERE {$where}"
        );
    }
}
