<?php
/**
 * Afrisol Loyalty Points Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class Afrisol_Loyalty {
    private $table;

    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'afrisol_loyalty';
    }

    /**
     * Get user points
     */
    public function get_points($user_id) {
        global $wpdb;

        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE user_id = %d",
            $user_id
        ));

        if (!$record) {
            return 0;
        }

        return $record->points;
    }

    /**
     * Add points
     */
    public function add_points($user_id, $points) {
        global $wpdb;

        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE user_id = %d",
            $user_id
        ));

        if ($record) {
            return $wpdb->update(
                $this->table,
                array(
                    'points' => $record->points + $points,
                    'total_earned' => $record->total_earned + $points
                ),
                array('user_id' => $user_id)
            );
        } else {
            return $wpdb->insert($this->table, array(
                'user_id' => $user_id,
                'points' => $points,
                'total_earned' => $points,
                'total_redeemed' => 0
            ));
        }
    }

    /**
     * Redeem points
     */
    public function redeem_points($user_id, $points) {
        global $wpdb;

        $current = $this->get_points($user_id);

        if ($current < $points) {
            return false;
        }

        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE user_id = %d",
            $user_id
        ));

        return $wpdb->update(
            $this->table,
            array(
                'points' => $record->points - $points,
                'total_redeemed' => $record->total_redeemed + $points
            ),
            array('user_id' => $user_id)
        );
    }

    /**
     * Get points value in currency
     */
    public function get_points_value($points) {
        // 1 point = 10 NGN
        return $points * 10;
    }

    /**
     * Get user loyalty info
     */
    public function get_user_info($user_id) {
        global $wpdb;

        $record = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE user_id = %d",
            $user_id
        ));

        if (!$record) {
            return array(
                'points' => 0,
                'total_earned' => 0,
                'total_redeemed' => 0,
                'value' => 0,
                'tier' => 'Bronze'
            );
        }

        // Determine tier based on total earned
        $tier = 'Bronze';
        if ($record->total_earned >= 10000) {
            $tier = 'Gold';
        } elseif ($record->total_earned >= 5000) {
            $tier = 'Silver';
        }

        return array(
            'points' => $record->points,
            'total_earned' => $record->total_earned,
            'total_redeemed' => $record->total_redeemed,
            'value' => $this->get_points_value($record->points),
            'tier' => $tier
        );
    }
}
