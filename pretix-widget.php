<?php
/*
Plugin Name: pretix widget
Plugin URI: https://pretix.eu/
Description: Display pretix widget on your WordPress website
Version: 1.0.0
Author: straightvisions GmbH
Author URI: https://straightvisions.com/
License: GPL2
*/

// Define an autoloader function
function pretix_widget_autoloader($class_name) {
    // Strip namespace
    $class_name = strtolower(substr($class_name, strlen('Pretix_Widget\\')));
    // Convert the class name to a file path
    $file_path = plugin_dir_path( __FILE__ ) . 'includes/class-' . $class_name . '.php';

    // If the file exists, include it
    if (file_exists($file_path)) {
        require_once($file_path);
    }
}

// Register the autoloader function
spl_autoload_register('pretix_widget_autoloader');

require_once plugin_dir_path( __FILE__ ) . 'includes/class-pretix-widget.php';

function pretix_widget_init() {
    $pretix_widget = new Pretix_Widget\Pretix_Widget();
    add_action( 'admin_menu', array( $pretix_widget, 'add_plugin_menu' ) );
    add_action( 'wp_enqueue_scripts', array( $pretix_widget, 'load_assets' ) );
}

add_action( 'init', 'pretix_widget_init' );