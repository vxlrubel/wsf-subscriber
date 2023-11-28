<?php

namespace Wsf\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

class Ajax_Handler{

    protected $add_action = 'add_new_subscriber';
    protected $update_action = 'subscribe_update';

    public function __construct(){

        add_action( "wp_ajax_{$this->add_action}", [ $this, 'add_new_subscriber'] );
        add_action( "wp_ajax_{$this->update_action}", [ $this, 'update_subscriber'] );
    }

    public function update_subscriber(){
        
        global $wpdb;
        $table = $wpdb->prefix . 'email_subscribers';
        
        if( ! defined('DOING_AJAX') || ! DOING_AJAX ) return;

        if( empty( $_POST['id'] ) || $_POST['id'] == null ) {
            wp_send_json_error( 'something went wrong.' );
        }

        if( empty( $_POST['email'] ) || $_POST['email'] == null ) {
            wp_send_json_error( 'Email is required' );
        }

        $id           = $_POST['id'];
        $email        = sanitize_email( $_POST['email'] );
        $current_time = current_time( 'mysql' );

        $data = [
            'email'      => $email,
            'updated_at' => $current_time,
        ];

        $where = [
            'id' => $id
        ];

        $wpdb->update( $table, $data, $where );

        wp_send_json_success( 'data update successfully' );
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