<?php
namespace Pretix_Ticket;

class Settings extends Base{
    private $parent;

    public function __construct($parent){
        $this->parent = $parent;

    }

    public function add_plugin_menu() {
        \add_menu_page(
            'Pretix Ticket',
            'Pretix Ticket',
            'manage_options',
            'pretix_ticket',
            array( $this, 'render_plugin_page' ),
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
            array( $this, 'render_settings_page' )
        );

        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function register_settings() {
        \register_setting(
            'pretix_ticket_settings_group',
            'pretix_ticket_url'
        );
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