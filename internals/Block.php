<?php
namespace Contact_Form_App\Internals;

use Contact_Form_App\Internals\Views\FormRenderer;

/**
 * Block of this plugin, powered by WP_V2_Super_Duper.
 */
class Block extends \WP_V2_Super_Duper {

    /**
     * Sets up the block name and properties.
     * The constructor will handle all the setup.
     */
    public function __construct() {
        $options = [
            'textdomain'     => \CFA_TEXTDOMAIN,
            'base_id'        => 'citizenone-form',
            'name'           => \__('Contact Form', \CFA_TEXTDOMAIN),
            'block-icon'     => 'email',
            'block-category' => 'widgets',
            'block-keywords' => "['form', 'contact', 'awork', 'lead', 'citizenone', 'journalsystem']", // Converted to valid JSON string
            'class_name'     => self::class,
            'editor_script'  => 'plugin-block',
            'widget_ops'     => [
                'classname'   => 'cfa-form-widget',
                'description' => \esc_html__('Displays the ' . CFA_NAME . ' contact form.', \CFA_TEXTDOMAIN),
            ],
            'no_wrap'        => true,
            'arguments'      => [],
            'example'        => [ 
                                    'attributes' => [
                                        'isPreview'  => true
                                    ]
                                ],
        ];

        // The parent constructor will handle the block registration.
        parent::__construct($options);
    }

    /**
     * Renders the form on the front end.
     * This serves as the render_callback for Super Duper.
     */
    public function output($args = [], $widget_args = [], $content = '') {
        $renderer = new FormRenderer();
        return $renderer->render_form();
    }

    /**
     * Initialize the class.
     * Here we'll place the script localization for the editor.
     */
    public function initialize() {
        // Use this hook to pass data to the editor script.
        add_action('enqueue_block_editor_assets', [$this, 'localize_editor_script']);
    }

    /**
     * Function to pass data to the editor JavaScript.
     */
    public function localize_editor_script() {
        // The script handle is typically 'wp-v2-super-duper-blocks-js'
        // or might be different depending on Super Duper's configuration.
        // To be safer, we can target 'wp-blocks'.
        $script_handle = 'wp-blocks'; 

        $options = get_option(\CFA_TEXTDOMAIN . '_options');
        $hcaptcha_site_key = $options[\CFA_TEXTDOMAIN . '_hcaptcha_site_key'] ?? '';

        $data_to_pass = [
            'isConfigured' => !empty($hcaptcha_site_key),
            'previewImage' => plugin_dir_url(__FILE__) . '/assets/images/preview-form.png'
        ];

        wp_localize_script($script_handle, 'cfaBlockData', $data_to_pass);
    }
}