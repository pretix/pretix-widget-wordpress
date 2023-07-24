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
    $class_name = str_replace('\\', '/', strtolower(substr($class_name, strlen('Pretix_Widget\\'))));

    // Convert the class name to a file path
    $file_path = plugin_dir_path( __FILE__ ) . 'includes/' . $class_name . '.php';

    // If the file exists, include it
    if (file_exists($file_path)) {
        require_once($file_path);
    }
}

// Register the autoloader function
spl_autoload_register('pretix_widget_autoloader');

require_once plugin_dir_path( __FILE__ ) . 'includes/pretix-widget.php';

function pretix_widget_load_text_domain() {
    load_plugin_textdomain( 'pretix-widget', false, basename( dirname( __FILE__ ) ) . '/includes/languages' );
}

function pretix_widget_init() {
    $pretix_widget = new Pretix_Widget\Pretix_Widget();
}

add_action( 'init', 'pretix_widget_init' );

