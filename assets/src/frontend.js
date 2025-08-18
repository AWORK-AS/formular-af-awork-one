document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.cfa-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formId = form.id.replace('-form', '');
            const formContainer = document.getElementById(formId);
            const messageDiv = formContainer.querySelector('.cfa-message');
            const submitBtn = form.querySelector('.cfa-submit-btn');
            
            submitBtn.disabled = true;
            messageDiv.textContent = __('Sending...', 'contact-form-app');
            messageDiv.className = 'cfa-message cfa-message--loading';
            
            try {
                // Set source_url dynamically
                const sourceUrlInput = form.querySelector('[name="source_url"]');
                if (sourceUrlInput) {
                    sourceUrlInput.value = window.location.href;
                }
                
                const formData = new FormData(form);
                const response = await fetch(
                    `${wpApiSettings.root}contact-form-app/v1/submit`,
                    {
                        method: 'POST',
                        headers: {
                            'X-WP-Nonce': wpApiSettings.nonce,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    }
                );
                
                const data = await response.json();
                
                if (data.success) {
                    messageDiv.className = 'cfa-message cfa-message--success';
                    form.reset();
                } else {
                    messageDiv.className = 'cfa-message cfa-message--error';
                }
                
                messageDiv.textContent = data.message;
            } catch (error) {
                messageDiv.className = 'cfa-message cfa-message--error';
                messageDiv.textContent = __('An error occurred. Please try again.', 'contact-form-app');
            } finally {
                submitBtn.disabled = false;
                
                // Auto-hide message after 5 seconds
                setTimeout(() => {
                    messageDiv.textContent = '';
                    messageDiv.className = 'cfa-message';
                }, 5000);
            }
        });
    });
});