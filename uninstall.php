<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

function pretix_widget_delete_files_recursive($dir) {
    $files = glob($dir . '/*');

    foreach ($files as $file) {
        if (is_dir($file)) {
            pretix_widget_delete_files_recursive($file);
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

// Remove transients
delete_transient('pretix_widget_custom_css');

// Remove files in the uploads directory
$uploads_dir = wp_upload_dir();
$plugin_dir = trailingslashit($uploads_dir['basedir']) . 'pretix-widget';

if (is_dir($plugin_dir)) {
    error_log('Removing directory ' . $plugin_dir);
    // Remove all files in the directory
    pretix_widget_delete_files_recursive($plugin_dir);
    // Remove the directory itself
    rmdir($plugin_dir);
}