import './styles/public.scss';

/**
 * @function onload The window.onload function is called when the page is loaded
 */
window.onload = () => {
	// Write in console log the PHP value passed in enqueue_js_vars in frontend/Enqueue.php
	( () => {
		document.addEventListener('DOMContentLoaded', () => {
			// Use event delegation for all form submissions
			document.addEventListener('submit', async (e) => {
				// Check if the submitted element is a CFA form
				if (!e.target.matches('.cfa-form')) return;
				
				e.preventDefault();
				const form = e.target;
				const formContainer = form.closest('.cfa-contact-form');
				const messageDiv = formContainer.querySelector('.cfa-message');
				const restUrl = window.cfa_form_vars.rest_url;

				// Show loading state
				messageDiv.innerHTML = `<div class="cfa-loading">${window.cfa_form_vars.i18n.sending}</div>`;
				messageDiv.classList.remove('error', 'success');

				try {
					const formData = new FormData(form);
					const response = await fetch(restUrl, {
						method: 'POST',
						body: formData
					});

					const result = await response.json();
					
					if (response.ok) {
						messageDiv.innerHTML = `<div class="cfa-success">${result.message}</div>`;
						messageDiv.classList.add('success');
						form.reset();
					} else {
						throw new Error(result.message || window.cfa_form_vars.i18n.submission_failed);
					}
				} catch (error) {
					messageDiv.innerHTML = `<div class="cfa-error">${error.message}</div>`;
					messageDiv.classList.add('error');
				}
			});
		});
		
	} )();
	// Place your public-facing magic js 🪄 here
};
