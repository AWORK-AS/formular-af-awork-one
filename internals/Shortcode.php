<?php
namespace Contact_Form_App\Internals;

use Contact_Form_App\Internals\Views\FormRenderer;

class Shortcode {
    public function initialize() {
        \add_shortcode('citizenone_form', [$this, 'render_shortcode']);
    }
    
    public function render_shortcode() {
        $renderer = new FormRenderer();
        return $renderer->render_form();
    }
}