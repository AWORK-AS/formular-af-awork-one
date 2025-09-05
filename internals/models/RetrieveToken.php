<?php

/**
 * Retrieve token from API
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Citizenone\Internals\Models;

class RetrieveToken {

    /**
	 * Submit data to generate a token
	 *
	 * @param array<string, mixed> $data
	 * @return object|array<string, mixed>|false|null
	 */
    public function submit( $data ) {
        $response = \wp_remote_post(
            FACIOJ_PLUGIN_API_URL . '/jwt/generate-token',
            array(
				'body'    => \json_encode( $data ),
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

        if ( $status !== 200 ) {
            return false;
        }

        $body = \wp_remote_retrieve_body( $response );
        
        return \json_decode( $body );
    }

}
