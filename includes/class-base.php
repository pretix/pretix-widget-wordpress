<?php
namespace Pretix_Widget;

class Base{
    private $path;
    private $url;

    public function get_name(){
        $plugin_basename = plugin_basename(__FILE__);
        return explode('/', $plugin_basename)[0];
    }

    public function get_name_snake(){
        return str_replace('-', '_', $this->get_name());
    }

    public function get_path(string $sub = ''){
        $path = $this->path ? $this->path : plugin_dir_path(__DIR__);
        $sub = trim($sub, '/');
        return $sub !== '' ? $path . $sub : $path;
    }

    public function get_url(string $sub = ''){
        $url = $this->url ? $this->url : plugin_dir_url( __DIR__ );
        $sub = trim($sub, '/');
        return $sub !== '' ? $url . $sub : $url;
    }

    public function get_short_locale(string $locale) {
        return substr($locale, 0, 2);
    }
}