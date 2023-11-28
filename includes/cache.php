<?php
/**
 * Class Cache
 *
 * This class handles caching of files in the Pretix_Widget plugin.
 *
 * @package Pretix_Widget
 * @version 1.0.00
 */

namespace Pretix_Widget;

use Exception;

class Cache extends Base {
    public $debug = false;
    private $parent;
    private $cache_path = '/pretix-widget/cache/'; // Relative to wp_upload_dir()['basedir']
    private $cache_url = '/pretix-widget/cache/'; // Relative to wp_upload_dir()['basedir']
    private $cache_time_max = 24 * 60 * 60;

    /**
     * Cache constructor.
     *
     * @param object $parent The parent object of the cache.
     *
     * @since 1.0.00
     */
    public function __construct($parent) {
        $this->parent = $parent;
        $this->debug  = $this->parent->debug;

        $this->cache_path = wp_upload_dir()['basedir'] . $this->cache_path;
        $this->cache_url  = wp_upload_dir()['baseurl'] . $this->cache_url;

        if ( ! file_exists($this->cache_path)) {
            mkdir($this->cache_path, 0755, true);
        }

        $this->cache_time_max = get_option('pretix_widget_cache_time_max', $this->cache_time_max);
    }

    /**
     * Get the cached file contents for the given URL.
     *
     * @param string $url The URL to get the cached file for.
     *
     * @return string The contents of the cached file.
     * @since 1.0.00
     */
    public function get(string $url): string {
        $file_extension = pathinfo($url, PATHINFO_EXTENSION);
        $cache_name     = $this->get_cache_name($url);

        return $this->get_file($url, $cache_name, $file_extension);
    }

    /**
     * Get the cache name for the given URL.
     *
     * @param string $url The URL for which to get the cache name.
     *
     * @return string The cache name.
     * @since 1.0.00
     */
    private function get_cache_name($url) {
        $cache_name = base64_encode($url);

        return $cache_name;
    }

    /**
     * Get the cached file for the given URL.
     *
     * @param string $url The URL for which to get the cached file.
     * @param string $cache_name The cache name for the URL.
     * @param string $file_extension The file extension of the URL.
     *
     * @return string The URL of the cached file.
     * @since 1.0.00
     */
    private function get_file($url, $cache_name, $file_extension): string {
        $output = '';
        $file   = $cache_name . '.' . $file_extension;

        if ($this->file_exists($this->get_cache_path($file))) {
            $output = $this->get_cache_url($file);
        } else {
            $output = $this->download($url, $file);
        }

        return $output;
    }

    /**
     * Check if the file exists and is not older than the max cache time.
     *
     * @param string $path The file path to check.
     *
     * @return bool True if the file exists and is not older than the max cache time, false otherwise.
     * @since 1.0.00
     */
    private function file_exists(string $path): bool {
        return file_exists($path) && (time() - filemtime($path) < $this->cache_time_max) ? true : false;
    }

    /**
     * Get the path of the cached file.
     *
     * @param string $file The filename of the cached file.
     *
     * @return string The path of the cached file.
     * @since 1.0.00
     */
    public function get_cache_path(string $file = ''): string {
        return $this->cache_path . untrailingslashit($file);
    }

    /**
     * Get the URL of the cached file.
     *
     * @param string $file The filename of the cached file.
     *
     * @return string The URL of the cached file.
     * @since 1.0.00
     */
    private function get_cache_url(string $file = ''): string {
        return $this->cache_url . untrailingslashit($file);
    }

    /**
     * Download the file from the given URL and save it to the cache.
     *
     * @param string $url The URL of the file to download.
     * @param string $file The filename for the downloaded file.
     *
     * @return string The URL of the cached file or an empty string on failure.
     * @since 1.0.00
     */
    private function download(string $url, string $file): string {
        $output = '';

        try {
            // Download file from URL
            $file_data = wp_remote_get($url);

            if ( ! is_wp_error($file_data) && $file_data['response']['code'] === 200) {
                // Save the downloaded file to the cache folder relative to wp_upload_dir()['basedir']
                $cached_file = trailingslashit($this->cache_path) . $file;
                file_put_contents($cached_file, $file_data['body']);

                // Return the URL of the cached file
                $output = $this->get_cache_url($file);
            }
        } catch (Exception $e) {
            // Error occurred during the download process
            error_log($e->getMessage());
        }

        return $output;
    }

    /**
     * Get an array of cached files with their details.
     *
     * @return array An array containing cached file details.
     * @since 1.0.00
     */
    public function get_files(): array {
        $cache_path = $this->get_cache_path();
        $files      = array();

        if (is_dir($cache_path)) {
            $dir_handle = opendir($cache_path);

            if ($dir_handle) {
                while (($file = readdir($dir_handle)) !== false) {
                    if ($file != "." && $file != "..") {
                        $file_path = $cache_path . '/' . $file;
                        $files[]   = array(
                            'name' => $this->decode($file),
                            'size' => $this->format_file_size(filesize($file_path)),
                            'date' => date('Y-m-d H:i:s', filemtime($file_path))
                        );
                    }
                }

                closedir($dir_handle);
            }
        }

        return $files;
    }

    /**
     * Decode the base64 encoded filename to get the original URL.
     *
     * @param string $file The base64 encoded filename.
     *
     * @return string The decoded URL.
     * @since 1.0.00
     */
    private function decode(string $file): string {
        return base64_decode(preg_replace('/\.[^.]+$/', '', $file));
    }

    /**
     * Format the file size in bytes to a human-readable format.
     *
     * @param int $size The file size in bytes.
     *
     * @return string The formatted file size with units (B, KB, MB, GB, TB).
     * @since 1.0.00
     */
    private function format_file_size($size) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $i = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    /**
     * Flush the cache by downloading all cached files again.
     *
     * @return array An array with status and message indicating the success or failure of the cache flush.
     * @since 1.0.00
     */
    public function flush() {
        $cache_dir = $this->get_cache_path();
        $errors    = [];

        $files = scandir($cache_dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            // get base64 encoded url from filename without the file extension
            $url = $this->decode($file);
            // rebuild cache
            if ($this->download($url, $file) === '') {
                error_log(__('Download failed for', 'pretix-widget') . ' ' . $url);
                $errors[] = $url;
            }
        }

        return empty($errors) ? ['status'  => 'success',
                                 'message' => __('Cache flushed and rebuilt!', 'pretix-widget')
        ] :
            ['status' => 'error', 'message' => __('Couldn\'t download files:', 'pretix-widget'), 'errors' => $errors];
    }

    /**
     * Set the maximum cache time.
     *
     * @param mixed $number The maximum cache time in hours.
     *
     * @since 1.0.00
     */
    public function set_max_cache_time(mixed $number) {
        // allow reset with empty value
        if (empty($number)) {
            $number = 24;
        }
        // convert string to number
        if ( ! is_numeric($number)) {
            $number = (int)$number;
        }
        // check for zeros / convert to seconds
        $new_max_cache_time = $number <= 0 ? 0 : $number * 60 * 60;
        update_option('pretix_widget_cache_time_max', $new_max_cache_time);
        $this->cache_time_max = $new_max_cache_time;
    }

    /**
     * Get the maximum cache time.
     *
     * @return float The maximum cache time in hours.
     * @since 1.0.00
     */
    public function get_max_cache_time() {
        return $this->cache_time_max / 60 / 60;
    }
}
