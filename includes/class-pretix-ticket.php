<?php

namespace Pretix_Ticket;

final class Pretix_Ticket extends Base {
    private $settings;
    private $debug = false;

    public function __construct() {
        add_shortcode('pretix_ticket', array($this, 'display_pretix_ticket'));
        add_shortcode('pretix_ticket_button', array($this, 'display_pretix_ticket_button'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_assets'));
        add_action('enqueue_block_assets', array($this, 'enqueue_block_assets'));

        $this->settings = new Settings($this);
        $this->gebud    = defined('WP_DEBUG') && WP_DEBUG ? WP_DEBUG : false;
    }

    public function add_plugin_menu() {
        $this->settings->add_plugin_menu();
    }

    // Define methods to handle shortcode and Gutenberg block
    // Method to display the Pretix ticket using shortcode
    public function display_pretix_ticket_button($settings = []): string {
        $settings         = ! is_array($settings) ? [] : $settings;
        $settings['mode'] = 'button';

        return $this->display_pretix_ticket($settings);
    }

    public function display_pretix_ticket($settings = []): string {
        $output   = '';
        $defaults = $this->settings->get_settings();

        $settings = shortcode_atts(
            array(
                'mode'              => 'widget',
                'display'           => $defaults['pretix_ticket_display'],
                'shop_url'          => rtrim($defaults['pretix_ticket_shop_url'], '/'),
                'event'             => rtrim($defaults['pretix_ticket_filter_by_event'], '/'),
                'items'             => $defaults['pretix_ticket_filter_by_product_id'],
                'categories'        => $defaults['pretix_ticket_filter_by_category_id'],
                'variations'        => $defaults['pretix_ticket_filter_by_variation_id'],
                'disable_voucher'   => $defaults['pretix_ticket_disable_voucher'],
                'allocated_voucher' => $defaults['pretix_ticket_allocated_voucher'],
                'language'          => $defaults['pretix_ticket_default_language'],
                'button_text'       => $defaults['pretix_ticket_button_text'],
            ),
            $settings,
            'pretix_ticket'
        );

        // add debug settings
        if ($this->debug) {
            $settings['skip_ssl_check'] = $defaults['pretix_ticket_debug_skip_ssl_check'];
        }

        $template  = $this->get_path('templates/frontend/shortcode-' . $settings['mode'] . '.php');
        $language  = $this->get_short_locale($settings['language']);
        $arguments = $this->get_arguments_inline($settings);
        ob_start();
        file_exists($template) ? require $template : error_log('Template not found: ' . $template);

        return ob_get_clean();
    }

    private function get_short_locale(string $locale) {
        return substr($locale, 0, 2);
    }

    private function get_arguments_inline($settings) {
        $arguments = [];

        $arguments['list'] = 'list-type="' . $settings['display'] . '"';
        // URL -----------------------------------------------------------------
        $arguments['url'] = 'event="' . $settings['shop_url'] . '/';

        if ( ! empty($settings['event'])) {
            $arguments['url'] .= sanitize_text_field($settings['event']) . '/';
        }

        $arguments['url'] .= '"';
        // URL -----------------------------------------------------------------

        if ( ! empty($settings['items'])) {
            $arguments['products'] = 'items="';
            $arguments['products'] .= preg_replace('/[^0-9,]/', '', $settings['items']);
            $arguments['products'] .= '"';
        }

        if ( ! empty($settings['categories'])) {
            $arguments['categories'] = 'categories="';
            $arguments['categories'] .= preg_replace('/[^0-9,]/', '', $settings['categories']);
            $arguments['categories'] .= '"';
        }

        if ( ! empty($settings['variations'])) {
            $arguments['variations'] = 'variations="';
            $arguments['variations'] .= preg_replace('/[^0-9,]/', '', $settings['variations']);
            $arguments['variations'] .= '"';
        }

        if ($settings['allocated_voucher']) {
            $arguments['allocated_voucher'] = 'voucher="' . $settings['allocated_voucher'] . '"';
        }

        if ($settings['disable_voucher']) {
            $arguments['disable_voucher'] = 'disable-vouchers';
        }

        // add debug flags
        if ($this->debug && $settings['skip_ssl_check']) {
            $arguments['skip_ssl_check'] = 'skip-ssl-check';
        }

        $arguments = implode(' ', $arguments);

        return $arguments;
    }

    // Method to load assets for the Gutenberg block
    public function enqueue_block_assets() {}

    // Method to load assets only when the shortcode is used or the Gutenberg block is displayed
    public function load_assets() {
        global $post;
        if (has_shortcode($post->post_content, 'pretix_ticket') || has_block('pretix-ticket/pretix-ticket-block')) {
            wp_enqueue_style('pretix-ticket-style', $this->get_url('assets/css/style.css'), [], '1.0.0', 'all');
            wp_enqueue_script('pretix-ticket-script', $this->get_url('assets/js/script.js'), [], '1.0.0', true);
        }
    }


}
