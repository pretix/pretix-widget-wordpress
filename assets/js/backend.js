// save button
function pretix_widget_submit_form(formId) {
	const form = document.getElementById(formId);
	return form ? form.submit() : false;
}