<?php

namespace Pretix_Widget;

use function add_menu_page;
use function register_setting;

class Settings extends Base {
    private $parent = null;
    public $languages = null;
    private $map = [];

    public function __construct($parent) {
        $this->parent = $parent;
		$this->languages = new Languages($this);
    }

    public function add_plugin_menu() {
        add_menu_page(
            'pretix widget',
            'pretix widget',
            'manage_options',
            'pretix_widget',
            array($this, 'render_plugin_page'),
            'data:image/svg+xml;base64,' . base64_encode(file_get_contents($this->get_path('assets/images/RGB-pretix-logo-light-icon.svg'))),
        );

        $this->add_settings_page();
    }

    public function add_settings_page() {
        add_submenu_page(
            'pretix_widget',
            __('Settings', 'pretix-widget'),
            __('Settings', 'pretix-widget'),
            'manage_options',
            'pretix_widget_settings',
            array($this, 'render_settings_page')
        );

        add_submenu_page(
            'pretix_widget',
            __('Cache', 'pretix-widget'),
            __('Cache', 'pretix-widget'),
            'manage_options',
            'pretix_widget_cache',
            array($this, 'render_cache_page')
        );

        add_action('admin_init', array($this, 'register_settings'));
    }

	public function get_settings_group_slug(string $appendix = 'defaults'){
		return $this->get_name_snake() . '_settings_group_' . $appendix;
	}

    public function register_settings() {
		$map = $this->get_settings_map();

		foreach($map as $group => $settings){
			foreach($settings as $key => $setting){
				$name = $setting[0];
				$def = isset($setting[1]) ? $setting[1] : '';
				// register_setting( string $option_group, string $option_name, array $args = array() )
                register_setting(
                    'pretix_widget_settings_group_'.$group,
                    $name,
	                [
						'default' => $def,
                        'sanitize_callback' => array($this, 'sanitize'),
	                ]
                );
			}
		}

    }

    // Sanitize the custom CSS input
    public function sanitize($input) {
        // Save the custom CSS option
        $input = sanitize_textarea_field($input);
        // Delete the transient
        delete_transient('pretix_widget_custom_css');

        // Return the sanitized value
        return $input;
    }

	private function get_settings_map(){
		return empty($this->map) ? [
			// settings group
            'defaults' => [
				// settings of that group
	            // 0 = name, 1 = default value, ...
                ['pretix_widget_shop_url', ''],
                ['pretix_widget_display', 'list'],
                ['pretix_widget_disable_voucher', false],
                ['pretix_widget_language', \get_locale()],
                ['pretix_widget_button_text', __('Buy Ticket!', $this->get_name())],
                ['pretix_widget_debug_skip_ssl_check', false],
                ['pretix_widget_custom_css', '']
            ]
        ] : $this->map;
	}

	private function get_settings_map_flat(){
        $settings_map = $this->get_settings_map();
        $defaults = array();

		// this is the reason why settings of different groups can't share the same name / key
        foreach ($settings_map['defaults'] as $setting) {
            $name = $setting[0];
            $default = $setting[1];
            $defaults[$name] = $default;
        }

		return $defaults;
	}

	public function get_settings(){
        $options = wp_load_alloptions();
		$prefix = $this->get_name_snake();

        $option_keys = array_keys($options);
        $my_option_keys = array_filter($option_keys, function($key) use ($prefix) {
            return strpos($key, $prefix) === 0;
        });

		$settings = array_combine($my_option_keys, array_intersect_key($options, array_flip($my_option_keys)));
		// $options doesn't contain options without a value
        return array_merge($this->get_settings_map_flat(), $settings);
	}

    public function render_plugin_page() {
        require_once($this->get_path('templates/backend/main.php'));
    }

    public function render_settings_page() {
        $languages = $this->languages->get_list();
        require_once($this->get_path('templates/backend/settings.php'));
    }

    public function render_cache_page() {
        require_once($this->get_path('templates/backend/cache.php'));
    }

}