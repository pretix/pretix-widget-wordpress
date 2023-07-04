<?php
namespace Pretix_Widget;

class Render extends Base {
    private $parent;
    private $errors = [];
    public $settings = [];
    public $debug = false;

    public function __construct($parent) {
        $this->parent = $parent;
        $this->debug = $this->parent->debug;
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

}