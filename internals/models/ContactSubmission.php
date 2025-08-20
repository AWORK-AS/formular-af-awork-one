<?php
namespace Contact_Form_App\Internals\Models;

use Contact_Form_App\Class\CitizenOneHttpClient;

class ContactSubmission {
    public function submit_lead($data) {
        // Get plugin options
        $options = \get_option(CFA_TEXTDOMAIN . '_options');
        $client_token = $options[CFA_TEXTDOMAIN . '_token'] ?? '';

        if (empty($client_token)) {
            \error_log('CitizenOne: Missing API token');
            return false;
        }

        // Prepare API request
        
        $data = [
            'client_token' => $client_token,
            'name'    => \sanitize_text_field($data['name']),
            'email'   => \sanitize_email($data['email']),
            'company' => \sanitize_text_field($data['company']),
            'phone'   => \sanitize_text_field($data['phone']),
            'message' => \sanitize_textarea_field($data['message']),
        ];

        $response = \wp_remote_post(CFA_PLUGIN_API_URL . '/web-leads', [
            'body' => \json_encode($data),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            
            return false;
        }

        $status = \wp_remote_retrieve_response_code($response);
        if ($status !== 200) {
            return false;
        }

        return true;
    }
}