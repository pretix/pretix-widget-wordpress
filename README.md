# pretix Widget WordPress plugin

This is the official WordPress plugin to integrate the [pretix Widget](https://docs.pretix.eu/en/latest/user/events/widget.html) or [pretix Button](https://docs.pretix.eu/en/latest/user/events/widget.html#pretix-button) into a WordPress website.
It allows easy WYSIWYG integration through a Gutenberg block as well as a more traditional integration approach using shortcodes.
The plugin works with both pretix Hosted as well as self-hosted installations of pretix.

A detailed documentation can be found within the plugin's settings pages.

![Screenshot of block editor](.github/assets/screenshot_blockedit.png?raw=true "Screenshot of block editor")

## Project status

This project is currently in **public beta**. We're happy about any feedback, just reach out at support@pretix.eu or open an issue on GitHub!

## Installation

This project is not yet available in the WordPress plugin directory (we're working on it).

To install the current beta version, [download a ZIP from GitHub](https://github.com/pretix/pretix-widget-wordpress/archive/refs/heads/main.zip).
In your WordPress admin interface, select **Plugins** → **Add New** → **Upload Plugin** and upload the ZIP file.


## Features

The plugin allows embedding a pretix Widget with the following options:

- Selecting a specific date from an event series
- Filtering for specific product categories, products, or variations
- Pre-selecting a voucher
- Changing the display type (list, month calendar, week calendar)
- Disabling voucher input
- Language selection
- Custom CSS

Plus the following options for a pretix Button:

- Custom button text
- Selecting a specific date from an event series
- Pre-selecting products
- Pre-selecting a voucher
- Custom CSS

The following options from the [Widget docs](https://docs.pretix.eu/en/latest/user/events/widget.html) are currently not implemented:

- Integration with consent tools
- Passing user data
- Integration with Google Analytics

## Security

If you discover a security issue, please contact us at security@pretix.eu and see our [Responsible Disclosure Policy](https://docs.pretix.eu/trust/security/disclosure/) further information.

## Credit

Developed by <a href="https://straightvisions.com">straightvisions GmbH</a>

