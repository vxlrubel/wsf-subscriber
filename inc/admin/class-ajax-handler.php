<?php

namespace Wsf\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

class Ajax_Handler{

    protected $action = 'add_new_subscriber';

    public function __construct(){

        add_action( "wp_ajax_{$this->action}", [ $this, 'add_new_subscriber'] );
    }

    public function add_new_subscriber(){

        global $wpdb;

        $table = "{$wpdb->prefix}email_subscribers";

        if( ! defined('DOING_AJAX') || ! DOING_AJAX ) return;

        if( ! isset( $_POST['_wpnonce'] ) ) return;

        $email = sanitize_email( $_POST['email'] );

        if( empty( $email ) ){
            wp_send_json_error('Invalid Email or Empty');
        }

        $email_exists = $wpdb->get_var( $wpdb->prepare( "SELECT email FROM $table WHERE email = %s", $email ) );

        if( $email_exists ){
            wp_send_json_error('Email Alreay Exists');
        }

        $data = [ 'email' => $email ];

        // if email exit then return with error status

        $wpdb->insert( $table, $data );

        // notify to subscriber
        wp_mail( $email, 'New Subscribe', 'Thanks For Subscribe Our Newletter.' );

        wp_send_json_success( 'Add a new subscriber successfully.' );

    }

    protected function get_email_from_database(){

        global $wpdb;

        $table = "{$wpdb->prefix}email_subscribers";

        $data = $wpdb->get_results("SELECT email FROM $table");

        return $data;

    }
}