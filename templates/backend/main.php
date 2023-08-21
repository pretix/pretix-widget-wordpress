<div id="pretix_widget_options" class="pretix-widget-admin-page-wrapper">
    <div id="header">
        <img width=128" src="<?php echo $this->get_url('assets/images/pretix-logo.svg'); ?>" />
        <h1><?php _e('Documentation', 'pretix-widget'); ?></h1>
    </div>
    <nav id="navigation"></nav>
    <div id="content">
		<div class="flex full">
			<div class="left">
				<div class="container">
					<h2><?php _e('Using the pretix widget Gutenberg block', 'pretix-widget'); ?></h2>
					<p><?php _e('The pretix widget Gutenberg Block allows you to easily display pretix ticket widgets on your WordPress website using the Gutenberg editor. With this block, you can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.', 'pretix-widget'); ?></p>

					<h3><?php _e('Adding the Block', 'pretix-widget'); ?></h3>
					<p><?php _e('To add the pretix widget block to your page or post, follow these steps:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php _e('Go to the page or post where you want to add the ticket widget.', 'pretix-widget'); ?></li>
						<li><?php _e('Click on the "+" icon to add a new block.', 'pretix-widget'); ?></li>
						<li><?php _e('Search for "pretix widget" in the block search bar and select it.', 'pretix-widget'); ?></li>
						<li><?php _e('The pretix widget block will now be added to your content.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php _e('Customizing the Block', 'pretix-widget'); ?></h3>
					<p><?php _e('Once you\'ve added the pretix widget block, you can customize its settings to display the tickets according to your preferences. Here are the available settings and their possible values:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php printf(__('Mode: Set the display type of the widget. Possible values: %1$s, %2$s. (Default: %1$s)', 'pretix-widget'), 'Widget', 'Button'); ?></li>
						<li><?php printf(__('List Type: Set the display type of the widget. Possible values: %1$s, %2$s, %3$s.', 'pretix-widget'), 'List', 'Calendar Month', 'Calendar Week'); ?></li>
						<li><?php _e('Shop URL: The URL of your pretix shop. Example: \'https://pretix.eu/demo\'', 'pretix-widget'); ?></li>
						<li><?php _e('Sub-Event: A sub-event to be pre-selected. Example: \'democon\'', 'pretix-widget'); ?></li>
						<li><?php _e('Items: Comma-separated list of item IDs to display. Example: \'1,2,3\'', 'pretix-widget'); ?></li>
						<li><?php _e('Categories: Comma-separated list of category IDs to display. Example: \'4,5,6\'', 'pretix-widget'); ?></li>
						<li><?php _e('Variations: Comma-separated list of variation IDs to display. Example: \'7,8,9\'', 'pretix-widget'); ?></li>
						<li><?php _e('Disable Voucher: Set to \'true\' to disable voucher selection.', 'pretix-widget'); ?></li>
						<li><?php _e('Allocated Voucher: The voucher code to allocate to the ticket widget. Example: \'ABC123\'', 'pretix-widget'); ?></li>
						<li><?php _e('Language: The language code for the widget. Example: \'en\', \'de\', \'fr\', etc.', 'pretix-widget'); ?></li>
						<li><?php _e('Button Text: Custom text for the ticket booking button.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php _e('Example Usage', 'pretix-widget'); ?></h3>
					<p><?php _e('Here\'s an example of how you can use the pretix widget Block with custom settings:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php _e('Add the pretix widget Block to your page or post.', 'pretix-widget'); ?></li>
						<li><?php _e('In the Block settings, set the following attributes:', 'pretix-widget'); ?></li>
						<ul>
							<li><?php _e('Mode: \'button\'', 'pretix-widget'); ?></li>
							<li><?php _e('Display: \'list\'', 'pretix-widget'); ?></li>
							<li><?php _e('Shop URL: \'https://example.com/pretix-shop\'', 'pretix-widget'); ?></li>
							<li><?php _e('Language: \'en\'', 'pretix-widget'); ?></li>
							<li><?php _e('Button Text: \'Get Tickets Now\'', 'pretix-widget'); ?></li>
						</ul>
						<li><?php _e('The pretix ticket widget will now be displayed on your page with the specified settings.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php _e('Notes', 'pretix-widget'); ?></h3>
					<ul>
						<li><?php _e('Make sure to use a valid pretix shop URL and provide the correct language code for the widget to display the tickets correctly.', 'pretix-widget'); ?></li>
						<li><?php _e('If you encounter any issues or have questions, feel free to contact the website administrator.', 'pretix-widget'); ?></li>
					</ul>
					<p><?php _e('That\'s it! Now you can easily display pretix ticket widgets on your WordPress website using the pretix widget Gutenberg Block and customize the ticket display to suit your needs.', 'pretix-widget'); ?></p>
				</div>
				<div class="container">
					<h2><?php _e('Using the pretix widget shortcode', 'pretix-widget'); ?></h2>
					<p><?php _e('The pretix widget shortcode allows you to easily display pretix ticket widgets on your website. With this shortcode, you can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.', 'pretix-widget'); ?></p>
					<h3><?php _e('Basic Usage', 'pretix-widget'); ?></h3>
					<p><?php _e('To use the pretix widget shortcode, simply add the following shortcode to any post or page where you want to display the ticket widget:', 'pretix-widget'); ?></p>
					<code>[pretix_widget]</code>

					<h3><?php _e('Customizing the Widget', 'pretix-widget'); ?></h3>
					<p><?php _e('You can customize the pretix ticket widget by adding various attributes to the shortcode. Here are the available attributes and their possible values:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php printf(__('mode (string): Set the display type of the widget. Possible values: %1$s, %2$s. (Default: %1$s)', 'pretix-widget'), 'widget', 'button'); ?></li>
						<li><?php printf(__('list_type (string): Set the list type of the widget. Possible values: %1$s, %2$s, %3$s.', 'pretix-widget'), 'list', 'calendar', 'week'); ?></li>
						<li><?php _e('shop_url (string): The URL of your pretix shop. Example: \'https://pretix.eu/demo\'', 'pretix-widget'); ?></li>
						<li><?php _e('subevent (string): A sub-event to be pre-selected. Example: \'democon\'', 'pretix-widget'); ?></li>
						<li><?php _e('items (string): Comma-separated list of item IDs to display. Example: \'1,2,3\'', 'pretix-widget'); ?></li>
						<li><?php _e('categories (string): Comma-separated list of category IDs to display. Example: \'4,5,6\'', 'pretix-widget'); ?></li>
						<li><?php _e('variations (string): Comma-separated list of variation IDs to display. Example: \'7,8,9\'', 'pretix-widget'); ?></li>
						<li><?php _e('disable_voucher (boolean): Set to \'true\' to disable voucher selection.', 'pretix-widget'); ?></li>
						<li><?php _e('allocated_voucher (string): The voucher code to allocate to the ticket widget. Example: \'ABC123\'', 'pretix-widget'); ?></li>
						<li><?php printf(__('language (string): The language code for the widget. Example: %1$s, %2$s, %3$s, etc.', 'pretix-widget'), 'en', 'de', 'fr'); ?></li>
						<li><?php _e('button_text (string): Custom text for the ticket booking button.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php _e('Example Usage', 'pretix-widget'); ?></h3>
					<p><?php _e('Here\'s an example of how you can use the pretix widget shortcode with custom settings:', 'pretix-widget'); ?></p>
					<code>[pretix_widget list_type="week" shop_url="https://pretix.eu/demo" language="en" button_text="Get Tickets Now"]</code>

					<h3><?php _e('Notes', 'pretix-widget'); ?></h3>
					<ul>
						<li><?php _e('The shortcode attributes are case-sensitive.', 'pretix-widget'); ?></li>
						<li><?php _e('If an attribute is not provided, the shortcode will use the default values defined in the plugin settings.', 'pretix-widget'); ?></li>
						<li><?php _e('Make sure to use a valid pretix shop URL and provide the correct language code for the widget to display the tickets correctly.', 'pretix-widget'); ?></li>
						<li><?php _e('If you encounter any issues or have questions, feel free to contact the website administrator.', 'pretix-widget'); ?></li>
					</ul>
					<p><?php _e('That\'s it! Now you can easily display pretix ticket widgets on your website using the [pretix_widget] shortcode and customize the ticket display to suit your needs.', 'pretix-widget'); ?></p>

				</div>
			</div>
			<div class="right">
				<div class="container">
					<img width=128" src="<?php echo $this->get_url('assets/images/pretix-logo.svg'); ?>" />
					<div class="pretix-widget-info-box">
						<h3><?php _e('Links', 'pretix-widget'); ?></h3>
						<ul>
							<li><a href="https://pretix.eu" target="_blank"><?php _e('Visit pretix.eu', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/pricing" target="_blank"><?php _e('Pricing', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/terms" target="_blank"><?php _e('Terms of Service', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/privacy" target="_blank"><?php _e('Privacy Policy', 'pretix-widget'); ?></a></li>
						</ul>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php _e('Sign in', 'pretix-widget'); ?></h3>
						<p><?php _e('Manage your events and tickets:', 'pretix-widget'); ?></p>
						<a href="https://pretix.eu/control/login" target="_blank" class="button"><?php _e('Sign in', 'pretix-widget'); ?></a>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php _e('Social Links', 'pretix-widget'); ?></h3>
						<ul>
							<li><a href="https://twitter.com/pretixeu" target="_blank"><?php _e('Twitter', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.social/@pretix" target="_blank"><?php _e('Mastodon', 'pretix-widget'); ?></a></li>
							<li><a href="https://www.linkedin.com/company/pretix/" target="_blank"><?php _e('LinkedIn', 'pretix-widget'); ?></a></li>
							<li><a href="https://www.youtube.com/channel/UCG1Og1YUpgIJD4geAZLAp5g" target="_blank"><?php _e('YouTube', 'pretix-widget'); ?></a></li>
							<li><a href="https://www.instagram.com/pretix.eu/" target="_blank"><?php _e('Instagram', 'pretix-widget'); ?></a></li>
							<li><a href="https://github.com/pretix" target="_blank"><?php _e('GitHub', 'pretix-widget'); ?></a></li>
						</ul>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php _e('Tech Links', 'pretix-widget'); ?></h3>
						<ul>
							<li><a href="https://status.pretix.eu/" target="_blank"><?php _e('System Status', 'pretix-widget'); ?></a></li>
							<li><a href="https://docs.pretix.eu/en/latest/api/index.html" target="_blank"><?php _e('REST API', 'pretix-widget'); ?></a></li>
							<li><a href="https://docs.pretix.eu/" target="_blank"><?php _e('Documentation', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/about/de/security" target="_blank"><?php _e('Security', 'pretix-widget'); ?></a></li>
						</ul>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php _e('Support', 'pretix-widget'); ?></h3>
						<p><?php _e('Contact our support team for any questions or assistance:', 'pretix-widget'); ?></p>
						<ul>
							<li><?php _e('Email: support@pretix.eu', 'pretix-widget'); ?></li>
							<li><?php _e('Phone: +49 6221 32177-50', 'pretix-widget'); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
