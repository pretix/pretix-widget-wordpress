<?php
/*
Plugin Name: Pretix Ticket
Plugin URI: https://pretix.eu/
Description: Display pretix ticketing on your WordPress website
Version: 1.0.0
Author: straightvisions GmbH
Author URI: https://straightvisions.com/
License: GPL2
*/

// Define an autoloader function
function my_autoloader($class_name) {
    // Strip namespace
    $class_name = strtolower(substr($class_name, strlen('Pretix_Ticket\\')));
    // Convert the class name to a file path
    $file_path = plugin_dir_path( __FILE__ ) . 'includes/class-' . $class_name . '.php';

    // If the file exists, include it
    if (file_exists($file_path)) {
        require_once($file_path);
    }
}

// Register the autoloader function
spl_autoload_register('my_autoloader');

require_once plugin_dir_path( __FILE__ ) . 'includes/class-pretix-ticket.php';

function pretix_ticket_init() {
    $pretix_ticket = new Pretix_Ticket\Pretix_Ticket();
    add_action( 'admin_menu', array( $pretix_ticket, 'add_plugin_menu' ) );
    add_action( 'wp_enqueue_scripts', array( $pretix_ticket, 'load_assets' ) );
}

add_action( 'init', 'pretix_ticket_init' );
