<?php
namespace Pretix_Ticket;

final class Pretix_Ticket extends Base{

    private $settings;

    public function __construct() {
        add_shortcode( 'pretix_ticket', array( $this, 'display_pretix_ticket' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_assets' ) );
        add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );

        $this->settings = new Settings($this);
    }

    public function add_plugin_menu() {
        $this->settings->add_plugin_menu();
    }

    // Define methods to handle shortcode and Gutenberg block
    // Method to display the Pretix ticket using shortcode
    public function display_pretix_ticket( $settings = array() ): string {
        $output = '';
        $defaults = $this->settings->get_settings();

         $settings								= shortcode_atts(
            array(
                'display'				=> 'widget',
                'show'                  => $defaults['pretix_ticket_display']
            ),
            $settings,
            'pretix_ticket'
        );

        $template = $this->get_path( 'templates/frontend/shortcode-'.$settings['display'].'.php' );

        ob_start();
        file_exists($template) ? require $template : error_log('Template not found: ' . $template);
        return ob_get_clean();
    }

    // Method to load assets for the Gutenberg block
    public function enqueue_block_assets() {

    }

    // Method to load assets only when the shortcode is used or the Gutenberg block is displayed
    public function load_assets() {
        global $post;
        if ( has_shortcode( $post->post_content, 'pretix_ticket' ) || has_block( 'pretix-ticket/pretix-ticket-block' ) ) {
            wp_enqueue_style( 'pretix-ticket-style', $this->get_url('assets/css/style.css'), array(), '1.0.0', 'all' );
            wp_enqueue_script( 'pretix-ticket-script', $this->get_url('assets/js/script.js'), array(), '1.0.0', true );
        }
    }


}
