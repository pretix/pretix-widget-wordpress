<?php
/**
 * Class Settings
 *
 * This class handles the plugin settings and menu pages, as well as the sanitization of input values.
 *
 * @package Pretix_Widget
 * @version 1.0.00
 */

namespace Pretix_Widget;

use function add_menu_page;
use function get_locale;
use function register_setting;

class Settings extends Base {
    public $languages = null;
    private $parent = null;
    private $map = [];

    /**
     * Settings constructor.
     *
     * Initializes the Settings class by setting up the parent class instance and the languages.
     *
     * @param mixed $parent The parent class instance.
     *
     * @since 1.0.00
     */
    public function __construct($parent) {
        $this->parent    = $parent;
        $this->languages = new Languages($this);
    }

    /**
     * Add the plugin menu to the WordPress admin panel.
     *
     * @since 1.0.00
     */
    public function add_plugin_menu() {
        add_menu_page(
            'pretix widget',
            'pretix widget',
            'manage_options',
            'pretix_widget',
            array($this, 'render_plugin_page'),
            'data:image/svg+xml;base64,' . base64_encode(
                file_get_contents($this->get_path('assets/images/RGB-pretix-logo-light-icon.svg'))
            ),
        );

        $this->add_settings_page();
    }

    /**
     * Add the settings and cache submenu pages to the plugin menu.
     *
     * @since 1.0.00
     */
    public function add_settings_page() {
        add_submenu_page(
            'pretix_widget',
           esc_html__('Settings', 'pretix-widget'),
           esc_html__('Settings', 'pretix-widget'),
            'manage_options',
            'pretix_widget_settings',
            array($this, 'render_settings_page')
        );

        add_submenu_page(
            'pretix_widget',
           esc_html__('Cache', 'pretix-widget'),
           esc_html__('Cache', 'pretix-widget'),
            'manage_options',
            'pretix_widget_cache',
            array($this, 'render_cache_page')
        );

        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Get the settings group slug for a specific appendix.
     *
     * @param string $appendix The appendix to add to the settings group slug.
     *
     * @return string The settings group slug.
     * @since 1.0.00
     */
    public function get_settings_group_slug(string $appendix = 'defaults'): string {
        return $this->get_name_snake() . '_settings_group_' . $appendix;
    }

    /**
     * Register the settings for the plugin.
     *
     * @since 1.0.00
     */
    public function register_settings() {
        $map = $this->get_settings_map();

        foreach ($map as $group => $settings) {
            foreach ($settings as $key => $setting) {
                $name = $setting[0];
                $def  = isset($setting[1]) ? $setting[1] : '';
                // register_setting( string $option_group, string $option_name, array $args = array() )
                register_setting(
                    'pretix_widget_settings_group_' . $group,
                    $name,
                    [
                        'default'           => $def,
                        'sanitize_callback' => array($this, 'sanitize'),
                    ]
                );
            }
        }
    }

    /**
     * Get the settings map for the plugin.
     *
     * @return array The settings map containing the default settings for different groups.
     * @since 1.0.00
     */
    private function get_settings_map() {

        return empty($this->map) ? [
            // settings group
            'defaults' => [
                // settings of that group
                // 0 = name, 1 = default value, ...
                ['pretix_widget_shop_url', ''],
                ['pretix_widget_list_type', 'list'],
                ['pretix_widget_disable_voucher', false],
                ['pretix_widget_disable_filter', false],
                // will return "en" for not supported languages
                ['pretix_widget_language', $this->languages->get_current()['code']],
                // --------------------------------------------
                ['pretix_widget_button_text', __('Buy Ticket!', 'pretix-widget')],
                ['pretix_widget_debug_skip_ssl_check', false],
                ['pretix_widget_custom_css', '']
            ]
        ] : $this->map;
    }

    /**
     * Sanitize the custom CSS input.
     *
     * @param string $input The input to sanitize.
     *
     * @return string The sanitized input.
     * @since 1.0.00
     */
    public function sanitize($input) {
        // Save the custom CSS option
        $input = sanitize_textarea_field($input);
        // Delete the transient
        delete_transient('pretix_widget_custom_css');

        // Return the sanitized value
        return $input;
    }

    /**
     * Get the plugin settings.
     *
     * @return array The plugin settings.
     * @since 1.0.00
     */
    public function get_settings() {
        $options = wp_load_alloptions();
        $prefix  = $this->get_name_snake();

        $option_keys    = array_keys($options);
        $my_option_keys = array_filter($option_keys, function ($key) use ($prefix) {
            return strpos($key, $prefix) === 0;
        });

        $settings = array_combine($my_option_keys, array_intersect_key($options, array_flip($my_option_keys)));

        // $options doesn't contain options without a value
        return array_merge($this->get_settings_map_flat(), $settings);
    }

    /**
     * Get the flattened settings map.
     *
     * @return array The flattened settings map.
     * @since 1.0.00
     */
    private function get_settings_map_flat() {
        $settings_map = $this->get_settings_map();
        $defaults     = array();

        // This is the reason why settings of different groups can't share the same name / key
        foreach ($settings_map['defaults'] as $setting) {
            $name            = $setting[0];
            $default         = $setting[1];
            $defaults[$name] = $default;
        }

        return $defaults;
    }

    /**
     * Render the main plugin page in the WordPress admin panel.
     *
     * @since 1.0.00
     */
    public function render_plugin_page() {
        require_once($this->get_path('templates/backend/main.php'));
    }

    /**
     * Render the settings page in the WordPress admin panel.
     *
     * @since 1.0.00
     */
    public function render_settings_page() {
        $languages = $this->languages->get_list();
		$lang_names = $this->languages->get_name_strings();
        require_once($this->get_path('templates/backend/settings.php'));
    }

    /**
     * Render the cache page in the WordPress admin panel.
     *
     * @since 1.0.00
     */
    public function render_cache_page() {
        require_once($this->get_path('templates/backend/cache.php'));
    }
}
