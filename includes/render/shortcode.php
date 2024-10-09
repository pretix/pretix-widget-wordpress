<?php
/**
 * Version: 1.0.00
 */

namespace Pretix_Widget\Render;

use Pretix_Widget\Base;

/**
 * Class Shortcode
 * This class handles the rendering of Pretix widgets using shortcodes.
 * @version 1.0.00
 */
class Shortcode extends Base {
    private $parent;

    /**
     * Constructor for the Shortcode class.
     *
     * @param object $parent The parent object.
     *
     * @version 1.0.00
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * Renders the Pretix widget using the provided settings and type.
     *
     * @param array $settings The settings for the Pretix widget.
     * @param string $type The type of the widget (shortcode or Gutenberg block).
     *
     * @return string The rendered HTML for the widget.
     * @version 1.0.00
     */
    public function render(array $settings = [], $type = 'widget') {
        // @todo implement error logging
        return method_exists($this, $type) ? $this->$type($settings) : 'Renderer not found';
    }

    // shortcodes
    // Define methods to handle shortcode and Gutenberg block

    /**
     * Method to display the Pretix ticket using the 'button' shortcode.
     *
     * @param array $settings The settings for the Pretix widget.
     *
     * @return string The rendered HTML for the widget using the 'button' shortcode.
     * @version 1.0.00
     */
    public function button($settings = []): string {
        $settings         = ! is_array($settings) ? [] : $settings;
        $settings['mode'] = 'button';

        return $this->widget($settings);
    }

    /**
     * Method to display the Pretix ticket using the 'widget' shortcode.
     *
     * @param array $settings The settings for the Pretix widget.
     *
     * @return string The rendered HTML for the widget using the 'widget' shortcode.
     * @version 1.0.00
     */
    public function widget($settings = []): string {
        $output   = '';
        $defaults = $this->parent->settings;

        $settings = shortcode_atts(
            array(
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
                'language'          => isset($defaults['pretix_widget_language']) ? $defaults['pretix_widget_language'] : '',
                'button_text'       => isset($defaults['pretix_widget_button_text']) ? $defaults['pretix_widget_button_text'] : '',
            ),
            $settings,
            'pretix_widget'
        );

        // add debug settings
        if ($this->parent->debug) {
            $settings['skip_ssl_check'] = isset($defaults['pretix_widget_debug_skip_ssl_check']) ? $defaults['pretix_widget_debug_skip_ssl_check'] : false;
        }

        $mode = 'widget';
        if ($settings['mode'] == 'button') {
            $mode = $settings['mode'];
        }

        $template  = $this->get_path('templates/frontend/shortcode-' . $mode . '.php');
        $arguments_escaped = $this->get_arguments_inline_safe($settings);
        $fallback_url = trailingslashit(trailingslashit($settings['shop_url']) . trailingslashit($settings['subevent']));

        ob_start();
        if ($this->validate_args($settings)) {
            require($this->get_path('templates/frontend/no-script.php'));
            file_exists($template) ? require $template : error_log('Template not found: ' . esc_url($template));
            $this->enqueue_assets($settings);
        } else {
            require $this->get_path('templates/frontend/placeholder.php');
        }

        return ob_get_clean();
    }

    // helper functions

    /**
     * Constructs the inline arguments for the Pretix widget based on the given settings.
     *
     * @param array $settings The settings for the Pretix widget.
     *
     * @return string The formatted inline arguments for the Pretix widget.
     * @version 1.0.00
     */
    private function get_arguments_inline_safe($settings) {
        $arguments = [];

        if ($settings['list_type'] !== 'auto') {
            $arguments['list'] = 'list-type="' . esc_attr($settings['list_type']) . '"';
        }
        // URL -----------------------------------------------------------------
        $arguments['url'] = 'event="' . esc_attr(rtrim($settings['shop_url'], '/')) . '/"';
        // URL -----------------------------------------------------------------

        if ( ! empty($settings['subevent'])) {
            $arguments['subevent'] = 'subevent="' . esc_attr($settings['subevent']) . '"';
        }

        if ( ! empty($settings['items'])) {
            $arguments['items'] = 'items="';
            // button mode supports strings, widget mode only numbers
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

        // add debug flags
        if ($this->parent->debug && $settings['skip_ssl_check']) {
            $arguments['skip_ssl_check'] = 'skip-ssl-check';
        }

        $arguments = implode(' ', $arguments);

        return $arguments;
    }

    /**
     * Validates the provided arguments for the Pretix widget.
     *
     * @param array $args The arguments to validate.
     *
     * @return bool True if the arguments are valid, false otherwise.
     * @version 1.0.00
     */
    private function validate_args(array $args): bool {
        $error = [];

        if ( ! isset($args['shop_url']) || ! $this->validate_shop_url($args['shop_url'])) {
            $this->set_error(esc_html(__('Shop URL missing.', 'pretix-widget')));
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
        if ( ! filter_var($value, FILTER_VALIDATE_URL)) {
            return false;
        }
        if (empty($value)) {
            return false;
        }

        return true;
    }

    /**
     * Enqueues the shop CSS and JS files for the Pretix widget.
     *
     * @param array $settings The settings for the Pretix widget.
     *
     * @version 1.0.00
     */
    private function enqueue_assets($settings) {
        // get cached shop css file
        $file = esc_url($this->parent->cache->get(rtrim($settings['shop_url'], '/') . '/widget/v1.css'));
        wp_enqueue_style(
            'pretix-widget-frontend',
            $file,
            array(),
            filemtime($this->parent->cache->get_cache_path(basename($file)))
        );

        // get cached shop js file
        $parsedUrl = parse_url(esc_url($settings['shop_url']));
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

        // custom css
        $custom_css = $this->parent->get_custom_css();
        if (empty($custom_css) === false) {
            wp_add_inline_style('pretix-widget-frontend', $custom_css);
        }
    }

}
