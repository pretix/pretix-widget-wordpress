const {__} = wp.i18n;
const { useBlockProps } = wp.blockEditor;
const {
	Button
} = wp.components;

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const { buttonText } = attributes;
	
	const handleButtonTextChange = (newValue) => {
		setAttributes({ buttonText: newValue });
	};
	
	return (
		<div {...blockProps}>
			<Button
				isPrimary
				onClick={() => handleButtonTextChange(prompt(__('Please enter the button text:', 'pretix-tickets')))}
			>
				{buttonText ? buttonText : __('Click to set button text', 'pretix-tickets')}
			</Button>
		</div>
	);
}
