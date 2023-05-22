const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

const Edit = wp.blockEditor.Edit;
const Save = wp.blockEditor.Save;

registerBlockType('pretix-widget/button', {
	title: __('Pretix Widget Button', 'pretix-widget'),
	description: __('A button for pretix widget.', 'pretix-widget'),
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
