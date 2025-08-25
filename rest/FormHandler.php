<?php
namespace Contact_Form_App\Rest;

class FormHandler {
    public function __construct() {
        \add_action('rest_api_init', [$this, 'register_api_endpoint']);
        \error_log('rest_api_init:register_api_endpoint');
    }

    public function register_api_endpoint() {
        
        \register_rest_route('contact-form-app/v1', '/submit', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_form_submission'],
            'permission_callback' => function() {
                return true; // Public
            },
            'args' => [
                '_wpnonce' => [
                    'required' => false,
                    'validate_callback' => function($param) {
                        return !empty($param);
                    }
                ]
            ]
        ]);
        
    }

    public function handle_form_submission(\WP_REST_Request $request) {
        // Verify nonce
        $nonce = $request->get_header('X-WP-Nonce');
        if (!\wp_verify_nonce($nonce, 'wp_rest')) {
            return new \WP_Error('invalid_nonce', 'Security check failed', ['status' => 403]);
        }
        $data = $request->get_params();

        $opts = \cfa_get_settings();
        if(!$opts) $opts = [];
        $hcaptcha_site_key = $opts[CFA_TEXTDOMAIN . '_hcaptcha_site_key'] ?? false;
		$hcaptcha_secret_key = $opts[CFA_TEXTDOMAIN . '_hcaptcha_secret_key'] ?? false;
		$hcaptcha_enabled = $hcaptcha_site_key && $hcaptcha_secret_key;

        if($hcaptcha_enabled) {
            if (!isset($data['h-captcha-response']) || empty($data['h-captcha-response'])) {
                return new \WP_Error('hcaptcha_missing', __('Please complete the hCaptcha challenge.', 'contact-form-app'), ['status' => 400]);
            }
            $hcaptcha_response = sanitize_text_field($data['h-captcha-response']);
            $verification_result = $this->verify_hcaptcha($hcaptcha_response);
            if (!$verification_result['success']) {
                return new \WP_Error('hcaptcha_failed', __('hCaptcha verification failed. Please try again.', 'contact-form-app'), ['status' => 403]);
            }
        }

        $token = $opts[CFA_TEXTDOMAIN . '_token'] ?? false;

        if(!$token) {
            return new \WP_Error('not_connected', __('Error occured. Please contact the administrator.', 'contact-form-app'), ['status' => 403]);
        }

        
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

    /**
     * A function to verify the hCaptcha token
     *
     * @param string $token The 'h-captcha-response' from the form.
     * @return array Verification result.
     */
    private function verify_hcaptcha($token) {
        $options = \cfa_get_settings();
        $secret_key = $options[CFA_TEXTDOMAIN . '_hcaptcha_secret_key'] ?? '';

        if (empty($secret_key)) {
            // Error: No secret key configured
            return ['success' => false, 'error-codes' => ['missing-secret-key']];
        }
        $remote_ip = isset($_SERVER['REMOTE_ADDR']) ?  \sanitize_text_field(\wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
        $data = [
            'secret'   => $secret_key,
            'response' => $token,
            'remoteip' => $remote_ip,
        ];

        $verify_url = 'https://hcaptcha.com/siteverify';

        // Use WordPress HTTP API for the request
        $response = wp_remote_post($verify_url, [
            'method'      => 'POST',
            'body'        => $data,
            'timeout'     => 15,
        ]);

        if (is_wp_error($response)) {
            // Connection error to hCaptcha server
            return ['success' => false, 'error-codes' => ['wp-remote-error']];
        }

        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);

        return $result; // $result will contain ['success' => true/false, ...]
    }
}

