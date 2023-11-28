<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<noscript>
	<div class="pretix-widget-no-script">
        <?php
        $no_script_message = sprintf(
            esc_html__('JavaScript is disabled in your browser. To access our ticket shop without JavaScript, please click %shere%s.', 'your-text-domain'),
            '<a target="_blank" rel="noopener" href="' . esc_url($fallback_url) . '">',
            '</a>'
        );
        echo wp_kses_post($no_script_message);
        ?>
	</div>
</noscript>
