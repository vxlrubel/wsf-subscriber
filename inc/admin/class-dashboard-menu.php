<?php

namespace Wsf\Inc\Admin;

defined('ABSPATH') || exit;

class Dashboard_Menu{

    // define main menu slug
    protected $parent_slug = 'wsf-lists';

    // define add new subscriber slug
    protected $add_new_slug = 'wsf-add-new-subscriber';
    
    public function __construct(){

        add_action( 'admin_menu', [ $this, 'dashboard_menu' ] );
    }

    public function dashboard_menu(){
        add_menu_page( 
            __( 'WSF Subscribe', DOMAIN ),         // Page title
            __( 'WSF Subscribe', DOMAIN ),         // Menu title
            'manage_options',                      // capability
            $this->parent_slug,                    // Menu slug
            [ $this, 'display_subscribers' ]       // callback
        );

        add_submenu_page( 
            $this->parent_slug,                    // Parent slug
            __( 'Subscribers', DOMAIN ),           // Page title
            __( 'Subscribers', DOMAIN ),           // Menu title
            'manage_options',                      // capability
            $this->parent_slug,                    // Menu slug
            [ $this, 'display_subscribers' ]       // callback
        );
        add_submenu_page( 
            $this->parent_slug,                    // Parent slug
            __( 'Add New Subscriber', DOMAIN ),    // Page title
            __( 'Add New', DOMAIN ),               // Menu title
            'manage_options',                      // capability
            $this->add_new_slug,                   // Menu slug
            [ $this, 'add_subscriber_form' ]       // callback
        );
    }

    public function display_subscribers(){

        new Display_Subscriber_Lists( $this->add_new_slug );
        
    }

    public function add_subscriber_form(){

       new Subscribe_Form( $this->parent_slug );
       
    }
}