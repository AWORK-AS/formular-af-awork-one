<?php
namespace Contact_Form_App\Frontend;

class FormHandler {
    public function __construct() {
        \add_action('rest_api_init', [$this, 'register_api_endpoint']);
    }

    public function shortcode_handler() {
        $renderer = new \Contact_Form_App\Internals\Views\FormRenderer();
        return $renderer->render_form();
    }

    public function register_api_endpoint() {
        \register_rest_route('contact-form-app/v1', '/submit', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_form_submission'],
            'permission_callback' => '__return_true'
        ]);
    }

    public function handle_form_submission(\WP_REST_Request $request) {
        // Verify nonce
        $nonce = $request->get_param('nonce');
        if (!\wp_verify_nonce($nonce, 'cfa_form_nonce')) {
            return new \WP_Error('invalid_nonce', 'Security check failed', ['status' => 403]);
        }

        $data = $request->get_params();
        $submission = new \Contact_Form_App\Internals\Models\ContactSubmission();
        
        if ($submission->submit_lead($data)) {
            return new \WP_REST_Response([
                'success' => true,
                'message' => __('Thank you! Your message has been sent.', 'contact-form-app')
            ], 200);
        }
        
        return new \WP_REST_Response([
            'success' => false,
            'message' => __('Failed to send message. Please try again.', 'contact-form-app')
        ], 500);
    }
}