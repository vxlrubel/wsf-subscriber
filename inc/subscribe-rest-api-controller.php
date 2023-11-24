<?php


namespace Wsf\Inc;

// direncty access denied
defined('ABSPATH') || exit;

class Subscribe_REST_API_CONTROLLER {

    // route base
    public $rest_base   = 'wsf/v1';

    // create subscriber
    public $route_create = '/subscribe';

    // display subscriber
    public $route_read   = '/subscribers';

    // update or edit subscriber
    public $route_update = '/edit-subscriber';

    // delete subscriber
    public $route_delete = '/delete-subscriber';

    public function __construct(){

        // register route

        add_action( 'rest_api_init', [ $this, 'create_subscribe_route'] );

    }

    public function create_subscribe_route(){

        // add new subscriber
        register_rest_route(
            'wsf/v1',
            'subscribe',
            [
                'methods' => 'POST',
                'callback'=> [ $this, 'add_new_subscriber' ]
            ]
        );

    }

    public function add_new_subscriber( $request ){
        global $wpdb;

        $table = $wpdb->prefix . 'email_subscribers';

        $data = $request->get_params();

        $email = sanitize_email($data['email']);

        $wpdb->insert(
            $table,
            [
                'email'      => $email,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            ],
            [ '%s','%s', '%s', ]
        );

        return new WP_REST_Response(array('message' => 'Data inserted successfully'), 200);
    }
}