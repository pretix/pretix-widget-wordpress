const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { TextControl, ToggleControl } = wp.components;
const { serverSideRender } = wp;

registerBlockType('pretix-tickets/widget', {
	title: __('Pretix Tickets Widget', 'pretix-tickets'),
	description: __('A widget for displaying pretix tickets.', 'pretix-tickets'),
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
	edit: ({ attributes, setAttributes }) => {
		const { pretixEvent, subEvent, variant, hideEventTitle } = attributes;
		
		const handlePretixEventChange = (value) => {
			setAttributes({ pretixEvent: value });
		};
		
		const handleSubEventChange = (value) => {
			setAttributes({ subEvent: value });
		};
		
		const handleVariantChange = (value) => {
			setAttributes({ variant: value });
		};
		
		const handleHideEventTitleChange = (value) => {
			setAttributes({ hideEventTitle: value });
		};
		
		return (
			<div>
				<TextControl
					label={__('Pretix Event Slug', 'pretix-tickets')}
					value={pretixEvent}
					onChange={handlePretixEventChange}
					help={__('Enter the pretix event slug.', 'pretix-tickets')}
				/>
				<TextControl
					label={__('Pretix Subevent Slug', 'pretix-tickets')}
					value={subEvent}
					onChange={handleSubEventChange}
					help={__('Enter the pretix subevent slug.', 'pretix-tickets')}
				/>
				<TextControl
					label={__('Pretix Variant', 'pretix-tickets')}
					value={variant}
					onChange={handleVariantChange}
					help={__('Enter the pretix variant.', 'pretix-tickets')}
				/>
				<ToggleControl
					label={__('Hide Event Title', 'pretix-tickets')}
					checked={hideEventTitle}
					onChange={handleHideEventTitleChange}
					help={__('Hide the event title above the tickets widget.', 'pretix-tickets')}
				/>
			</div>
		);
	},
	save: ({ attributes }) => {
		const { pretixEvent, subEvent, variant, hideEventTitle } = attributes;
		
		return (
			<Save pretixEvent={pretixEvent} subEvent={subEvent} variant={variant} hideEventTitle={hideEventTitle} />
		);
	},
});
