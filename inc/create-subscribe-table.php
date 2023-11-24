<?php


namespace Wsf\Inc;

// direncty access denied
defined('ABSPATH') || exit;

class Create_Table{

    protected $table = 'email_subscribers';

    public function __construct(){
        register_activation_hook( __FILE__, [ $this, 'create_subscribers_table' ] );
    }

    public function create_subscribers_table(){
        global $wpdb;

        $table = $wpdb->prefix . $this->table;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table(
             id mediumint(9) NOT NULL AUTO_INCREMENT,
             email VARCHAR(55) NOT NULL UNIQUE,
             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
             updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
             PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // execute the query to create table
        dbDelta( $sql );

    }
}