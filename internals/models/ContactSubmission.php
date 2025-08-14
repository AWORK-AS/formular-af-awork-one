<?php
namespace Contact_Form_App\Internals\Models;
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
        $api_url = CFA_PLUGIN_API_URL . '/api/contactform/submit';
        $body = [
            'client_token' => $client_token,
            'name' => \sanitize_text_field($data['name']),
            'email' => \sanitize_email($data['email']),
            'message' => \sanitize_textarea_field($data['message']),
            'source_url' => \esc_url($data['source_url']),
        ];

        $response = \wp_remote_post($api_url, [
            'body' => \json_encode($body),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'timeout' => 15
        ]);

        if (is_wp_error($response)) {
            \error_log('CitizenOne API error: ' . $response->get_error_message());
            return false;
        }

        $status = \wp_remote_retrieve_response_code($response);
        if ($status !== 200) {
            \error_log('CitizenOne API returned status: ' . $status);
            return false;
        }

        return true;
    }
}