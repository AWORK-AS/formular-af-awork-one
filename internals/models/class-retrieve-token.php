<?php
/**
 * Retrieve token from API
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Aworkone\Internals\Models;

/**
 * Retrieve the token from AWORK ONE
 */
class Retrieve_Token {

	/**
	 * Submit data to generate a token
	 *
	 * @param array $data Data.
	 * @return mixed|false
	 */
	public function submit( $data ) {
		$json_data = \wp_json_encode( $data );

		// Ensure we have valid JSON before making the request.
		if ( false === $json_data ) {
			return false;
		}

		$response = \wp_remote_post(
			FAAONE_PLUGIN_API_URL . '/jwt/generate-token',
			array(
				'body'    => $json_data,
				'headers' => array(
					'Content-Type' => 'application/json',
					'Accept'       => 'application/json',
				),
				'timeout' => 15,
			)
		);

		if ( \is_wp_error( $response ) ) {
			return false;
		}

		$status = \wp_remote_retrieve_response_code( $response );

		if ( 200 !== $status ) {
			return false;
		}

		$body = \wp_remote_retrieve_body( $response );

		return \json_decode( $body );
	}
}
