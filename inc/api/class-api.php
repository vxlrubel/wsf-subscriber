<?php

namespace Wsf\Inc\API;
use Wsf\Inc\API\Register_APIs;

defined('ABSPATH') || exit;


class Register_Subscription_APIs {
    public function __construct(){
        add_action( 'rest_api_init', [ $this, 'register_api'] );
    }

    public function register_api(){

        // get subscriber
        $subscriber_display = new Register_APIs_Subscriber_Display;
        $subscriber_display->register_routes();

        // create subscriber
        // $subscriber_create = new Register_APIs_Subscriber_Create;
        // $subscriber_create->register_routes();
    }
}