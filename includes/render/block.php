<?php
/**
 * Class Block
 *
 * This class handles the rendering of the widget as a block for the Gutenberg editor.
 *
 * @package Pretix_Widget\Render
 * @version 1.0.00
 */

namespace Pretix_Widget\Render;

use Pretix_Widget\Base;

class Block extends Base {
    private $parent;

    /**
     * Block constructor.
     *
     * Initializes the Block class by setting up the parent class instance.
     *
     * @param mixed $parent The parent class instance.
     * @since 1.0.00
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * Render the widget as a block for the Gutenberg editor.
     *
     * @param array $settings The settings for the widget.
     *
     * @return string The rendered HTML output.
     * @since 1.0.00
     */
    public function render(array $settings = []): string {
        $output   = '';
        $defaults = $this->parent->settings;

        $settings = array_merge(array(
            'mode'              => 'widget',
            'list_type'           => isset($defaults['pretix_widget_list_type']) ? $defaults['pretix_widget_list_type'] : 'auto',
            'shop_url'          => isset($defaults['pretix_widget_shop_url']) ? rtrim(
                $defaults['pretix_widget_shop_url'],
                '/'
            ) : '',
            'subevent'          => isset($defaults['pretix_widget_subevent']) ? rtrim(
                $defaults['pretix_widget_subevent'],
                '/'
            ) : '',
            'items'             => isset($defaults['pretix_widget_filter_by_item_id']) ? $defaults['pretix_widget_filter_by_item_id'] : '',
            'categories'        => isset($defaults['pretix_widget_filter_by_category_id']) ? $defaults['pretix_widget_filter_by_category_id'] : '',
            'variations'        => isset($defaults['pretix_widget_filter_by_variation_id']) ? $defaults['pretix_widget_filter_by_variation_id'] : '',
            'disable_voucher'   => isset($defaults['pretix_widget_disable_voucher']) ? $defaults['pretix_widget_disable_voucher'] : '',
            'allocated_voucher' => isset($defaults['pretix_widget_allocated_voucher']) ? $defaults['pretix_widget_allocated_voucher'] : '',
            'disable_filter'    => isset($defaults['pretix_widget_disable_filter']) ? $defaults['pretix_widget_disable_filter'] : '',
            'filter'            => isset($defaults['pretix_widget_filter']) ? $defaults['pretix_widget_filter'] : '',
            'language'          => isset($defaults['pretix_widget_language']) ? $defaults['pretix_widget_language'] : '',
            'button_text'       => isset($defaults['pretix_widget_button_text']) ? $defaults['pretix_widget_button_text'] : '',
        ),
            array_filter($settings, function ($value) {
                return ! empty($value);
            }));

        // Add debug settings
        if ($this->parent->debug) {
            $settings['skip_ssl_check'] = isset($defaults['pretix_widget_debug_skip_ssl_check']) ? $defaults['pretix_widget_debug_skip_ssl_check'] : false;
        }

        $mode = 'widget';
        if ($settings['mode'] == 'button') {
            $mode = $settings['mode'];
        }

        $template  = $this->get_path('templates/frontend/block-' . $mode . '.php');
        $arguments_escaped = $this->get_arguments_inline_safe($settings);
        $fallback_url = trailingslashit(trailingslashit($settings['shop_url']) . trailingslashit($settings['subevent']));

        ob_start();
        if ($this->validate_args($settings)) {
            require($this->get_path('templates/frontend/no-script.php'));
            file_exists($template) ? require $template : error_log('Template not found: ' . esc_url($template));
            if ( ! defined('REST_REQUEST')) {
                // Frontend

                $this->enqueue_assets($settings);
            } // else: REST API
        } else {
            require $this->get_path('templates/frontend/placeholder.php');
        }

        return ob_get_clean();
    }

    /**
     * Constructs the inline arguments for the pretix widget based on the given settings.
     *
     * @param array $settings The settings for the pretix widget.
     *
     * @return string The formatted inline arguments for the pretix widget.
     * @version 1.0.00
     */
    private function get_arguments_inline_safe($settings) {
        $arguments = [];

        if ($settings['list_type'] !== 'auto') {
            $arguments['list'] = 'list-type="' . esc_attr($settings['list_type']) . '"';
        }
        // URL -----------------------------------------------------------------
        $shop_url = rtrim($settings['shop_url'], '/');
        if (strpos($shop_url, '://') === false) {
            $shop_url = "https://" . $shop_url;
        }
        $arguments['url'] = 'event="' . esc_attr($shop_url) . '/"';
        // URL -----------------------------------------------------------------

        if ( ! empty($settings['subevent'])) {
            $arguments['subevent'] = 'subevent="' . esc_attr($settings['subevent']) . '"';
        }

        if ( ! empty($settings['items'])) {
            $arguments['items'] = 'items="';
            // Button mode supports strings, widget mode only numbers
            $arguments['items'] .= $settings['mode'] === 'widget' ? preg_replace(
                '/[^0-9,]/',
                '',
                esc_attr($settings['items'])
            ) : esc_attr($settings['items']);
            $arguments['items'] .= '"';
        }

        if ( ! empty($settings['categories'])) {
            $arguments['categories'] = 'categories="';
            $arguments['categories'] .= preg_replace('/[^0-9,]/', '', esc_attr($settings['categories']));
            $arguments['categories'] .= '"';
        }

        if ( ! empty($settings['variations'])) {
            $arguments['variations'] = 'variations="';
            $arguments['variations'] .= preg_replace('/[^0-9,]/', '', esc_attr($settings['variations']));
            $arguments['variations'] .= '"';
        }

        if ($settings['allocated_voucher']) {
            $arguments['allocated_voucher'] = 'voucher="' . esc_attr($settings['allocated_voucher']) . '"';
        }

        if ($settings['disable_voucher']) {
            $arguments['disable_voucher'] = 'disable-vouchers';
        }

        if ($settings['filter']) {
            $arguments['filter'] = 'filter="' . esc_attr($settings['filter']) . '"';
        }

        if ($settings['disable_filter']) {
            $arguments['disable_filter'] = 'disable-filters';
        }

        // Add debug flags
        if ($this->parent->debug && $settings['skip_ssl_check']) {
            $arguments['skip_ssl_check'] = 'skip-ssl-check';
        }

        // Gutenberg anchor support
        if(isset($settings['anchor']) && !empty($settings['anchor'])) $arguments[] = 'id="'.esc_attr($settings['anchor']).'"';

        // Gutenberg class support
        $arguments[] = 'class="'.esc_attr($this->get_class_names($settings)).'"';

        return implode(' ', $arguments);
    }

    /**
     * Validates the provided arguments for the pretix widget.
     *
     * @param array $args The arguments to validate.
     *
     * @return bool True if the arguments are valid, false otherwise.
     * @version 1.0.00
     */
    private function validate_args(array $args): bool {
        $error = [];

        if ( ! isset($args['shop_url']) || ! $this->validate_shop_url($args['shop_url'])) {
            $this->set_error(__('Shop URL missing.', 'pretix-widget'));
        }

        return empty($this->get_errors()) ? true : false;
    }

    /**
     * Validates the provided shop URL.
     *
     * @param string $value The shop URL to validate.
     *
     * @return bool True if the shop URL is valid, false otherwise.
     * @version 1.0.00
     */
    private function validate_shop_url(string $value): bool {
        if (strpos($value, '://') === false) {
            $value = "https://" . $value;
        }
        if ( ! filter_var($value, FILTER_VALIDATE_URL)) {
            return false;
        }
        if (empty($value)) {
            return false;
        }

        return true;
    }

    /**
     * Enqueues the shop CSS and JS files for the pretix widget.
     *
     * @param array $settings The settings for the pretix widget.
     *
     * @version 1.0.00
     */
    private function enqueue_assets($settings) {
        // Get cached shop CSS file
        $file = $this->parent->cache->get(rtrim($settings['shop_url'], '/') . '/widget/v1.css');

        wp_enqueue_style(
            'pretix-widget-frontend',
            $file,
            array(),
            filemtime($this->parent->cache->get_cache_path(basename($file)))
        );

        // Get cached shop JS file
        $parsedUrl = parse_url($settings['shop_url']);
        $domain    = rtrim($parsedUrl['host'], '/');
        $file      = $this->parent->cache->get(
            'https://' . $domain . '/widget/v1.' . str_replace('_', '-', $settings['language']) . '.js'
        );

        wp_enqueue_script(
            'pretix-widget-frontend',
            $file,
            array(),
            filemtime($this->parent->cache->get_cache_path(basename($file))),
            true
        );

        // Custom CSS
        $custom_css = $this->parent->get_custom_css();
        if (empty($custom_css) === false) {
            wp_add_inline_style('pretix-widget-frontend', $custom_css);
        }
    }

    /**
     * Create class list from block arguments and other settings.
     *
     * @param array $settings The settings for the pretix widget.
     *
     * @version 1.0.01
     */
    private function get_class_names($settings): string{
        $cn = ['wp-block-pretix-widget'];

        if(isset($settings['className']) && !empty($settings['className'])) $cn[] = $settings['className'];

        // Gutenberg align support
        if(isset($settings['align'])) $cn[] = 'align' . $settings['align'];

        return implode(' ', $cn);
    }
}
