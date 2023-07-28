<?php
namespace Pretix_Widget;

class Render extends Base {
    private $parent;
    private $errors = [];
    public $settings = [];
    public $debug = false;
    public $cache = null;

    public function __construct($parent) {
        $this->parent = $parent;
        $this->debug = $this->parent->debug;
        $this->cache = $this->parent->cache;
        $this->settings = $this->parent->settings->get_settings();
        $this->_shortcode = new Render\Shortcode($this);
        $this->_block = new Render\Block($this);
    }

    // shortcode renderer
    public function shortcode(array $settings = [], string $type = 'widget'): string{
        return $this->_shortcode->render($settings, $type);
    }

    public function shortcode_widget(array $settings = []): string{
        return $this->shortcode($settings, 'widget');
    }

    public function shortcode_button(array $settings = []): string{
        return $this->shortcode($settings, 'button');
    }

    // block renderer
    public function block(array $settings = []): string{
        return $this->_block->render($settings);
    }

    // custom css handler
    public function get_custom_css(): string{
        echo "get_custom_css";
        $custom_css = get_transient('pretix_widget_custom_css');

        if($custom_css === false){
            $custom_css = isset($this->settings['pretix_widget_custom_css']) ? $this->settings['pretix_widget_custom_css'] : '';
            $custom_css = wp_strip_all_tags($custom_css);
            $custom_css = wp_kses_post($custom_css);
            set_transient('pretix_widget_custom_css', $custom_css, 60*60*24);
        }

        return $custom_css;

    }

}