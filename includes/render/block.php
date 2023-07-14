<?php
namespace Pretix_Widget\Render;

class Block extends \Pretix_Widget\Base {
    private $parent;

    public function __construct($parent) {
        $this->parent = $parent;
    }

    public function render(array $settings = []): string {
        $output   = '';
        $defaults = $this->parent->settings;

        $settings = array_merge(array(
            'mode'              => 'widget',
            'display'           => isset($defaults['pretix_widget_display']) ? $defaults['pretix_widget_display'] : 'list',
            'shop_url'          => isset($defaults['pretix_widget_shop_url']) ? rtrim($defaults['pretix_widget_shop_url'],'/') : '',
            'subevent'             => isset($defaults['pretix_widget_subevent']) ? rtrim($defaults['pretix_widget_subevent'], '/') : '',
            'items'             => isset($defaults['pretix_widget_filter_by_item_id']) ? $defaults['pretix_widget_filter_by_item_id'] : '',
            'categories'        => isset($defaults['pretix_widget_filter_by_category_id']) ? $defaults['pretix_widget_filter_by_category_id'] : '',
            'variations'        => isset($defaults['pretix_widget_filter_by_variation_id']) ? $defaults['pretix_widget_filter_by_variation_id'] : '',
            'disable_voucher'   => isset($defaults['pretix_widget_disable_voucher']) ? $defaults['pretix_widget_disable_voucher'] : '',
            'allocated_voucher' => isset($defaults['pretix_widget_allocated_voucher']) ? $defaults['pretix_widget_allocated_voucher'] : '',
            'language'          => isset($defaults['pretix_widget_language']) ? $defaults['pretix_widget_language'] : '',
            'button_text'       => isset($defaults['pretix_widget_button_text']) ? $defaults['pretix_widget_button_text'] : '',
        ), array_filter($settings, function ($value) {
            return !empty($value);
        }));

        // add debug settings
        if ($this->parent->debug) {
            $settings['skip_ssl_check'] = isset($defaults['pretix_widget_debug_skip_ssl_check']) ? $defaults['pretix_widget_debug_skip_ssl_check'] : false;
        }

        $template  = $this->get_path('templates/frontend/block-' . $settings['mode'] . '.php');
        $language  = $this->get_short_locale($settings['language']);
        $arguments = $this->get_arguments_inline($settings);
        ob_start();
        if($this->validate_args($settings)){
            file_exists($template) ? require $template : error_log('Template not found: ' . $template);
            if(!defined( 'REST_REQUEST' )){
                // frontend
                $this->enqueue_assets($settings);
            } // else: rest api
        }else{
            require $this->get_path('templates/frontend/placeholder.php');
        }

        return ob_get_clean();
    }

    // helper functions
    //@todo css is relative the set shop url and event - add curl and caching
    private function enqueue_assets($settings){
        wp_enqueue_style('pretix-widget-frontend',
            rtrim($settings['shop_url'],'/').'/widget/v1.css',
            array(),
            1
        );

        $parsedUrl = parse_url($settings['shop_url']);
        $domain = rtrim($parsedUrl['host'], '/');

        wp_enqueue_script('pretix-widget-frontend',
            'https://'.$domain.'/widget/v1.'.str_replace('_', '-', $settings['language']).'.js',
            array(),
            1,
            true);
    }

    private function enqueue_assets_inline($settings){
        echo '<link rel="stylesheet" type="text/css" href="'.$this->get_url('assets/css/widget.v1.css').'">';
        echo '<script type="text/javascript" src="'.$this->get_url('assets/js/widget.v1.'.str_replace('_', '-', $settings['language']).'.js').'" async></script>';
    }


    private function get_arguments_inline($settings) {
        $arguments = [];

        $arguments['list'] = 'list-type="' . $settings['display'] . '"';
        // URL -----------------------------------------------------------------
        $arguments['url'] = 'event="' . rtrim($settings['shop_url'], '/') . '/"';
        // URL -----------------------------------------------------------------

        if ( ! empty($settings['subevent'])) {
            $arguments['subevent'] =  'subevent="' .$settings['subevent'] . '"';
        }
        
        if ( ! empty($settings['items'])) {
            $arguments['items'] = 'items="';
            // button mode supports strings, widget mode only numbers
            $arguments['items'] .= $settings['mode'] === 'widget' ? preg_replace('/[^0-9,]/', '', $settings['items']) : $settings['items'];
            $arguments['items'] .= '"';
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

    private function validate_args(array $args): bool{
        $error = [];

        if(!isset($args['shop_url']) || !$this->validate_shop_url($args['shop_url'])){
            $this->set_error(__('Shop URL missing.', 'pretix-widget'));
        }

        return empty($this->get_errors()) ? true : false;
    }

    // validator
    private function validate_shop_url(string $value): bool{
        if(!filter_var($value, FILTER_VALIDATE_URL)) return false;
        if(empty($value)) return false;
        return  true;
    }
}