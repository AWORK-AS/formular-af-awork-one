<?php

/**
 * The "Contact Form" submit handler
 *
 *
 * @package   Contact_Form_App
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */
namespace Contact_Form_App\Rest;

class FormHandler {
    public function __construct() {
        \add_action('rest_api_init', [$this, 'register_api_endpoint']);
       
    }
    
     /**
     * Register API endpoint
     * 
     * @return void
     */
    public function register_api_endpoint() {
        
        \register_rest_route('formular-af-citizenone-journalsystem/v1', '/submit', [
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
    
    /**
     * Handle form submission
     * 
     * @param \WP_REST_Request<array<string, mixed>> $request
     * @return \WP_REST_Response|\WP_Error
     */
    public function handle_form_submission(\WP_REST_Request $request) {
        // Verify nonce
        $nonce = $request->get_header('X-WP-Nonce') ?? '';
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
                return new \WP_Error('hcaptcha_missing', __('Please complete the hCaptcha challenge.', 'formular-af-citizenone-journalsystem'), ['status' => 400]);
            }

            $hcaptcha_response_value = is_string($data['h-captcha-response']) ? $data['h-captcha-response'] : '';
            $hcaptcha_response = \sanitize_text_field($hcaptcha_response_value);
            $verification_result = $this->verify_hcaptcha($hcaptcha_response);
            if (!$verification_result['success']) {
                return new \WP_Error('hcaptcha_failed', __('hCaptcha verification failed. Please try again.', 'formular-af-citizenone-journalsystem'), ['status' => 403]);
            }
        }

        $token = $opts[CFA_TEXTDOMAIN . '_token'] ?? false;

        if(!$token) {
            return new \WP_Error('not_connected', __('Error occured. Please contact the administrator.', 'formular-af-citizenone-journalsystem'), ['status' => 403]);
        }

        
        $submission = new \Contact_Form_App\Internals\Models\ContactSubmission();
        
        if ($submission->submit_lead($data)) {
            return new \WP_REST_Response([
                'success' => true,
                'message' => __('Thank you! Your message has been sent.', 'formular-af-citizenone-journalsystem')
            ], 200);
        }
        
        return new \WP_REST_Response([
            'success' => false,
            'message' => __('Failed to send message. Please try again.', 'formular-af-citizenone-journalsystem')
        ], 500);
    }

    /**
     * Verify the hCaptcha token
     *
     * @param string $token The 'h-captcha-response' from the form.
     * @return array{success: bool, error-codes?: string[]}
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

        // Ensure we always return the expected array structure
        if (!is_array($result) || !isset($result['success'])) {
            return ['success' => false, 'error-codes' => ['invalid-response']];
        }

        return $result; // $result will contain ['success' => true/false, ...]
    }
}

