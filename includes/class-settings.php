<?php

namespace Pretix_Ticket;

use function add_menu_page;
use function register_setting;

class Settings extends Base {
    private $parent;
    private $map = [];

    public function __construct($parent) {
        $this->parent = $parent;
    }

    public function add_plugin_menu() {
        add_menu_page(
            'Pretix Ticket',
            'Pretix Ticket',
            'manage_options',
            'pretix_ticket',
            array($this, 'render_plugin_page'),
            'dashicons-tickets-alt'
        );

        $this->add_settings_page();
    }

    public function add_settings_page() {
        add_submenu_page(
            'pretix_ticket',
            'General Settings',
            'Settings',
            'manage_options',
            'pretix_ticket_settings',
            array($this, 'render_settings_page')
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
                    'pretix_ticket_settings_group_'.$group,
                    $name,
	                [
						'default' => $def,
	                ]
                );
			}
		}

    }

	private function get_settings_map(){
		return empty($this->map) ? [
			// settings group
            'defaults' => [
				// settings of that group
	            // 0 = name, 1 = default value, ...
                ['pretix_ticket_shop_url', ''],
                ['pretix_ticket_display', 'list'],
                ['pretix_ticket_display_sub_event_id', ''],
                ['pretix_ticket_allocated_voucher', ''],
                ['pretix_ticket_disable_voucher', false],
                ['pretix_ticket_default_language', \get_locale()],
                ['pretix_ticket_filter_by_event', ''],
                ['pretix_ticket_filter_by_product_id', ''],
                ['pretix_ticket_filter_by_category_id', ''],
                ['pretix_ticket_filter_by_variation_id', ''],
                ['pretix_ticket_button_text', __('Buy Ticket!', $this->get_name())],
                ['pretix_ticket_debug_skip_ssl_check', false],
                ['pretix_ticket_custom_css', '']
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
        ?>
		<div class="wrap">
			<h1>Pretix Ticket</h1>
			<p>This is the main page for the Pretix Ticket plugin.</p>
		</div>
        <?php
    }

    public function render_settings_page() {
        require_once($this->get_path('templates/backend/settings-page.php'));
    }

}