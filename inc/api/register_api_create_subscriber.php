<?php

namespace Wsf\Inc\API;
use WP_REST_Controller;
use WP_REST_Server;
// directly access defined
defined('ABSPATH') || exit;

class Register_APIs_Create_Subscriber extends WP_REST_Controller{
    public function __construct(){
        $this->namespace = 'wsf/v1';
        $this->rest_base = 'subscribe';
    }


    public function register_routes () {
        register_rest_route( 
            $this->namespace,
            '/' . $this->rest_base,
            [
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => [ $this, 'insert_item' ],
            ]
        );
    }

    public function insert_item( $request ){
        global $wpdb;
        $table = "{$wpdb->prefix}email_subscribers";
        
        $data = $request->get_params();

        $wpdb->insert(
            $table,
            [
                'email' => $data['email']
            ]
        );

        return 'Data Insert Successfully';

    }
}