<?php
/**
 * Server-side rendering for the contact form block.
 */

function render_contact_form_block($attributes) {
    $renderer = new \Contact_Form_App\Internals\Views\FormRenderer();
    
    // Pass block attributes to the renderer
    if (!empty($attributes['headline'])) {
        add_filter('cfa_form_headline', function() use ($attributes) {
            return $attributes['headline'];
        });
    }
    
    if (!empty($attributes['color'])) {
        add_filter('cfa_form_color', function() use ($attributes) {
            return $attributes['color'];
        });
    }
    
    return $renderer->render_form();
}

function register_contact_form_block() {
    register_block_type_from_metadata(
        __DIR__,
        [
            'render_callback' => 'render_contact_form_block',
        ]
    );
}
add_action('init', 'register_contact_form_block');