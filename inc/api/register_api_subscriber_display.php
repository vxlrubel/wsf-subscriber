<?php

namespace Wsf\Inc\API;
use WP_REST_Controller;
use WP_REST_Server;
// directly access defined
defined('ABSPATH') || exit;

class Register_APIs_Subscriber_Display extends WP_REST_Controller{
    public function __construct(){
        $this->namespace = 'wsf/v1';
        $this->rest_base = 'subscribers';
    }


    public function register_routes () {
        register_rest_route( 
            $this->namespace,
            '/' . $this->rest_base,
            [
                'methods'  => WP_REST_Server::READABLE,
                'callback' => [ $this, 'get_items' ],
            ]
        );
    }

    public function get_items( $request ){
        global $wpdb;
        $table = "{$wpdb->prefix}email_subscribers";
        $sql = "SELECT * FROM $table";

        $result = $wpdb->get_results( $sql );

        $request = $result;

        return $request;

    }
}