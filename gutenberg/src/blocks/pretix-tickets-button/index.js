const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

const Edit = wp.blockEditor.Edit;
const Save = wp.blockEditor.Save;

registerBlockType('pretix-tickets/pretix-tickets-button', {
	title: __('Pretix Tickets Button', 'pretix-tickets'),
	description: __('A button for pretix tickets.', 'pretix-tickets'),
	category: 'widgets',
	icon: 'tickets-alt',
	supports: {
		html: false,
	},
	attributes: {
		buttonText: {
			type: 'string',
			default: '',
		},
	},
	edit: Edit,
	save: Save,
});
