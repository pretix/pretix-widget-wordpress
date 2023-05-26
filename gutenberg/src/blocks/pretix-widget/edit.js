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

export default function Edit(props) {
	const {
		clientId,
		attributes,
		setAttributes,
	} = props;

	// add defaults to attributes
	const {
		align,
		mode = 'widget',
		display = 'list',
		shop_url = '',
		items = '',
		categories = '',
		variations = '',
		disable_voucher = false,
		allocated_voucher = '',
		language = 'en',
		button_text = 'Buy Ticket!',
	} = attributes;
	
	const blockProps = useBlockProps();
	
	const [loading, setLoading] = useState(false);
	
	const handleChange = (key, value) => {
		setAttributes({ [key]: value });
	}
	
	const insertScriptAssets = () =>{
		const scriptId = 'pretix-widget-script-' + clientId;
		let script = document.getElementById(scriptId);
		if(script){
			document.body.removeChild(script);
		}
		script = document.createElement("script");
		script.id = scriptId;
		window.PretixWidget = null;
		
		const url = new URL(shop_url);
		script.src = `https://${url.hostname}/widget/v1.${language}.js?timestamp=${Date.now()}`;
		script.async = true;
		script.onload = () => {
			window.PretixWidget.buildWidgets();
		};
		document.body.appendChild(script);
		setLoading(false);
	}
	
	const insertCSSAssets = () =>{
		const linkId = 'pretix-widget-style-' + clientId;
		let link = document.getElementById(linkId);
		if(link){
			document.body.removeChild(link);
		}
		link = document.createElement("link");
		link.rel = "stylesheet";
		link.href = `https://pretix.eu/demo/democon/widget/v1.css?timestamp=${Date.now()}`;
		document.head.appendChild(link);
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
						label={__('Allocated Voucher', 'pretix-widget')}
						value={allocated_voucher}
						onChange={(value) => handleChange('allocated_voucher', value)}
					/>
					
					<SelectControl
						label={__('Display', 'pretix-widget')}
						value={display}
						options={[
							{ value: 'list', label: __('List', 'pretix-widget') },
							{ value: 'calendar', label: __('Calendar', 'pretix-widget') },
							{ value: 'week', label: __('Week', 'pretix-widget') },
							{ value: 'grid', label: __('Grid', 'pretix-widget') },
						]}
						onChange={(value) => handleChange('display', value)}
					/>
					<ToggleControl
						label={__('Disable Voucher', 'pretix-widget')}
						checked={disable_voucher}
						onChange={(value) => handleChange('disable_voucher', value)}
					/>
					<SelectControl
						label={__('Default Language', 'pretix-widget')}
						value={language}
						options={[
							{ value: 'de', label: __('German', 'pretix-widget') },
							{ value: 'en', label: __('English', 'pretix-widget') },
						]}
						onChange={(value) => handleChange('language', value)}
					/>
				</PanelBody>
			</InspectorControls>
			
			<div {...blockProps}>
				<ServerSideRender
					block="pretix/widget"
					attributes={attributes}
					LoadingResponsePlaceholder={TriggerWhenLoadingFinished( attributes )}
					EmptyResponsePlaceholder={EmptyResponsePlaceholder}
					ErrorResponsePlaceholder={ErrorResponsePlaceholder}
				/>
			</div>
		</>
	);
}
