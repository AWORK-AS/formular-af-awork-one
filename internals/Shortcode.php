<?php

namespace Contact_Form_App\Internals;

use Contact_Form_App\Internals\Views\FormRenderer;

class Shortcode {

    public function initialize() {
        \add_shortcode( 'citizenone_form', array( $this, 'render_shortcode' ) );
    }
    
    public function render_shortcode( $attributes ) {

        // Pass block attributes to the renderer
        if ( !empty( $attributes['headline'] ) ) {
            \add_filter(
                'cfa_headline',
                function() use ( $attributes ) {
                    return $attributes['headline'];
                }
                );
        }
        
        if ( !empty( $attributes['color'] ) ) {
            \add_filter(
                'cfa_color',
                function() use ( $attributes ) {
                    return $attributes['color'];
                }
                );
        }

        if ( !empty( $attributes['button_color'] ) ) {
            \add_filter(
                'cfa_button_color',
                function() use ( $attributes ) {
                    return $attributes['button_color'];
                }
                );
        }

        if ( !empty( $attributes['button_text_color'] ) ) {
            \add_filter(
                'cfa_button_text_color',
                function() use ( $attributes ) {
                    return $attributes['button_text_color'];
                }
                );
        }

        $renderer = new FormRenderer;
        return $renderer->render_form();
    }

}
