// Plain JavaScript - No React/JSX
(function (blocks, i18n, element) {
    var el = element.createElement;
    var __ = i18n.__;

    // Get the data passed from PHP
    var isConfigured = window.cfaBlockData.isConfigured;

    blocks.registerBlockType('contact-form-app/form', {
        apiVersion: 2,
        title: __('Contact Form', 'contact-form-app'),
        icon: 'email',
        category: 'widgets',

        // The edit function determines what appears in the editor.
        edit: function () {
            // We don't need a live preview. Just a placeholder.
            // We'll use el() to create HTML elements.
            
            if (isConfigured) {
                return el(
                    'div',
                    { className: 'cfa-editor-placeholder' },
                    el('p', {}, __('✅ Contact Form with hCaptcha', 'contact-form-app')),
                    el('small', {}, __('The actual form will be displayed on the live website.', 'contact-form-app'))
                );
            } else {
                return el(
                    'div',
                    { className: 'cfa-editor-placeholder-error' },
                    el('p', {}, __('❌ Contact Form: hCaptcha is not configured.', 'contact-form-app')),
                    el('small', {}, __('Please go to the plugin settings to add your hCaptcha Site Key.', 'contact-form-app'))
                );
            }
        },

        // The save function should return null for dynamic blocks.
        // This tells WordPress to "Let PHP (render_callback) handle the frontend display."
        save: function () {
            return null;
        },
    });
})(
    window.wp.blocks,
    window.wp.i18n,
    window.wp.element
);