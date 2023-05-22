<div id="pretix_widget_options" class="pretix-widget-admin-page-wrapper">
    <div id="header">
	    <img width=128" src="<?php echo $this->get_url('assets/images/pretix-logo.svg'); ?>" />
	    <h1>Tickets Settings</h1>
	    <p class="submit"><input onclick="pretix_widget_submit_form('pretix-widget-default-settings')" type="button" name="submit" id="submit" class="button button-primary" value="<?php _e('Änderungen speichern', $this->get_name());?>"></p>
    </div>
	<nav id="navigation"></nav>
	<div id="content">
		<form id="pretix-widget-default-settings" method="post" action="options.php">
            <?php \settings_fields( $this->get_settings_group_slug() ); ?>
            <?php \do_settings_sections( $this->get_settings_group_slug() ); ?>
			<fieldset>
				<label for="pretix_widget_shop_url"><?php _e('Shop Url', $this->get_name()); ?></label>
				<input type="text" name="pretix_widget_shop_url" id="pretix_widget_shop_url" value="<?php echo \esc_attr( \get_option( 'pretix_widget_shop_url' ) ); ?>" class="regular-text">
			</fieldset>
			<fieldset>
				<label for="pretix_widget_display"><?php _e('Display tickets', $this->get_name()); ?></label>
				<select name="pretix_widget_display" id="pretix_widget_display">
                    <?php $selected = \get_option('pretix_widget_display', 'list'); ?>
					<option value="list" <?php echo ($selected === 'list') ? 'selected' : ''; ?>><?php _e('List', $this->get_name()); ?></option>
					<option value="calendar_week" <?php echo ($selected === 'calendar_week') ? 'selected' : ''; ?>><?php _e('Calendar (Week)', $this->get_name()); ?></option>
					<option value="calendar_month" <?php echo ($selected === 'calendar_month') ? 'selected' : ''; ?>><?php _e('Calendar (Month)', $this->get_name()); ?></option>
				</select>
			</fieldset>
			<fieldset>
				<label for="pretix_widget_disable_voucher"><?php _e('Disable voucher input', $this->get_name()); ?></label>
				<input type="checkbox" name="pretix_widget_disable_voucher" id="pretix_widget_disable_voucher" <?php checked( 'on', \get_option( 'pretix_widget_disable_voucher' ) ); ?>>
			</fieldset>
			<fieldset>
				<label for="pretix_widget_default_language"><?php _e('Default language', $this->get_name()); ?></label>
				<select name="pretix_widget_default_language" id="pretix_widget_default_language">
                    <?php $selected = \get_option('pretix_widget_default_language', 'de'); ?>
					<option value="de" <?php echo ($selected === 'de') ? 'selected' : ''; ?>><?php _e('German', $this->get_name()); ?></option>
					<option value="en" <?php echo ($selected === 'en') ? 'selected' : ''; ?>><?php _e('English', $this->get_name()); ?></option>
				</select>
			</fieldset>
			<fieldset>
				<label for="pretix_widget_button_text"><?php _e('Button text', $this->get_name()); ?></label>
				<input type="text" name="pretix_widget_button_text" id="pretix_widget_button_text" value="<?php echo \esc_attr( \get_option( 'pretix_widget_button_text' ) ); ?>" class="regular-text">
			</fieldset>
			<fieldset>
				<label for="pretix_widget_custom_css"><?php _e('Custom CSS', $this->get_name()); ?></label>
				<textarea name="pretix_widget_custom_css" id="pretix_widget_custom_css" rows="10" cols="50" class="large-text"><?php echo \esc_html( \get_option( 'pretix_widget_custom_css' ) ); ?></textarea>
			</fieldset>
            <?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
				<h2>Debug Settings</h2>
				<fieldset>
					<label for="pretix_widget_debug_skip_ssl_check"><?php _e('Debug skip SSL check', $this->get_name()); ?></label>
					<input type="checkbox" name="pretix_widget_debug_skip_ssl_check" id="pretix_widget_debug_skip_ssl_check" <?php checked( 'on', \get_option( 'pretix_widget_debug_skip_ssl_check' ) ); ?>>
				</fieldset>
            <?php endif; ?>
		</form>
	</div>

</div>
<style>
	:root {
		--pretix-darkpurple: #3B1C4A;
		--pretix-lightpurple: #7F4A91;
		--pretix-success: #50A167;
		--pretix-warning: #FFB419;
		--pretix-alert: #C44F4F;
		--pretix-info: #5F9CD4;
		--pretix-inactive: #CCCCCC;
		--pretix-secondary: #999999;
	}

	.pretix-widget-admin-page-wrapper{
		padding:0;
		margin-left:-20px;
	}

	.pretix-widget-admin-page-wrapper #header{
		display:flex;
		justify-content: flex-start;
		align-items:center;
		gap:20px;
		background: white;
		padding:20px;
		border-bottom:1px solid var(--pretix-darkpurple);
	}

	.pretix-widget-admin-page-wrapper #header .submit{
		margin-top: auto;
		margin-bottom: auto;
		margin-right:0;
		margin-left: auto;
	}

	.pretix-widget-admin-page-wrapper #content{
		display:flex;
	}

	.pretix-widget-admin-page-wrapper #content > form{
		display:flex;
		flex-direction: column;
		gap:10px;
		padding: 20px;
		flex-basis:100%;
	}

	.pretix-widget-admin-page-wrapper #content fieldset{
		display:flex;
		width:100%;
		max-width:100%;
		flex-direction: row;
		justify-content: flex-start;
		align-items: center;
		gap:20px;
	}

	.pretix-widget-admin-page-wrapper #content fieldset.column{
		flex-direction: column;
		align-items: flex-start;
	}

	.pretix-widget-admin-page-wrapper #content fieldset > label{
		font-weight:bold;
		flex-basis:300px;
	}

	.pretix-widget-admin-page-wrapper #content fieldset.column > label{
		flex-basis:auto;
	}

	.pretix-widget-admin-page-wrapper #pretix_widget_custom_css{
		max-width:600px;
		min-height:250px;
	}

</style>
<script>
	function pretix_widget_submit_form(formId) {
		const form = document.getElementById(formId);
		console.log(form);
		return form ? form.submit() : false;
	}
</script>