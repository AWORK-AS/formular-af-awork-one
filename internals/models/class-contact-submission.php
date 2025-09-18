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

/**
 * This class contain the submission of Web Leads
 */
class Contact_Submission {

	/**
	 * Submit lead
	 *
	 * @param array $data Data.
	 * @return bool.
	 */
	public function submit_lead( $data ): bool {
		// Get plugin options.
		$options = \facioj_get_settings();
		$token   = $options[ FACIOJ_TEXTDOMAIN . '_token' ] ?? false;

		if ( ! $token ) {
			return false;
		}

		// Prepare API request.

		$lead_data      = array(
			'name'    => \sanitize_text_field( $data['name'] ),
			'email'   => \sanitize_email( $data['email'] ),
			'company' => \sanitize_text_field( $data['company'] ),
			'phone'   => \sanitize_text_field( $data['phone'] ),
			'message' => \sanitize_textarea_field( $data['message'] ),
		);
		$json_lead_data = \wp_json_encode( $lead_data );

		if ( false === $json_lead_data ) {
			return false;
		}

		$response = \wp_remote_post(
			FACIOJ_PLUGIN_API_URL . '/web-leads',
			array(
				'body'    => $json_lead_data,
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Accept'        => 'application/json',
					'wordpress-key' => $token,
				),
				'timeout' => 15,
			)
		);
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$status = \wp_remote_retrieve_response_code( $response );

		return 200 === $status;
	}
}
