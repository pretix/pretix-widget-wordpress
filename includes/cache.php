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

        $this->cache_time_max = get_option('pretix_widget_cache_time_max', $this->cache_time_max);
    }

    public function get(string $url): string{
        $file_extension = pathinfo($url, PATHINFO_EXTENSION);
        $cache_name = $this->get_cache_name($url);

        return $this->get_file($url, $cache_name, $file_extension);
    }

    public function get_files(): array{
        $cache_path = $this->get_cache_path();
        $files = array();

        if (is_dir($cache_path)) {
            $dir_handle = opendir($cache_path);

            if ($dir_handle) {
                while (($file = readdir($dir_handle)) !== false) {
                    if ($file != "." && $file != "..") {
                        $file_path = $cache_path . '/' . $file;
                        $files[] = array(
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
            $output = $this->download($url, $file);
        }

        return $output;
    }

    private function get_cache_url(string $file = ''): string{
        return $this->cache_url . untrailingslashit($file);
    }

    public function get_cache_path(string $file = ''): string{
        return $this->cache_path . untrailingslashit($file);
    }
    
    private function file_exists(string $path): bool{
        return file_exists($path) && (time() - filemtime($path) < $this->cache_time_max) ? true : false;
    }

    public function flush(){
        $cache_dir = $this->get_cache_path();
        $errors = [];

        $files = scandir($cache_dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            // get base64 encoded url from filename without the file extension
            $url = $this->decode($file);
            // rebuild cache
            if($this->download($url, $file) === ''){
                error_log(__('Download failed for', 'pretix-widget') . ' ' . $url);
                $errors[] = $url;
            }
        }
        return empty($errors) ? ['status'=>'success', 'message'=> __('Cache flushed and rebuilt!', 'pretix-widget')] :
            ['status'=>'error', 'message'=>__('Couldn\'t download files:', 'pretix-widget'), 'errors'=>$errors]
            ;
    }

    public function set_max_cache_time(mixed $number){
        // allow reset with empty value
        if(empty($number)) $number = 24;
        // convert string to number
        if(!is_numeric($number)) $number = (int)$number;
        // check for zeros / convert to seconds
        $new_max_cache_time = $number <= 0 ? 0 : $number * 60 * 60;
        update_option('pretix_widget_cache_time_max', $new_max_cache_time);
        $this->cache_time_max = $new_max_cache_time;
    }

    public function get_max_cache_time(){
        return $this->cache_time_max / 60 / 60;
    }

    private function download(string $url, string $file): string{
        $output = '';

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

        return $output;
    }

    private function format_file_size($size) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $i = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    private function decode(string $file): string{
        return base64_decode(preg_replace('/\.[^.]+$/', '', $file));
    }

}
