/**
 * Version: 1.0.00
 */

// Import WordPress dependencies
const { useEffect, useState } = wp.element;
const { __ } = wp.i18n;
const { TextControl, ToggleControl, SelectControl, PanelBody, Placeholder } = wp.components;
import ServerSideRender from './components/server_side_renderer';

// Destructure WordPress block editor dependencies
const {
	useBlockProps,
	InspectorControls,
} = wp.blockEditor;

// Inject defaults from PHP
const defaults = {};

if (pretixWidgetDefaults) {
	for (const key in pretixWidgetDefaults) {
		if (pretixWidgetDefaults.hasOwnProperty(key)) {
			defaults[key] = pretixWidgetDefaults[key] === '' ? null : pretixWidgetDefaults[key];
		}
	}
}

// Inject languages from PHP or use defaults
const languages = pretixWidgetLanguages ? Object.values(pretixWidgetLanguages) : [
	{
		"code": "en",
		"locale": "en_GB",
		"name": "English",
		"supported": true
	},
	{
		"code": "de",
		"locale": "de_DE",
		"name": "German",
		"supported": true
	},
];

/**
 * Edit Function
 * This function defines the block editor interface and handling for the 'pretix/widget' block.
 * @param {Object} props The block properties and methods.
 * @version 1.0.00
 */
export default function Edit(props) {
	const {
		clientId,
		attributes,
		setAttributes,
	} = props;
	
	// Destructure attributes and add defaults
	const {
		align,
		mode,
		subevent,
		items,
		categories,
		variations,
		allocated_voucher,
		// Settings which can be overwritten by defaults from the WP settings page on first insert
		list_type = defaults.pretix_widget_list_type ?? 'list',
		shop_url = defaults.pretix_widget_shop_url.replace(/\s/g, '').length > 0 ? defaults.pretix_widget_shop_url : '',
		disable_voucher = defaults.pretix_widget_disable_voucher ?? false,
		language = defaults.pretix_widget_language ?? 'en',
		button_text = defaults.pretix_widget_button_text.replace(/\s/g, '').length > 0 ? defaults.pretix_widget_button_text : 'Buy Ticket!',
	} = attributes;
	
	// Use blockProps for block wrapper
	const blockProps = useBlockProps();
	const [loading, setLoading] = useState(false);
	
	/**
	 * handleChange Function
	 * Helper function to update the attribute value.
	 * @param {string} key The key of the attribute to update.
	 * @param {any} value The new value for the attribute.
	 * @version 1.0.00
	 */
	const handleChange = (key, value) => {
		setAttributes({ [key]: value });
	}
	
	/**
	 * isValidUrl Function
	 * Helper function to check if a given URL is valid.
	 * @param {string} url The URL to check.
	 * @returns {boolean} True if the URL is valid, false otherwise.
	 * @version 1.0.00
	 */
	const isValidUrl = (url) => {
		try {
			new URL(url);
			return true;
		} catch (err) {
			return false;
		}
	};
	
	/**
	 * insertScriptAssets Function
	 * Helper function to insert the Pretix widget script assets dynamically.
	 * @version 1.0.00
	 */
	const insertScriptAssets = () => {
		if (isValidUrl(shop_url)) {
			const scriptId = 'pretix-widget-script-' + clientId;
			let script = document.getElementById(scriptId);
			if (script) {
				document.body.removeChild(script);
			}
			script = document.createElement("script");
			script.id = scriptId;
			window.PretixWidget = null;
			
			const url = new URL(shop_url);
			const _url = url.hostname;
			const filename = language.replace('_', '-');
			script.src = `https://${_url}/widget/v1.${filename}.js?timestamp=${Date.now()}`;
			script.async = true;
			script.onload = () => {
				window.PretixWidget.buildWidgets();
			};
			document.body.appendChild(script);
		}
	}
	
	/**
	 * insertCSSAssets Function
	 * Helper function to insert the Pretix widget CSS assets dynamically.
	 * @version 1.0.00
	 */
	const insertCSSAssets = () => {
		if (isValidUrl(shop_url)) {
			const linkId = 'pretix-widget-style-' + clientId;
			let link = document.getElementById(linkId);
			if (link) {
				document.body.removeChild(link);
			}
			link = document.createElement("link");
			link.rel = "stylesheet";
			const url = new URL(shop_url);
			const _url = url.hostname + url.pathname.replace(/\/$/, '')
			link.href = `https://${_url}/widget/v1.css?timestamp=${Date.now()}`;
			document.head.appendChild(link);
		}
	}
	
	/**
	 * EmptyResponsePlaceholder Function
	 * Placeholder component for empty responses during server-side rendering.
	 * @returns {JSX.Element} The JSX for the empty response placeholder.
	 * @version 1.0.00
	 */
	const EmptyResponsePlaceholder = () => <Placeholder label={'Empty'} />;
	
	/**
	 * ErrorResponsePlaceholder Function
	 * Placeholder component for error responses during server-side rendering.
	 * @returns {JSX.Element} The JSX for the error response placeholder.
	 * @version 1.0.00
	 */
	const ErrorResponsePlaceholder = () => <Placeholder label={'Error'} />;
	
	/**
	 * TriggerWhenLoadingFinished Function
	 * Wrapper function for the server-side render trigger.
	 * @param {number} countChildren The number of children blocks.
	 * @returns {Function} The trigger function for server-side rendering.
	 * @version 1.0.00
	 */
	const TriggerWhenLoadingFinished = countChildren => {
		return () => {
			useEffect(() => {
				// Call action when the loading component unmounts because loading is finished.
				return () => {
					insertScriptAssets();
					insertCSSAssets();
				};
			});
			
			return (<Placeholder label={'Loading...'} />);
		};
	};
	
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'pretix-widget')} initialOpen={true}>
					<SelectControl
						label={__('Mode', 'pretix-widget')}
						value={mode}
						options={[
							{ value: 'widget', label: __('Widget', 'pretix-widget') },
							{ value: 'button', label: __('Button', 'pretix-widget') },
						]}
						onChange={(value) => handleChange('mode', value)}
					/>
					{mode === 'button' && (
						<TextControl
							label={__('Button Text', 'pretix-widget')}
							value={button_text}
							onChange={(value) => handleChange('button_text', value)}
						/>
					)}
					<TextControl
						label={__('Shop URL', 'pretix-widget')}
						value={shop_url}
						onChange={(value) => handleChange('shop_url', value)}
						placeholder="https://pretix.eu/demo"
						type="url"
					/>
					<TextControl
						label={__('Sub-Event', 'pretix-widget')}
						value={subevent}
						onChange={(value) => handleChange('subevent', value)}
					/>
					<TextControl
						label={__('Items', 'pretix-widget')}
						value={items}
						onChange={(value) => handleChange('items', value)}
						help={__('Enter a comma-separated list of ID numbers.', 'pretix-widget')}
					/>
					<TextControl
						label={__('Categories', 'pretix-widget')}
						value={categories}
						onChange={(value) => handleChange('categories', value)}
						help={__('Enter a comma-separated list of ID numbers.', 'pretix-widget')}
					/>
					<TextControl
						label={__('Variations', 'pretix-widget')}
						value={variations}
						onChange={(value) => handleChange('variations', value)}
						help={__('Enter a comma-separated list of ID numbers.', 'pretix-widget')}
					/>
					<TextControl
						label={__('Pre-selected voucher', 'pretix-widget')}
						value={allocated_voucher}
						onChange={(value) => handleChange('allocated_voucher', value)}
					/>
					
					<SelectControl
						label={__('List Type', 'pretix-widget')}
						value={list_type}
						options={[
							{ value: 'auto', label: __('Auto', 'pretix-widget') },
							{ value: 'list', label: __('List', 'pretix-widget') },
							{ value: 'week', label: __('Calendar Week', 'pretix-widget') },
							{ value: 'calendar', label: __('Calendar Month', 'pretix-widget') },
						]}
						onChange={(value) => handleChange('list_type', value)}
					/>
					<ToggleControl
						label={__('Disable voucher input', 'pretix-widget')}
						checked={disable_voucher}
						onChange={(value) => handleChange('disable_voucher', value)}
					/>
					<SelectControl
						label={__('Language', 'pretix-widget')}
						value={language}
						options={languages.map(({ code, name }) => ({
							value: code,
							label: name
						}))}
						onChange={(value) => handleChange('language', value)}
					/>
				</PanelBody>
			</InspectorControls>
			
			<div {...blockProps}>
				<ServerSideRender
					block="pretix/widget"
					attributes={attributes}
					LoadingResponsePlaceholder={TriggerWhenLoadingFinished(attributes)}
					EmptyResponsePlaceholder={EmptyResponsePlaceholder}
					ErrorResponsePlaceholder={ErrorResponsePlaceholder}
				/>
			</div>
		</>
	);
}
