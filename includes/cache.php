<?php
namespace Pretix_Widget;

class Cache extends Base {
    private $parent;
    public $debug = false;
    private $cache_path = '/pretix-widget/cache/';
    private $cache_url = '/pretix-widget/cache/';
    private $cache_time_max = 24 * 60 * 60;

    public function __construct($parent) {
        $this->parent     = $parent;
        $this->debug      = $this->parent->debug;

        $this->cache_path = wp_upload_dir()['basedir'] . $this->cache_path;
        $this->cache_url = wp_upload_dir()['baseurl'] . $this->cache_url;

        if (!file_exists($this->cache_path)) {
            mkdir($this->cache_path, 0755, true);
        }
    }

    public function get(string $url): string{
        $file_extension = pathinfo($url, PATHINFO_EXTENSION);
        $cache_name = $this->get_cache_name($url);

        return $this->get_file($url, $cache_name, $file_extension);
    }

    private function get_cache_name($url){
        $cache_name = base64_encode($url);
        return $cache_name;
    }

    private function get_file($url, $cache_name, $file_extension): string{
        $output = '';
        $file = $cache_name . '.' . $file_extension;

        if ($this->file_exists($this->get_cache_path($file))){
            $output = $this->get_cache_url($file);
        }else{
            try {
                // Download file from URL
                $file_data = wp_remote_get($url);

                if (!is_wp_error($file_data) && $file_data['response']['code'] === 200) {
                    // Save the downloaded file to the cache folder

                    // Move the downloaded file to the cache folder
                    $cached_file = trailingslashit($this->cache_path) . $file;
                    file_put_contents($cached_file, $file_data['body']);

                    // Return the URL of the cached file
                    $output = $this->get_cache_url($file);
                }

            } catch (\Exception $e) {
                // Error occurred during the download process
                error_log($e->getMessage());
            }
        }

        return $output;
    }

    private function get_cache_url(string $file): string{
        return $this->cache_url . untrailingslashit($file);
    }


    public function get_cache_path(string $file): string{
        return $this->cache_path . untrailingslashit($file);
    }
    
    private function file_exists(string $path): bool{
        return file_exists($path) && (time() - filemtime($path) < $this->cache_time_max) ? true : false;
    }

}
