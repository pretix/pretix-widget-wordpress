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
					<?php _e('<h2>Using the pretix widget Gutenberg block</h2>
						<p>The pretix widget Gutenberg Block allows you to easily display pretix ticket widgets on your WordPress website using the Gutenberg editor. With this block, you can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.</p>
						<h3>Adding the Block</h3>
						<p>To add the pretix widget Block to your page or post, follow these steps:</p>
						<ul>
						  <li>Go to the page or post where you want to add the ticket widget.</li>
						  <li>Click on the "+" icon to add a new block.</li>
						  <li>Search for "pretix widget" in the block search bar and select it.</li>
						  <li>The pretix widget Block will now be added to your content.</li>
						</ul>
						<h3>Customizing the Block</h3>
						<p>Once you\'ve added the pretix widget Block, you can customize its settings to display the tickets according to your preferences. Here are the available settings and their possible values:</p>
						<ul>
						  <li><strong>Display</strong>: Set the display type of the widget. Possible values: \'list\', \'table\', \'calendar\'.</li>
						  <li><strong>Shop URL</strong>: The URL of your pretix shop. Example: \'https://example.com/pretix-shop\'</li>
						  <li><strong>Subevent</strong>: The subevent you want to display tickets for. Example: \'subevent-1\'</li>
						  <li><strong>Items</strong>: Comma-separated list of item IDs to display. Example: \'1,2,3\'</li>
						  <li><strong>Categories</strong>: Comma-separated list of category IDs to display. Example: \'4,5,6\'</li>
						  <li><strong>Variations</strong>: Comma-separated list of variation IDs to display. Example: \'7,8,9\'</li>
						  <li><strong>Disable Voucher</strong>: Set to \'true\' to disable voucher selection.</li>
						  <li><strong>Allocated Voucher</strong>: The voucher code to allocate to the ticket widget. Example: \'ABC123\'</li>
						  <li><strong>Language</strong>: The language code for the widget. Example: \'en\', \'de\', \'fr\', etc.</li>
						  <li><strong>Button Text</strong>: Custom text for the ticket booking button.</li>
						</ul>
						<h3>Example Usage</h3>
						<p>Here\'s an example of how you can use the pretix widget Block with custom settings:</p>
						<ul>
						  <li>Add the pretix widget Block to your page or post.</li>
						  <li>In the Block settings, set the following attributes:</li>
						  <ul>
						    <li>Display: \'table\'</li>
						    <li>Shop URL: \'https://example.com/pretix-shop\'</li>
						    <li>Language: \'en\'</li>
						    <li>Button Text: \'Get Tickets Now\'</li>
						  </ul>
						  <li>The pretix ticket widget will now be displayed on your page with the specified settings.</li>
						</ul>
						<h3>Notes</h3>
						<ul>
						  <li>Make sure to use a valid pretix shop URL and provide the correct language code for the widget to display the tickets correctly.</li>
						  <li>If you encounter any issues or have questions, feel free to contact the website administrator.</li>
						</ul>
						<p>That\'s it! Now you can easily display pretix ticket widgets on your WordPress website using the pretix widget Gutenberg Block and customize the ticket display to suit your needs.</p>',
						'pretix-widget');
					?>
				</div>
				<div class="container">
					<?php _e('<h2>Using the pretix widget shortcode</h2>
						<p>The pretix widget shortcode allows you to easily display pretix ticket widgets on your website. With this shortcode, you can customize the display of your pretix tickets and provide a seamless ticket booking experience for your users.</p>
						<h3>Basic Usage</h3>
						<p>To use the pretix widget shortcode, simply add the following shortcode to any post or page where you want to display the ticket widget:</p>
						<code>[pretix_widget]</code>
						<h3>Customizing the Widget</h3>
						<p>You can customize the pretix ticket widget by adding various attributes to the shortcode. Here are the available attributes and their possible values:</p>
						<ul>
							<li><strong>display</strong> (string): Set the display type of the widget. Possible values: \'list\', \'table\', \'calendar\'.</li>
							<li><strong>shop_url</strong> (string): The URL of your pretix shop. Example: \'https://pretix.eu/demo\'</li>
							<li><strong>subevent</strong> (string): The subevent you want to display tickets for. Example: \'subevent-1\'</li>
							<li><strong>items</strong> (string): Comma-separated list of item IDs to display. Example: \'1,2,3\'</li>
							<li><strong>categories</strong> (string): Comma-separated list of category IDs to display. Example: \'4,5,6\'</li>
							<li><strong>variations</strong> (string): Comma-separated list of variation IDs to display. Example: \'7,8,9\'</li>
							<li><strong>disable_voucher</strong> (boolean): Set to \'true\' to disable voucher selection.</li>
							<li><strong>allocated_voucher</strong> (string): The voucher code to allocate to the ticket widget. Example: \'ABC123\'</li>
							<li><strong>language</strong> (string): The language code for the widget. Example: \'en\', \'de\', \'fr\', etc.</li>
							<li><strong>button_text</strong> (string): Custom text for the ticket booking button.</li>
						</ul>
						<h3>Example Usage</h3>
						<p>Here\'s an example of how you can use the pretix widget shortcode with custom settings:</p>
						<code>[pretix_widget display="table" shop_url="https://pretix.eu/demo" language="en" button_text="Get Tickets Now"]</code>
						<h3>Notes</h3>
						<ul>
							<li>The shortcode attributes are case-sensitive.</li>
							<li>If an attribute is not provided, the shortcode will use the default values defined in the plugin settings.</li>
							<li>Make sure to use a valid pretix shop URL and provide the correct language code for the widget to display the tickets correctly.</li>
							<li>If you encounter any issues or have questions, feel free to contact the website administrator.</li>
						</ul>
						<p>That\'s it! Now you can easily display pretix ticket widgets on your website using the [pretix_widget] shortcode and customize the ticket display to suit your needs.</p>',
						'pretix-widget'); ?>
				</div>
			</div>
			<div class="right">
				<div class="container">
					<img width=128" src="<?php echo $this->get_url('assets/images/pretix-logo.svg'); ?>" />
					<?php _e('
							<div class="pretix-widget-info-box">
							  <h3>Links</h3>
							  <ul>
							    <li><a href="https://pretix.eu" target="_blank">Visit pretix.eu</a></li>
							    <li><a href="https://pretix.eu/pricing" target="_blank">Pricing</a></li>
							    <li><a href="https://pretix.eu/terms" target="_blank">Terms of Service</a></li>
							    <li><a href="https://pretix.eu/privacy" target="_blank">Privacy Policy</a></li>
							  </ul>
							</div>
							<div class="pretix-widget-info-box">
							  <h3>Sign in</h3>
							  <p>Manage your events and tickets:</p>
							  <a href="https://pretix.eu/control/login" target="_blank" class="button">Sign in</a>
							</div>
							<div class="pretix-widget-info-box">
							  <h3>Social Links</h3>
							  <ul>
							    <li><a href="https://twitter.com/pretixeu" target="_blank">Twitter</a></li>
							    <li><a href="https://pretix.social/@pretix" target="_blank">Mastodon</a></li>
							    <li><a href="https://www.linkedin.com/company/pretix/" target="_blank">LinkedIn</a></li>
							    <li><a href="https://www.youtube.com/channel/UCG1Og1YUpgIJD4geAZLAp5g" target="_blank">YouTube</a></li>
							    <li><a href="https://www.instagram.com/pretix.eu/" target="_blank">Instagram</a></li>
							    <li><a href="https://github.com/pretix" target="_blank">GitHub</a></li>
							  </ul>
							</div>
							<div class="pretix-widget-info-box">
							  <h3>Tech Links</h3>
							  <ul>
							    <li><a href="https://status.pretix.eu/" target="_blank">System Status</a></li>
							    <li><a href="https://docs.pretix.eu/en/latest/api/index.html" target="_blank">REST API</a></li>
							    <li><a href="https://docs.pretix.eu/" target="_blank">Documentation</a></li>
							    <li><a href="https://pretix.eu/about/de/security" target="_blank">Security</a></li>
							  </ul>
							</div>
							<div class="pretix-widget-info-box">
							  <h3>Support</h3>
							  <p>Contact our support team for any questions or assistance:</p>
							  <ul>
							    <li>Email: support@pretix.eu</li>
							    <li>Phone: +49 6221 32177-50</li>
							  </ul>
							</div>',
						'pretix-widget'); ?>
				</div>
			</div>
		</div>
    </div>
</div>
