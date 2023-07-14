const {useEffect, useState} = wp.element;
const { __ } = wp.i18n;
const { TextControl, ToggleControl, SelectControl, PanelBody, Placeholder, Spinner } = wp.components;
import ServerSideRender from './components/server_side_renderer';

const {
	InnerBlocks,
	useBlockProps,
	InspectorControls,
	BlockControls,
	store
} = wp.blockEditor;

// inject defaults from php
const defaults = {};

if(pretixWidgetDefaults){
	for (const key in pretixWidgetDefaults) {
		if (pretixWidgetDefaults.hasOwnProperty(key)) {
			defaults[key] = pretixWidgetDefaults[key] === '' ? null : pretixWidgetDefaults[key];
		}
	}
}

// inject languages from php
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

export default function Edit(props) {
	const {
		clientId,
		attributes,
		setAttributes,
	} = props;

	// add defaults to attributes
	const {
		align,
		mode,
		items,
		categories,
		variations,
		allocated_voucher,
		// settings which can be overwritten by defaults from the wp settings page on first insert
		display =  defaults.pretix_widget_display ?? 'list',
		shop_url = defaults.pretix_widget_shop_url.replace(/\s/g, '').length > 0 ? defaults.pretix_widget_shop_url : '',
		disable_voucher = defaults.pretix_widget_disable_voucher ?? false,
		language = defaults.pretix_widget_language ?? 'en',
		button_text = defaults.pretix_widget_button_text.replace(/\s/g, '').length > 0 ? defaults.pretix_widget_button_text : 'Buy Ticket!',
	} = attributes;

	const blockProps = useBlockProps();
	const [loading, setLoading] = useState(false);
	
	const handleChange = (key, value) => {
		setAttributes({ [key]: value });
	}
	
	function isValidUrl(url) {
		// Regular expression for URL validation
		var urlPattern = /^(https?:\/\/)?[\w.-]+\.[a-zA-Z]{2,}(\/\S*)?$/;
		return urlPattern.test(url);
	}
	
	const insertScriptAssets = () =>{
		if(isValidUrl(shop_url)){
			const scriptId = 'pretix-widget-script-' + clientId;
			let script = document.getElementById(scriptId);
			if(script){
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
	
	const insertCSSAssets = () =>{
		if(isValidUrl(shop_url)) {
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
	
	const EmptyResponsePlaceholder = () => <Placeholder label={'Empty'}/>;
	const ErrorResponsePlaceholder = () => <Placeholder label={'Error'}/>;
	
	// server side render trigger
	const TriggerWhenLoadingFinished = countChildren => {
		return () => {
			useEffect( () => {
				// Call action when the loading component unmounts because loading is finished.
				return () => {
					insertScriptAssets();
					insertCSSAssets();
				};
			} );
			
			return (<Placeholder label={'Loading...'}/>);
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
						type="url"
					/>
					{/*
					<TextControl
						label={__('Event', 'pretix-widget')}
						value={event}
						onChange={(value) => handleChange('event', value)}
					/>*/}
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
						label={__('Event selection mode', 'pretix-widget')}
						value={display}
						options={[
							{ value: 'auto', label: __('Auto', 'pretix-widget') },
							{ value: 'list', label: __('List', 'pretix-widget') },
							{ value: 'week', label: __('Calendar Week', 'pretix-widget') },
							{ value: 'calendar', label: __('Calendar Month', 'pretix-widget') },
						]}
						onChange={(value) => handleChange('display', value)}
					/>
					<ToggleControl
						label={__('Disable voucher input', 'pretix-widget')}
						checked={disable_voucher}
						onChange={(value) => handleChange('disable_voucher', value)}
					/>
					<SelectControl
						label={__('Default Language', 'pretix-widget')}
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
