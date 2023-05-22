const { serverSideRender } = wp;

const Save = ({ attributes }) => {
	const { pretixEvent, subEvent, variant, hideEventTitle } = attributes;
	
	const [isLoading, setIsLoading] = React.useState(true);
	const [response, setResponse] = React.useState('');
	
	React.useEffect(() => {
		setIsLoading(true);
		
		const fetchData = async () => {
			try {
				const res = await serverSideRender.getBlocksContent(`[pretix_widget_widget event="${pretixEvent}" subevent="${subEvent}" variant="${variant}" hide_event_title="${hideEventTitle}"]`);
				setResponse(res);
			} catch (err) {
				setResponse(err.message);
			}
			
			setIsLoading(false);
		};
		
		fetchData();
	}, [pretixEvent, subEvent, variant, hideEventTitle]);
	
	return (
		<div className="pretix-widget-widget" dangerouslySetInnerHTML={{ __html: response }} />
	);
};

export default Save;
