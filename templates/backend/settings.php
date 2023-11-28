<div id="pretix_widget_options" class="pretix-widget-admin-page-wrapper">
    <div id="header">
	    <img width=128" src="<?php echo $this->get_url('assets/images/pretix-logo.svg'); ?>" />
	    <h1>Widget Settings</h1>
	    <p class="submit"><input onclick="pretix_widget_submit_form('pretix-widget-default-settings')" type="button" name="submit" id="submit" class="button button-primary" value="<?php _e('Änderungen speichern', 'pretix-widget');?>"></p>
    </div>
	<nav id="navigation"></nav>
	<div id="content">
		<div class="flex full">
			<div class="left">
				<form id="pretix-widget-default-settings" method="post" action="options.php">
		            <?php \settings_fields( $this->get_settings_group_slug() ); ?>
		            <?php \do_settings_sections( $this->get_settings_group_slug() ); ?>
					<fieldset>
						<label for="pretix_widget_shop_url"><?php _e('Shop URL', 'pretix-widget'); ?></label>
						<input type="text" name="pretix_widget_shop_url" id="pretix_widget_shop_url" value="<?php echo esc_attr( get_option( 'pretix_widget_shop_url' ) ); ?>" class="regular-text">
					</fieldset>
					<fieldset>
						<label for="pretix_widget_list_type"><?php _e('List Type', 'pretix-widget'); ?></label>
						<select name="pretix_widget_list_type" id="pretix_widget_list_type">
		                    <?php $selected = get_option('pretix_widget_list_type', 'list'); ?>
							<option value="auto" <?php echo ($selected === 'auto') ? 'selected' : ''; ?>><?php _e('Auto', 'pretix-widget'); ?></option>
							<option value="list" <?php echo ($selected === 'list') ? 'selected' : ''; ?>><?php _e('List', 'pretix-widget'); ?></option>
							<option value="week" <?php echo ($selected === 'week') ? 'selected' : ''; ?>><?php _e('Calendar Week', 'pretix-widget'); ?></option>
							<option value="calendar" <?php echo ($selected === 'calendar') ? 'selected' : ''; ?>><?php _e('Calendar Month', 'pretix-widget'); ?></option>
						</select>
					</fieldset>
					<fieldset>
						<label for="pretix_widget_disable_voucher"><?php _e('Disable voucher input', 'pretix-widget'); ?></label>
						<input type="checkbox" name="pretix_widget_disable_voucher" id="pretix_widget_disable_voucher" <?php checked( 'on', get_option( 'pretix_widget_disable_voucher' ) ); ?>>
					</fieldset>
					<fieldset>
						<label for="pretix_widget_language"><?php _e('Default language', 'pretix-widget'); ?></label>
						<select name="pretix_widget_language" id="pretix_widget_language">
		                    <?php $selected = get_option('pretix_widget_language', 'de'); ?>
							<?php
		                    foreach($languages as $lang){
								echo '<option value="'.$lang['code'].'"'.($selected === $lang['code'] ? ' selected' : '').'>'.__($lang['name'], 'pretix-widget').'</option>';
							}?>
						</select>
					</fieldset>
					<fieldset>
						<label for="pretix_widget_button_text"><?php _e('Button text', 'pretix-widget'); ?></label>
						<input type="text" name="pretix_widget_button_text" id="pretix_widget_button_text" value="<?php echo esc_attr( get_option( 'pretix_widget_button_text' ) ); ?>" class="regular-text">
					</fieldset>
					<fieldset style="align-items: flex-start;">
						<label for="pretix_widget_custom_css"><?php _e('Custom CSS', 'pretix-widget'); ?></label>
						<textarea name="pretix_widget_custom_css" id="pretix_widget_custom_css" rows="10" cols="50" class="large-text"><?php echo esc_html( get_option( 'pretix_widget_custom_css' ) ); ?></textarea>
					</fieldset>
		            <?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) : ?>
						<h2>Debug Settings</h2>
						<fieldset>
							<label for="pretix_widget_debug_skip_ssl_check"><?php _e('Debug skip SSL check', 'pretix-widget'); ?></label>
							<input type="checkbox" name="pretix_widget_debug_skip_ssl_check" id="pretix_widget_debug_skip_ssl_check" <?php checked( 'on', get_option( 'pretix_widget_debug_skip_ssl_check' ) ); ?>>
						</fieldset>
		            <?php endif; ?>
				</form>
			</div>
			<div class="right">
				<div class="container">
					<h2><?php _e('Default Values for Block and Shortcode', 'pretix-widget'); ?></h2>
					<p>
                        <?php _e('On this page, you can set the default values for the block and shortcode used in the pretix widget. These default values will be applied when you use the pretix widget without specifying any custom parameters.', 'pretix-widget'); ?>
					</p>
					<h3><?php _e('Overriding Defaults with Parameters:', 'pretix-widget'); ?></h3>
					<p>
                        <?php _e('While these default values make it easy to maintain consistency across your website, you have the flexibility to override them whenever you need to. When inserting the pretix widget block or using the shortcode, you can pass specific parameters to customize the widget for that particular instance. For more information on how to use parameters, please refer to the documentation page.', 'pretix-widget'); ?>
					</p>
					<p>
                        <?php _e('Please note that changes made here will apply to all instances of the pretix widget on your website unless you explicitly override them using parameters in the shortcode or block.', 'pretix-widget'); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
