<?php

/**
 * Submission of web leads to API
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Citizenone\Internals\Models;

class ContactSubmission {

    public function submit_lead( $data ) {
        // Get plugin options
        $options = \facioj_get_settings();
        $token   = $options[FACIOJ_TEXTDOMAIN . '_token'] ?? false;

        if ( !$token ) {
            return false;
        }

        // Prepare API request
        
        $data = array(
            'name'    => \sanitize_text_field( $data['name'] ),
            'email'   => \sanitize_email( $data['email'] ),
            'company' => \sanitize_text_field( $data['company'] ),
            'phone'   => \sanitize_text_field( $data['phone'] ),
            'message' => \sanitize_textarea_field( $data['message'] ),
        );

        $response = \wp_remote_post(
            FACIOJ_PLUGIN_API_URL . '/web-leads',
            array(
				'body'    => \json_encode( $data ),
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Accept'        => 'application/json',
					'wordpress-key' => $token,
				),
				'timeout' => 15,
			)
            );

        $body = \wp_remote_retrieve_body( $response );
        
        if ( is_wp_error( $response ) ) {
            return false;
        }

        $status = \wp_remote_retrieve_response_code( $response );

        return $status === 200;
    }

}
