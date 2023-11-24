<?php
/*
Plugin Name: WSF Subscriber
Description: An intuitive plugin for managing email subscriptions on WordPress.
Version: 1.0
Author: Rubel Mahmud ( Sujan )
*/

// Add your plugin functionalities here
// For demonstration purposes, let's include the description in the plugin page

use Wsf\Inc\Subscribe_REST_API_CONTROLLER;
use Wsf\Inc\Create_Table;
use Wsf\Inc\Admin\Dashboard_Menu;

define('DOMAIN', 'wp-subcribe' );
define('WSF_VERSION', '1.0' );


require_once dirname(__FILE__) . '/inc/autoload.php';


final class Subscribe{

    // create private instance
    private static $instance;

    public function __construct(){

        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts'] );

        // control rest route
        new Subscribe_REST_API_CONTROLLER;

        // create table
        new Create_Table;

        // create dashboard menu
        new Dashboard_Menu;

    }
    
    /**
     * enqueue stylesheet and scripts
     *
     * @return void
     */
    public function enqueue_admin_scripts(){
        wp_enqueue_style('wp-subscribe-styles', plugins_url('assets/css/admin/admin-style.css', __FILE__), [], WSF_VERSION, 'all');
        wp_enqueue_script( 'wp-subscribe-scripts', plugins_url('assets/js/admin/admin-script.js', __FILE__), ['jquery'], WSF_VERSION, true );
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

}

function subscribe(){
    return Subscribe::get_instance();
}
subscribe();
