<?php

defined('ABSPATH') || exit;

// Load admin file
$files = [
    'display-subscriber-lists',
    'subscribe-form',
    'ajax-handler',
    'dashboard-menu',
];

foreach ( $files as $file ) {
    if( file_exists( dirname(__FILE__) . "/admin/class-{$file}.php" ) ){
        require_once dirname(__FILE__) . "/admin/class-{$file}.php"; 
    }else{
        throw new Exception( "This {$file} file is not found." );
    }
}