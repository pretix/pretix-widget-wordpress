const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { TextControl, ToggleControl } = wp.components;
const { serverSideRender } = wp;

registerBlockType('pretix-widget/pretix-widget-widget', {
	title: __('Pretix Widget Widget', 'pretix-widget'),
	description: __('A widget for displaying pretix widget.', 'pretix-widget'),
	icon: 'tickets-alt',
	category: 'widgets',
	attributes: {
		pretixEvent: {
			type: 'string',
			default: '',
		},
		subEvent: {
			type: 'string',
			default: '',
		},
		variant: {
			type: 'string',
			default: '',
		},
		hideEventTitle: {
			type: 'boolean',
			default: false,
		},
	},
	edit: class Edit extends React.Component {
		constructor(props) {
			super(props);
			
			this.handlePretixEventChange = this.handlePretixEventChange.bind(this);
			this.handleSubEventChange = this.handleSubEventChange.bind(this);
			this.handleVariantChange = this.handleVariantChange.bind(this);
			this.handleHideEventTitleChange = this.handleHideEventTitleChange.bind(this);
		}
		
		handlePretixEventChange(value) {
			this.props.setAttributes({ pretixEvent: value });
		}
		
		handleSubEventChange(value) {
			this.props.setAttributes({ subEvent: value });
		}
		
		handleVariantChange(value) {
			this.props.setAttributes({ variant: value });
		}
		
		handleHideEventTitleChange(value) {
			this.props.setAttributes({ hideEventTitle: value });
		}
		
		render() {
			const { attributes } = this.props;
			const { pretixEvent, subEvent, variant, hideEventTitle } = attributes;
			
			return (
				<div>
					<TextControl
						label={__('Pretix Event Slug', 'pretix-widget')}
						value={pretixEvent}
						onChange={this.handlePretixEventChange}
						help={__('Enter the pretix event slug.', 'pretix-widget')}
					/>
					<TextControl
						label={__('Pretix Subevent Slug', 'pretix-widget')}
						value={subEvent}
						onChange={this.handleSubEventChange}
						help={__('Enter the pretix subevent slug.', 'pretix-widget')}
					/>
					<TextControl
						label={__('Pretix Variant', 'pretix-widget')}
						value={variant}
						onChange={this.handleVariantChange}
						help={__('Enter the pretix variant.', 'pretix-widget')}
					/>
					<ToggleControl
						label={__('Hide Event Title', 'pretix-widget')}
						checked={hideEventTitle}
						onChange={this.handleHideEventTitleChange}
						help={__('Hide the event title above the tickets widget.', 'pretix-widget')}
					/>
				</div>
			);
		}
	},
	save: ({ attributes }) => {
		const { pretixEvent, subEvent, variant, hideEventTitle } = attributes;
		
		return (
			<Save pretixEvent={pretixEvent} subEvent={subEvent} variant={variant} hideEventTitle={hideEventTitle} />
		);
	},
});
