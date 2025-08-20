<?php
namespace Contact_Form_App\Internals\Models;


class RetrieveToken {

    public function submit($data) {
        $response = \wp_remote_post(CFA_PLUGIN_API_URL . '/jwt/generate-token', [
            'body' => \json_encode($data),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'timeout' => 15
        ]);
        
       

        if (\is_wp_error($response)) {
            return false;
        }
        
        $status = \wp_remote_retrieve_response_code($response);
        if ($status !== 200) {
            return false;
        }

        $body = \wp_remote_retrieve_body( $response );
        
        return \json_decode( $body );
    }
}