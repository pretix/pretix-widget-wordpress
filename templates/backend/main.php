<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div id="pretix_widget_options" class="pretix-widget-admin-page-wrapper">
    <div id="header">
        <img width=128" src="<?php echo esc_url($this->get_url('assets/images/pretix-logo.svg')); ?>" />
        <h1><?php esc_html_e('Documentation', 'pretix-widget'); ?></h1>
    </div>
    <nav id="navigation"></nav>
    <div id="content">
		<div class="flex full">
			<div class="left">
				<div class="container">
					<h2><?php esc_html_e('Using the pretix widget Gutenberg block', 'pretix-widget'); ?></h2>
					<p><?php esc_html_e('The pretix widget Gutenberg Block allows you to easily display pretix ticket widgets on your WordPress website using the Gutenberg editor. With this block, you can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.', 'pretix-widget'); ?></p>

					<h3><?php esc_html_e('Adding the Block', 'pretix-widget'); ?></h3>
					<p><?php esc_html_e('To add the pretix widget block to your page or post, follow these steps:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php esc_html_e('Go to the page or post where you want to add the ticket widget.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Click on the "+" icon to add a new block.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Search for "pretix widget" in the block search bar and select it.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('The pretix widget block will now be added to your content.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php esc_html_e('Customizing the Block', 'pretix-widget'); ?></h3>
					<p><?php esc_html_e('Once you\'ve added the pretix widget block, you can customize its settings to display the tickets according to your preferences. Here are the available settings and their possible values:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php printf(esc_html__('Mode: Set the display type of the widget. Possible values: %1$s, %2$s. (Default: %1$s)', 'pretix-widget'), 'Widget', 'Button'); ?></li>
						<li><?php printf(esc_html__('List Type: Set the display type of the widget. Possible values: %1$s, %2$s, %3$s.', 'pretix-widget'), 'List', 'Calendar Month', 'Calendar Week'); ?></li>
						<li><?php esc_html_e('Shop URL: The URL of your pretix shop. Example: \'https://pretix.eu/demo/\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Date (Sub-Event): A date within an event series to be pre-selected. Example: \'125\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Products: Comma-separated list of product IDs to display. Example: \'1,2,3\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Categories: Comma-separated list of category IDs to display. Example: \'4,5,6\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Variations: Comma-separated list of variation IDs to display. Example: \'7,8,9\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Disable Voucher: Set to \'true\' to disable voucher selection.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Allocated Voucher: The voucher code to allocate to the ticket widget. Example: \'ABC123\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Date filter: Query to filter date selection. Example: \'attr[Featured]=Yes&attr[Language]=EN\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Disable Filter: Set to \'true\' to disable filter UI (if activated for organizer).', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Language: The language code for the widget. Example: \'en\', \'de\', \'fr\', etc.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Button Text: Custom text for the ticket booking button.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php esc_html_e('Example Usage', 'pretix-widget'); ?></h3>
					<p><?php esc_html_e('Here\'s an example of how you can use the pretix widget Block with custom settings:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php esc_html_e('Add the pretix widget Block to your page or post.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('In the Block settings, set the following attributes:', 'pretix-widget'); ?></li>
						<ul>
							<li><?php esc_html_e('Mode: \'button\'', 'pretix-widget'); ?></li>
							<li><?php esc_html_e('Display: \'list\'', 'pretix-widget'); ?></li>
							<li><?php esc_html_e('Shop URL: \'https://example.com/pretix-shop/\'', 'pretix-widget'); ?></li>
							<li><?php esc_html_e('Language: \'en\'', 'pretix-widget'); ?></li>
							<li><?php esc_html_e('Button Text: \'Get Tickets Now\'', 'pretix-widget'); ?></li>
						</ul>
						<li><?php esc_html_e('The pretix ticket widget will now be displayed on your page with the specified settings.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php esc_html_e('Notes', 'pretix-widget'); ?></h3>
					<ul>
						<li><?php esc_html_e('Make sure to use a valid pretix shop URL and provide the correct language code for the widget to display the tickets correctly.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('If you encounter any issues or have questions, feel free to contact the website administrator.', 'pretix-widget'); ?></li>
					</ul>
					<p><?php esc_html_e('That\'s it! Now you can easily display pretix ticket widgets on your WordPress website using the pretix widget Gutenberg Block and customize the ticket display to suit your needs.', 'pretix-widget'); ?></p>
				</div>
				<div class="container">
					<h2><?php esc_html_e('Using the pretix widget shortcode', 'pretix-widget'); ?></h2>
					<p><?php esc_html_e('The pretix widget shortcode allows you to easily display pretix ticket widgets on your website. With this shortcode, you can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.', 'pretix-widget'); ?></p>
					<h3><?php esc_html_e('Basic Usage', 'pretix-widget'); ?></h3>
					<p><?php esc_html_e('To use the pretix widget shortcode, simply add the following shortcode to any post or page where you want to display the ticket widget:', 'pretix-widget'); ?></p>
					<code>[pretix_widget]</code>

					<h3><?php esc_html_e('Customizing the Widget', 'pretix-widget'); ?></h3>
					<p><?php esc_html_e('You can customize the pretix ticket widget by adding various attributes to the shortcode. Here are the available attributes and their possible values:', 'pretix-widget'); ?></p>
					<ul>
						<li><?php printf(esc_html__('mode (string): Set the display type of the widget. Possible values: %1$s, %2$s. (Default: %1$s)', 'pretix-widget'), 'widget', 'button'); ?></li>
						<li><?php printf(esc_html__('list_type (string): Set the list type of the widget. Possible values: %1$s, %2$s, %3$s.', 'pretix-widget'), 'list', 'calendar', 'week'); ?></li>
						<li><?php esc_html_e('shop_url (string): The URL of your pretix shop. Example: \'https://pretix.eu/demo\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('subevent (string): A sub-event to be pre-selected. Example: \'democon\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('items (string): Comma-separated list of item IDs to display. Example: \'1,2,3\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('categories (string): Comma-separated list of category IDs to display. Example: \'4,5,6\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('variations (string): Comma-separated list of variation IDs to display. Example: \'7,8,9\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('disable_voucher (boolean): Set to \'true\' to disable voucher selection.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('allocated_voucher (string): The voucher code to allocate to the ticket widget. Example: \'ABC123\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('date_filter (string): Query to filter date selection. Example: \'attr[Featured]=Yes&attr[Language]=EN\'', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('disable_filter (boolean): Set to \'true\' to disable filter UI (if activated for organizer).', 'pretix-widget'); ?></li>
						<li><?php printf(esc_html__('language (string): The language code for the widget. Example: %1$s, %2$s, %3$s, etc.', 'pretix-widget'), 'en', 'de', 'fr'); ?></li>
						<li><?php esc_html_e('button_text (string): Custom text for the ticket booking button.', 'pretix-widget'); ?></li>
					</ul>

					<h3><?php esc_html_e('Example Usage', 'pretix-widget'); ?></h3>
					<p><?php esc_html_e('Here\'s an example of how you can use the pretix widget shortcode with custom settings:', 'pretix-widget'); ?></p>
					<code>[pretix_widget list_type="week" shop_url="https://pretix.eu/demo" language="en" button_text="Get Tickets Now"]</code>

					<h3><?php esc_html_e('Notes', 'pretix-widget'); ?></h3>
					<ul>
						<li><?php esc_html_e('The shortcode attributes are case-sensitive.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('If an attribute is not provided, the shortcode will use the default values defined in the plugin settings.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('Make sure to use a valid pretix shop URL and provide the correct language code for the widget to display the tickets correctly.', 'pretix-widget'); ?></li>
						<li><?php esc_html_e('If you encounter any issues or have questions, feel free to contact the website administrator.', 'pretix-widget'); ?></li>
					</ul>
					<p><?php esc_html_e('That\'s it! Now you can easily display pretix ticket widgets on your website using the [pretix_widget] shortcode and customize the ticket display to suit your needs.', 'pretix-widget'); ?></p>

				</div>
			</div>
			<div class="right">
				<div class="container">
					<img width=128" src="<?php echo $this->get_url('assets/images/pretix-logo.svg'); ?>" />
					<div class="pretix-widget-info-box">
						<h3><?php esc_html_e('pretix Hosted', 'pretix-widget'); ?></h3>
						<ul>
							<li><a href="https://pretix.eu" target="_blank"><?php esc_html_e('Visit pretix.eu', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/about/en/pricing" target="_blank"><?php esc_html_e('Pricing', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/about/en/terms" target="_blank"><?php esc_html_e('Terms of Service', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.eu/about/en/privacy" target="_blank"><?php esc_html_e('Privacy Policy', 'pretix-widget'); ?></a></li>
						</ul>
						<p><a href="https://pretix.eu/control/login" target="_blank" class="button"><?php esc_html_e('Sign in', 'pretix-widget'); ?></a></p>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php esc_html_e('Social Links', 'pretix-widget'); ?></h3>
						<ul>
							<li><a href="https://twitter.com/pretixeu" target="_blank"><?php esc_html_e('Twitter', 'pretix-widget'); ?></a></li>
							<li><a href="https://pretix.social/@pretix" target="_blank"><?php esc_html_e('Mastodon', 'pretix-widget'); ?></a></li>
							<li><a href="https://www.linkedin.com/company/pretix/" target="_blank"><?php esc_html_e('LinkedIn', 'pretix-widget'); ?></a></li>
							<li><a href="https://www.youtube.com/channel/UCG1Og1YUpgIJD4geAZLAp5g" target="_blank"><?php esc_html_e('YouTube', 'pretix-widget'); ?></a></li>
							<li><a href="https://www.instagram.com/pretix.eu/" target="_blank"><?php esc_html_e('Instagram', 'pretix-widget'); ?></a></li>
							<li><a href="https://github.com/pretix" target="_blank"><?php esc_html_e('GitHub', 'pretix-widget'); ?></a></li>
						</ul>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php esc_html_e('Tech Links', 'pretix-widget'); ?></h3>
						<ul>
							<li><a href="https://docs.pretix.eu/en/latest/user/events/widget.html" target="_blank"><?php esc_html_e('Widget documentation', 'pretix-widget'); ?></a></li>
							<li><a href="https://docs.pretix.eu/" target="_blank"><?php esc_html_e('Documentation', 'pretix-widget'); ?></a></li>
						</ul>
					</div>

					<div class="pretix-widget-info-box">
						<h3><?php esc_html_e('Support', 'pretix-widget'); ?></h3>
						<p><?php esc_html_e('Contact our support team for any questions or assistance:', 'pretix-widget'); ?></p>
						<ul>
							<li><?php esc_html_e('Email: support@pretix.eu', 'pretix-widget'); ?></li>
							<li><?php esc_html_e('Phone: +49 6221 32177-50', 'pretix-widget'); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
