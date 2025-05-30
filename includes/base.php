<?php
/**
 * Class Base
 *
 * This class serves as the base class for the Pretix_Widget plugin, containing common methods and properties.
 *
 * @package Pretix_Widget
 * @version 1.0.00
 */

namespace Pretix_Widget;

class Base {
    public $debug = false;
    private $path;
    private $url;
    private $errors = [];
    protected $latest_version = "v2";

    /**
     * Get the plugin name in snake_case.
     *
     * @return string The plugin name in snake_case.
     * @since 1.0.00
     */
    public function get_name_snake() {
        return str_replace('-', '_', $this->get_name());
    }

    /**
     * Get the name of the plugin.
     *
     * @return string The plugin name.
     * @since 1.0.00
     */
    public function get_name() {
        $plugin_basename = plugin_basename(__FILE__);

        return explode('/', $plugin_basename)[0];
    }

    /**
     * Get the path of the plugin.
     *
     * @param string $sub The subdirectory or file path within the plugin.
     *
     * @return string The full path of the plugin or the path to the subdirectory/file if specified.
     * @since 1.0.00
     */
    public function get_path(string $sub = '') {
        // Base path of the plugin
        $base_path = $this->path ? $this->path : plugin_dir_path(__DIR__);

        // Sanitize the sub-path: remove dangerous characters
        $sub = str_replace(['..', '\\', chr(0)], '', $sub);
        $sub = trim($sub, '/');

        // If a sub-path is provided, construct the full path
        if ($sub !== '') {
            $full_path = $base_path . $sub;

            // Use realpath to validate path security, but check if the file exists separately
            $real_base_path = realpath($base_path); // Resolve base path first

            // Make sure that the base path exists and is resolved correctly
            if ($real_base_path === false) {
                throw new \Exception('Invalid base path');
            }

            // Build a safe absolute path (even if the target doesn't exist)
            $safe_path = $real_base_path . DIRECTORY_SEPARATOR . $sub;

            // Check if the resolved safe path starts with the base directory to avoid traversal
            if (strpos($safe_path, $real_base_path) !== 0) {
                throw new \Exception('Invalid path access');
            }

            return $safe_path; // Return the safe path, even if the file doesn't exist
        }

        // Return the base path if no sub-path is provided
        return $base_path;
    }

    /**
     * Get the URL of the plugin.
     *
     * @param string $sub The subdirectory or file path within the plugin.
     *
     * @return string The full URL of the plugin or the URL to the subdirectory/file if specified.
     * @since 1.0.00
     */
    public function get_url(string $sub = '') {
        $url = $this->url ? $this->url : plugin_dir_url(__DIR__);
        $sub = trim($sub, '/');

        return $sub !== '' ? $url . $sub : $url;
    }

    /**
     * Get the short locale code.
     *
     * @param string $locale The full locale code.
     *
     * @return string The short locale code (first two characters).
     * @since 1.0.00
     */
    public function get_short_locale(string $locale) {
        return substr($locale, 0, 2);
    }

    /**
     * Set an error encountered during plugin execution.
     *
     * @param mixed $error The error message or error data to be logged.
     *
     * @since 1.0.00
     */
    public function set_error($error) {
        if (is_array($error) || is_object($error)) {
            error_log(print_r($error, true));
            $this->errors[] = array_merge($this->errors, $error);
        } else {
            error_log($error);
            $this->errors[] = $error;
        }
    }

    /**
     * Get the HTML representation of the errors encountered during plugin execution.
     *
     * @return string The HTML string containing the error messages.
     * @since 1.0.00
     */
    public function get_error_html() {
        $html = '';
        foreach ($this->get_errors() as $error) {
            $html .= '<p>' . $error . '</p>';
        }

        return $html;
    }

    /**
     * Get the errors encountered during plugin execution.
     *
     * @return array An array containing the encountered errors.
     * @since 1.0.00
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * POST / GET escaping wrapper function.
     *
     * @param mixed $value The value to escape.
     *
     * @return mixed The escaped value.
     * @since 1.0.4
     */
    public function _escape_request(mixed $value) {
        return sanitize_text_field( wp_unslash ( $value ) );
    }

    /**
     * Wrapper with escaping for wp_verify_nonce().
     *
     * @param string $nonce The nonce to verify.
     * @param mixed $action Should give context to what is taking place and be the same when nonce was created.
     *
     * @return string The escaped value.
     * @since 1.0.4
     */
    public function _verify_nonce(string $nonce, mixed $action = -1) {
        return wp_verify_nonce( $this->_escape_request ( $nonce ) , $action );
    }
}
