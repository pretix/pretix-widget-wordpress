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
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_assets'));
        add_action('enqueue_block_assets', array($this, 'enqueue_block_assets'));
        add_action('init', array($this, 'register_blocks'));
    }

    public function add_plugin_menu() {
        $this->settings->add_plugin_menu();
    }

    public function register_blocks() {
        // Register the pretix-widget-button block
        register_block_type('pretix-widget/button', array(
            'editor_script' => 'pretix-widget-button',
            'render_callback' => array($this, 'render_pretix_widget_button_block'),
        ));

        // Register the pretix-widget-widget block
        register_block_type('pretix-widget/widget', array(
            'editor_script' => 'pretix-widget-widget',
            'render_callback' => array($this, 'render_pretix_widget_block'),
        ));
    }

    // Method to load assets for the Gutenberg block
    public function enqueue_block_assets() {
        // Enqueue the JavaScript build for the pretix-widget-button block
        /*wp_enqueue_script(
            'pretix-widget-button',
            plugin_dir_url(__DIR__) . 'gutenberg/dist/pretix-widget-button.build.js',
            array('wp-blocks', 'wp-element'),
            '1.0.0',
            true
        );*/

        // Enqueue the JavaScript build for the pretix-widget-widget block
        wp_enqueue_script(
            'pretix-widget-widget',
            plugin_dir_url(__DIR__) . 'gutenberg/dist/pretix-widget-widget.build.js',
            array('wp-blocks', 'wp-element'),
            '1.0.0',
            true
        );
    }

    // Method to load assets only when the shortcode is used or the Gutenberg block is displayed
    public function load_assets() {
        global $post;
        if (has_shortcode($post->post_content, 'pretix_widget') || has_block('pretix-widget/pretix-widget-block')) {
            wp_enqueue_style('pretix-widget-style', $this->get_url('assets/css/style.css'), [], '1.0.0', 'all');
            wp_enqueue_script('pretix-widget-script', $this->get_url('assets/js/script.js'), [], '1.0.0', true);
        }
    }


}
