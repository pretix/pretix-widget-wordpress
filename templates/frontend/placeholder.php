<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="pretix-widget-placeholder error">
		<img src="<?php echo $this->get_url('assets/images/RGB-pretix-logo-dark-128.svg');?>" width="100%" height="auto" />
	<div class="message">
        <?php echo $this->get_error_html(); ?>
	</div>
</div>