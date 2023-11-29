<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="pretix-widget-placeholder error">
		<img src="<?php echo esc_url($this->get_url('assets/images/RGB-pretix-logo-dark-128.svg'));?>" width="100%" height="auto" />
	<div class="message">
        <?php echo esc_html($this->get_error_html()); ?>
	</div>
</div>