<?php

defined('ABSPATH') || exit;

// create table
require_once dirname(__FILE__) . '/create-subscribe-table.php';

// control rest route
require_once dirname(__FILE__) . '/subscribe-rest-api-controller.php';

// create admin menu
require_once dirname(__FILE__) . '/admin/create-admin-menu.php';