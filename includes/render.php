<?php
/**
 * Class Render
 *
 * This class handles the rendering of the Pretix Widget and its elements, including shortcodes and blocks.
 *
 * @package Pretix_Widget
 * @version 1.0.00
 */

namespace Pretix_Widget;

class Render extends Base {
    public $settings = [];
    public $debug = false;
    public $cache = null;
    private $parent;
    private $errors = [];

    /**
     * Render constructor.
     *
     * Initializes the Render class by setting up the parent, debug mode, cache, settings, and other properties.
     *
     * @param mixed $parent The parent class instance.
     *
     * @since 1.0.00
     */
    public function __construct($parent) {
        $this->parent     = $parent;
        $this->debug      = $this->parent->debug;
        $this->cache      = $this->parent->cache;
        $this->settings   = $this->parent->settings->get_settings();
        $this->_shortcode = new Render\Shortcode($this);
        $this->_block     = new Render\Block($this);
    }

	/**
	 * Render the shortcode with the given settings and type.
	 *
	 * @param array $settings The settings to render the shortcode.
	 * @param string $type The type of shortcode to render (widget or button).
	 *
	 * @return string The rendered shortcode.
	 * @since 1.0.00
	 */
	public function shortcode(array $settings = [], string $type = 'widget'): string {
		return $this->_shortcode->render($settings, $type);
	}

    /**
     * Render the widget shortcode with the given settings.
     *
     * @param array $settings The settings to render the widget shortcode.
     *
     * @return string The rendered widget shortcode.
     * @since 1.0.00
     */
    public function shortcode_widget($settings = []): string {
		$settings = !is_array($settings) ? [] : $settings;
        return $this->shortcode($settings, 'widget');
    }

    /**
     * Render the button shortcode with the given settings.
     *
     * @param array $settings The settings to render the button shortcode.
     *
     * @return string The rendered button shortcode.
     * @since 1.0.00
     */
    public function shortcode_button($settings = []): string {
	    $settings = !is_array($settings) ? [] : $settings;
        return $this->shortcode($settings, 'button');
    }

    /**
     * Render the block with the given settings.
     *
     * @param array $settings The settings to render the block.
     *
     * @return string The rendered block.
     * @since 1.0.00
     */
    public function block(array $settings = []): string {
        return $this->_block->render($settings);
    }

    /**
     * Get the custom CSS for the widget.
     *
     * @return string The custom CSS for the widget.
     * @since 1.0.00
     */
    public function get_custom_css(): string {
        $custom_css = get_transient('pretix_widget_custom_css');

        if ($custom_css === false) {
            $custom_css = isset($this->settings['pretix_widget_custom_css']) ? $this->settings['pretix_widget_custom_css'] : '';
            $custom_css = wp_strip_all_tags($custom_css);
            $custom_css = wp_kses_post($custom_css);
            set_transient('pretix_widget_custom_css', $custom_css, 60 * 60 * 24);
        }

        return $custom_css;
    }
}
