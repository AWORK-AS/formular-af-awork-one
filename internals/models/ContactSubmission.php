<?php
namespace Contact_Form_App\Internals\Models;

use Contact_Form_App\Class\CitizenOneHttpClient;

class ContactSubmission {
    public function submit_lead($data) {
        // Get plugin options
        $options = \cfa_get_settings();
        $token = $options[CFA_TEXTDOMAIN . '_token'] ?? '';

        

        // Prepare API request
        
        $data = [
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
                'Accept' => 'application/json',
                'wordpress-key' => $token,
            ],
            'timeout' => 15
        ]);

        $body = \wp_remote_retrieve_body( $response );
        
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