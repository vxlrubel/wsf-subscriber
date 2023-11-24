<?php

defined('ABSPATH') || exit;

// control rest route
require_once dirname(__FILE__) . '/api/register_api_subscriber_display.php';
require_once dirname(__FILE__) . '/api/register_api_create_subscriber.php';
require_once dirname(__FILE__) . '/api/class-api.php';

// create admin menu
require_once dirname(__FILE__) . '/admin/create-admin-menu.php';