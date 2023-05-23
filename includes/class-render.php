<?php
namespace Pretix_Widget;

class Render extends Base {
    private $parent;
    private $map = [];

    public function __construct($parent) {
        $this->parent = $parent;
    }

    // shortcodes
    // Define methods to handle shortcode and Gutenberg block
    // Method to display the Pretix ticket using shortcode
    public function shortcode_pretix_widget_button($settings = []): string {
        $settings         = ! is_array($settings) ? [] : $settings;
        $settings['mode'] = 'button';

        return $this->shortcode_pretix_widget($settings);
    }

    public function shortcode_pretix_widget($settings = []): string {
        $output   = '';
        $defaults = $this->parent->settings->get_settings();

        $settings = shortcode_atts(
            array(
                'mode'              => 'widget',
                'display'           => isset($defaults['pretix_widget_display']) ? $defaults['pretix_widget_display'] : 'list',
                'shop_url'          => isset($defaults['pretix_widget_shop_url']) ? rtrim($defaults['pretix_widget_shop_url'], '/') : '',
                'event'             => isset($defaults['pretix_widget_filter_by_event']) ? rtrim($defaults['pretix_widget_filter_by_event'], '/') : '',
                'items'             => isset($defaults['pretix_widget_filter_by_product_id']) ? $defaults['pretix_widget_filter_by_product_id'] : '',
                'categories'        => isset($defaults['pretix_widget_filter_by_category_id']) ? $defaults['pretix_widget_filter_by_category_id'] : '',
                'variations'        => isset($defaults['pretix_widget_filter_by_variation_id']) ? $defaults['pretix_widget_filter_by_variation_id'] : '',
                'disable_voucher'   => isset($defaults['pretix_widget_disable_voucher']) ? $defaults['pretix_widget_disable_voucher'] : '',
                'allocated_voucher' => isset($defaults['pretix_widget_allocated_voucher']) ? $defaults['pretix_widget_allocated_voucher'] : '',
                'language'          => isset($defaults['pretix_widget_default_language']) ? $defaults['pretix_widget_default_language'] : '',
                'button_text'       => isset($defaults['pretix_widget_button_text']) ? $defaults['pretix_widget_button_text'] : '',
            ),
            $settings,
            'pretix_widget'
        );

        // add debug settings
        if ($this->parent->debug) {
            $settings['skip_ssl_check'] = isset($defaults['pretix_widget_debug_skip_ssl_check']) ? $defaults['pretix_widget_debug_skip_ssl_check'] : false;
        }

        $template  = $this->get_path('templates/frontend/shortcode-' . $settings['mode'] . '.php');
        $language  = $this->get_short_locale($settings['language']);
        $arguments = $this->get_arguments_inline($settings);
        ob_start();
        file_exists($template) ? require $template : error_log('Template not found: ' . $template);

        return ob_get_clean();
    }

    // helper functions
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
        if ($this->parent->debug && $settings['skip_ssl_check']) {
            $arguments['skip_ssl_check'] = 'skip-ssl-check';
        }

        $arguments = implode(' ', $arguments);

        return $arguments;
    }
}