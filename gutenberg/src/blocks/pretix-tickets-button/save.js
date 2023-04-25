const { useBlockProps } = wp.blockEditor;

export default function Save({ attributes }) {
	const blockProps = useBlockProps.save();
	const { buttonText } = attributes;
	
	return (
		<div {...blockProps}>
			<button className="pretix-tickets-button">
				{buttonText}
			</button>
		</div>
	);
}
