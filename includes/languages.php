<?php
namespace Pretix_Widget;

class Languages extends Base {
    private $parent;
    public $debug = false;
    private $list = [];

    public function __construct($parent) {
        $this->parent     = $parent;
        $this->debug      = $this->parent->debug;
    }

    public function get(string $code): mixed{
        $filtered = array_filter($this->get_list(), function ($lang) use ($code) {
            return $lang['code'] === $code;
        });

        $result = reset($filtered); // Get the first element of the filtered array

        return $result ?: null;
    }

    public function get_by_locale(string $locale): mixed{
        $filtered = array_filter($this->get_list(), function ($lang) use ($locale) {
            return $lang['locale'] === $locale;
        });

        $result = reset($filtered); // Get the first element of the filtered array

        return $result ?: null;
    }

    public function get_list(): array{
        return empty($this->list) ? $this->get_file() : $this->list;
    }

    public function get_current(): string{
        return get_locale();
    }

    private function get_file(): array{
        $file = $this->get_path('includes/languages/lang.json');
        if (file_exists($file)){
            $this->list = json_decode(file_get_contents($file), true);
            $this->list = array_filter($this->list, function($lang) {
                return $lang['supported'] !== false;
            });
        }

        return $this->list;
    }


}
