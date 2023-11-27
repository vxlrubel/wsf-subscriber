<?php
/*
Plugin Name: WSF Subscriber
Description: An intuitive plugin for managing email subscriptions on WordPress.
Version: 2.0
Author: Rubel Mahmud ( Sujan )
*/

// Add your plugin functionalities here
// For demonstration purposes, let's include the description in the plugin page

// use Wsf\Inc\Subscribe_REST_API_CONTROLLER;


define('DOMAIN', 'wp-subcribe' );
define('WSF_VERSION', '1.0' );

use Wsf\Inc\Admin\Dashboard_Menu;
use Wsf\Inc\Admin\Ajax_Handler;

require_once dirname(__FILE__) . '/inc/autoload.php';


final class WSF_Subscriber{

    // create private instance
    private static $instance;

    public $table = 'email_subscribers';

    public function __construct(){

        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts'] );

        // control rest route
        // new Subscribe_REST_API_CONTROLLER;

        // create dashboard menu
        new Dashboard_Menu;

        // add new subscriber
        new Ajax_Handler;
        
        // create database table
        register_activation_hook( __FILE__, [ $this, 'create_subscribers_table' ] );

    }
    
    /**
     * enqueue stylesheet and scripts
     *
     * @return void
     */
    public function enqueue_admin_scripts(){
        wp_enqueue_style('wp-subscribe-styles', plugins_url('assets/css/admin/admin-style.css', __FILE__), [], WSF_VERSION, 'all');
        wp_enqueue_script( 'wp-subscribe-scripts', plugins_url('assets/js/admin/admin-script.js', __FILE__), ['jquery'], WSF_VERSION, true );
        wp_localize_script( 'wp-subscribe-scripts', 'ws', [
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ] );
    }
    /**
     * store instance
     *
     * @return type object[] self::$instance
     */
    public static function get_instance(){

        if( is_null( self::$instance ) )
            self::$instance = new self();

        return self::$instance;
    }

    /**
     * create database table called email_subscribers
     *
     * @return void
     */
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

function wsf_subscriber(){
    return WSF_Subscriber::get_instance();
}
wsf_subscriber();