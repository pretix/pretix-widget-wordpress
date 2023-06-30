<?php

namespace Pretix_Widget;

final class Pretix_Widget extends Base {
    public $settings;
    public $render;
    public $debug = false;

    public function __construct() {
        $this->settings = new Settings($this);
        $this->render = new Render($this);
        $this->debug    = defined('WP_DEBUG') && WP_DEBUG ? WP_DEBUG : false;

        add_shortcode('pretix_widget', array($this->render, 'shortcode_pretix_widget'));
        add_shortcode('pretix_widget_button', array($this->render, 'shortcode_pretix_widget_button'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));

        $this->register_blocks();
    }

    public function add_plugin_menu() {
        $this->settings->add_plugin_menu();
    }

    public function register_blocks() {
        // Register the pretix-widget-widget block
        register_block_type( $this->get_path('gutenberg/src/blocks/pretix-widget/block.json'),
            array('render_callback' => array($this->render, 'block_pretix_widget'))
        );
    }

    public function enqueue_block_editor_assets() {
        // Enqueue the JavaScript build for the pretix-widget-button block
        wp_enqueue_script(
            'pretix-widget',
            $this->get_url('gutenberg/dist/pretix-widget.build.js'),
            array('wp-blocks', 'wp-element'),
            filemtime($this->get_path('gutenberg/dist/pretix-widget.build.js')),
            true
        );

        wp_enqueue_style(
            'pretix-widget',
            $this->get_url('assets/css/editor.css'),
            array(),
            filemtime($this->get_path('assets/css/editor.css'))
        );
    }

    // Method to load assets only when the shortcode is used or the Gutenberg block is displayed
    public function load_assets() {
        global $post;
        if (has_shortcode($post->post_content, 'pretix_widget') || has_block('pretix-widget/widget')) {
            wp_enqueue_style('pretix-widget-style', $this->get_url('assets/css/style.css'), [], '1.0.0', 'all');
            wp_enqueue_script('pretix-widget-script', $this->get_url('assets/js/script.js'), [], '1.0.0', true);
        }
    }


}
