<?php
/*
Plugin Name: pretix widget
Text Domain: pretix-widget
Description: The pretix widget allows you to easily display pretix ticket widgets on your website. You can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.
Plugin URI: https://github.com/pretix/pretix-widget-wordpress
Author: pretix.eu
Author URI: https://pretix.eu
Version: 1.1.0
Requires at least: 6.1.1
Requires PHP:      8.0.26
Domain Path: /includes/languages
License: Apache-2.0
License URI: https://www.apache.org/licenses/LICENSE-2.0
*/

/**
 * Autoloader function for the Pretix Widget plugin.
 *
 * @param string $class_name The class name to be autoloaded.
 *
 * @return void
 */
function pretix_widget_autoloader($class_name) {
    // Strip namespace
    $class_name = str_replace('\\', '/', strtolower(substr($class_name, strlen('Pretix_Widget\\'))));

    // Convert the class name to a file path
    $file_path = plugin_dir_path(__FILE__) . 'includes/' . $class_name . '.php';

    // If the file exists, include it
    if (file_exists($file_path)) {
        require_once($file_path);
    }
}

// Register the autoloader function.
spl_autoload_register('pretix_widget_autoloader');

// Require the main plugin file.
require_once plugin_dir_path(__FILE__) . 'includes/pretix-widget.php';

// Load the text domain for translation.
function pretix_widget_load_text_domain() {
    load_plugin_textdomain('pretix-widget', false, basename(dirname(__FILE__)) . '/includes/languages');
}

add_action('init', 'pretix_widget_load_text_domain');

// Initialize the Pretix Widget plugin.
function pretix_widget_init() {
    $pretix_widget = new Pretix_Widget\Pretix_Widget();
}

// Hook the initialization function to the 'init' action.
add_action('init', 'pretix_widget_init');
