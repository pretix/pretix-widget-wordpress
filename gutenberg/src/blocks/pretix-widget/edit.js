const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { TextControl, ToggleControl, SelectControl, PanelBody, ToolbarGroup } = wp.components;
const { serverSideRender: ServerSideRender } = wp;

const {
	InnerBlocks,
	useBlockProps,
	InspectorControls,
	BlockControls,
	store
} = wp.blockEditor;

export default function Edit({ attributes, setAttributes }) {
	const { align, ...otherAttributes } = attributes;
	// add defaults to attributes
	const {
		mode = 'Widget',
		display = 'list',
		shop_url = '',
		event = '',
		items = '',
		categories = '',
		variations = '',
		disable_voucher = false,
		allocated_voucher = '',
		language = 'en',
		button_text = 'Buy Ticket!',
	} = attributes;
	
	function handleChange(key, value) {
		setAttributes({ [key]: value });
	}
	
	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<SelectControl
						label={__('Align', 'pretix-widget')}
						value={attributes.align}
						options={[
							{ value: 'left', label: __('Left', 'pretix-widget') },
							{ value: 'center', label: __('Center', 'pretix-widget') },
							{ value: 'right', label: __('Right', 'pretix-widget') },
							{ value: 'wide', label: __('Wide', 'pretix-widget') },
							{ value: 'full', label: __('Full', 'pretix-widget') },
						]}
						onChange={(value) => setAttributes({ align: value })}
					/>
				</ToolbarGroup>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={__('Settings', 'pretix-widget')} initialOpen={true}>
					<SelectControl
						label={__('Mode', 'pretix-widget')}
						value={mode}
						options={[
							{ value: 'Widget', label: __('Widget', 'pretix-widget') },
							{ value: 'Button', label: __('Button', 'pretix-widget') },
						]}
						onChange={(value) => handleChange('mode', value)}
					/>
					<SelectControl
						label={__('Display', 'pretix-widget')}
						value={display}
						options={[
							{ value: 'list', label: __('List', 'pretix-widget') },
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
			
			<ServerSideRender
				block="pretix/widget"
				attributes={attributes}
			/>
		</>
	);
}
