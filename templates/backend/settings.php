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
				<label for="pretix_widget_shop_url"><?php _e('Shop URL', $this->get_name()); ?></label>
				<input type="text" name="pretix_widget_shop_url" id="pretix_widget_shop_url" value="<?php echo esc_attr( get_option( 'pretix_widget_shop_url' ) ); ?>" class="regular-text">
			</fieldset>
			<fieldset>
				<label for="pretix_widget_display"><?php _e('Event selection mode', $this->get_name()); ?></label>
				<select name="pretix_widget_display" id="pretix_widget_display">
                    <?php $selected = get_option('pretix_widget_display', 'list'); ?>
					<option value="auto" <?php echo ($selected === 'auto') ? 'selected' : ''; ?>><?php _e('Auto', $this->get_name()); ?></option>
					<option value="list" <?php echo ($selected === 'list') ? 'selected' : ''; ?>><?php _e('List', $this->get_name()); ?></option>
					<option value="week" <?php echo ($selected === 'week') ? 'selected' : ''; ?>><?php _e('Calendar Week', $this->get_name()); ?></option>
					<option value="calendar" <?php echo ($selected === 'calendar') ? 'selected' : ''; ?>><?php _e('Calendar Month', $this->get_name()); ?></option>
				</select>
			</fieldset>
			<fieldset>
				<label for="pretix_widget_disable_voucher"><?php _e('Disable voucher input', $this->get_name()); ?></label>
				<input type="checkbox" name="pretix_widget_disable_voucher" id="pretix_widget_disable_voucher" <?php checked( 'on', get_option( 'pretix_widget_disable_voucher' ) ); ?>>
			</fieldset>
			<fieldset>
				<label for="pretix_widget_language"><?php _e('Default language', $this->get_name()); ?></label>
				<select name="pretix_widget_language" id="pretix_widget_language">
                    <?php $selected = get_option('pretix_widget_language', 'de'); ?>
					<?php
                    foreach($languages as $lang){
						echo '<option value="'.$lang['code'].'"'.($selected === $lang['code'] ? ' selected' : '').'>'.__($lang['name'], $this->get_name()).'</option>';
					}?>
				</select>
			</fieldset>
			<fieldset>
				<label for="pretix_widget_button_text"><?php _e('Button text', $this->get_name()); ?></label>
				<input type="text" name="pretix_widget_button_text" id="pretix_widget_button_text" value="<?php echo esc_attr( get_option( 'pretix_widget_button_text' ) ); ?>" class="regular-text">
			</fieldset>
			<fieldset>
				<label for="pretix_widget_custom_css"><?php _e('Custom CSS', $this->get_name()); ?></label>
				<textarea name="pretix_widget_custom_css" id="pretix_widget_custom_css" rows="10" cols="50" class="large-text"><?php echo esc_html( get_option( 'pretix_widget_custom_css' ) ); ?></textarea>
			</fieldset>
            <?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
				<h2>Debug Settings</h2>
				<fieldset>
					<label for="pretix_widget_debug_skip_ssl_check"><?php _e('Debug skip SSL check', $this->get_name()); ?></label>
					<input type="checkbox" name="pretix_widget_debug_skip_ssl_check" id="pretix_widget_debug_skip_ssl_check" <?php checked( 'on', get_option( 'pretix_widget_debug_skip_ssl_check' ) ); ?>>
				</fieldset>
            <?php endif; ?>
		</form>
	</div>

</div>
