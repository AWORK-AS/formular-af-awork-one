<?php
/**
 * Contact_Form_App
 *
 * @package   Contact_Form_App
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace Contact_Form_App\Internals;

use Contact_Form_App\Internals\Views\FormRenderer;

/**
 * Block of this plugin, powered by WP_V2_Super_Duper.
 */
class Block extends \WP_V2_Super_Duper {

    /**
     * Sets up the block name and properties.
     */
    public function __construct( ) {
        $options = array(
            'textdomain'     => \CFA_TEXTDOMAIN,
            'base_id'        => 'contact-form-app-form',
            'name'           => \__( 'Contact Form', \CFA_TEXTDOMAIN ),
            'block-icon'     => 'email',
            'block-category' => 'widgets',
            'block-keywords' => "['form', 'contact', 'awork', 'lead']",
            'class_name'     => self::class,
            'widget_ops'     => array(
                'classname'   => 'cfa-form-widget',
                'description' => \esc_html__( 'Displays the contact form.', \CFA_TEXTDOMAIN ),
            ),
            'no_wrap'        => true,
            'arguments'      => array(),
        );

        parent::__construct( $options );
    }

    /**
     * Renders the form on the front end.
     */
    public function output( $args = array(), $widget_args = array(), $content = '' ) {
        $renderer = new FormRenderer();
        return $renderer->render_form();
    }

    /**
     * Initialize the class.
     * This method is required by the engine but can be empty for this class.
     */
    public function initialize() {
        // Leave this empty. The filter is now handled globally.
    }
}
