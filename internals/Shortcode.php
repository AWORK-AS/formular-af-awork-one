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

namespace mzaworkdk\Citizenone\Internals;

use mzaworkdk\Citizenone\Internals\Views\FormRenderer;

/**
 * Render shortcode
 */
class Shortcode {

    public function initialize() {
        \add_shortcode( 'facioj_citizenone_form', array( $this, 'render_shortcode' ) );
    }
    
    /**
     * Render shortcode.
     *
     * @param array $attributes Attributes.
     */
    public function render_shortcode( $attributes ): string {
        // Pass block attributes to the renderer
        if ( !empty( $attributes['headline'] ) ) {
            \add_filter(
                'facioj_headline',
                function() use ( $attributes ) {
                    return $attributes['headline'];
                }
                );
        }
        
        if ( !empty( $attributes['color'] ) ) {
            \add_filter(
                'facioj_color',
                function() use ( $attributes ) {
                    return $attributes['color'];
                }
                );
        }

        if ( !empty( $attributes['button_color'] ) ) {
            \add_filter(
                'facioj_button_color',
                function() use ( $attributes ) {
                    return $attributes['button_color'];
                }
                );
        }

        if ( !empty( $attributes['button_text_color'] ) ) {
            \add_filter(
                'facioj_button_text_color',
                function() use ( $attributes ) {
                    return $attributes['button_text_color'];
                }
                );
        }

        $renderer = new FormRenderer;

        return $renderer->render_form();
    }

}
