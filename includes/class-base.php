<?php
namespace Pretix_Ticket;

class Base{
    private $path;
    private $url;

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
}