<?php
/*
Plugin Name: wp-subscribe
Description: An intuitive plugin for managing email subscriptions on WordPress.
Version: 2.0
Author: Rubel Mahmud ( Sujan )
*/

// Add your plugin functionalities here
// For demonstration purposes, let's include the description in the plugin page

namespace Wsf;


define('DOMAIN', 'wp-subcribe' );
define('WSF_VERSION', '1.0' );


final class Subscribe{

    // create private instance
    private static $instance;

    // define options slug
    public $slug = 'wsf-options';

    public function __construct(){

        // create admin menu
        add_action( 'admin_menu', [ $this, 'admin_menu'], 10 );

        register_activation_hook( __FILE__, [ $this, 'wp_subscribe_create_table' ] );

        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts'] );

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
     * Create 'subscribe' table when plugin is activated
     *
     * @return void
     */
    public function wp_subscribe_create_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'subscribe'; // Add the prefix for WordPress tables
    
        $charset_collate = $wpdb->get_charset_collate();
    
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(100) NOT NULL,
            name varchar(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
    
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    /**
     * create admin menu options
     *
     * @return void
     */
    public function admin_menu(){
        add_menu_page( 
            __( 'WP Subscribe', DOMAIN ),          // Page title
            __( 'WP Subscribe', DOMAIN ),          // Menu title
            'manage_options',                      // capability
            $this->slug,                           // Menu slug
            [ $this, 'display_subscribe_options' ] // callback
        );

        add_submenu_page( 
            $this->slug,                           // Page title
            __( 'Subscriber', DOMAIN ),          // Page title
            __( 'Subscriber', DOMAIN ),          // Menu title
            'manage_options',                      // capability
            $this->slug,                           // Menu slug
            [ $this, 'display_subscribe_options' ] // callback
        );
        add_submenu_page( 
            $this->slug,                           // Page title
            __( 'Add New Subscriber', DOMAIN ),          // Page title
            __( 'Add New', DOMAIN ),          // Menu title
            'manage_options',                      // capability
            'add-new-subscribe',                           // Menu slug
            [ $this, 'add_subscriber' ] // callback
        );
    }

    public function add_subscriber() {
        require_once dirname(__FILE__) . '/inc/add-new-subscriber-form.php';
    }

    public function display_subscribe_options(){
        require_once dirname(__FILE__) . '/inc/display-subscribe-options.php';
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
