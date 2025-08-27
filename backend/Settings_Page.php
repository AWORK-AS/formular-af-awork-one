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

namespace Contact_Form_App\Backend;

use Contact_Form_App\Engine\Base;
use Contact_Form_App\Internals\Models\RetrieveToken;

/**
 * Create the settings page in the backend
 */
class Settings_Page extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}
		
		// Add the options page and menu item.
		\add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
    
		// Add CMB2 save hook
        \add_action( 'cmb2_save_options-page_fields', array( $this, 'before_settings_save' ), 10, 2 );

		$realpath        = (string) \realpath( __DIR__ );
		$plugin_basename = \plugin_basename( \plugin_dir_path( $realpath ) . CFA_TEXTDOMAIN . '.php' );
		\add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the Settings menu
		 *
		 * @TODO:
		 *
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities

		add_options_page( __( 'Page Title', CFA_TEXTDOMAIN ), CFA_NAME, 'manage_options', CFA_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ) );
		 *
		 */
		/*
		 * Add a settings page for this plugin to the main menu
		 *
		 */
		\add_menu_page( \__( 'Contact Form App Settings', 'contact-form-app' ), CFA_NAME, 'manage_options', CFA_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ), 'dashicons-hammer', 90 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display_plugin_admin_page() {
		include_once CFA_PLUGIN_ROOT . 'backend/views/admin.php';
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 * @param array $links Array of links.
	 * @return array
	 */
	public function add_action_links( array $links ) {
		return \array_merge(
			array(
				'settings' => '<a href="' . \admin_url( 'options-general.php?page=' . CFA_TEXTDOMAIN ) . '">' . \__( 'Settings', 'contact-form-app' ) . '</a>',
			),
			$links
		);
	}
    
	/**
	 * Action before CMB2 saves settings
	 *
	 * @param int    $object_id Object ID
	 * @param string $cmb_id    CMB2 instance ID
	 */
	public function before_settings_save( $object_id, $cmb_id ) {
		if ( $cmb_id !== CFA_TEXTDOMAIN . '_options' ) {
			return;
		}
		
		// Nonce verification - CRITICAL!
		if ( ! isset( $_POST['nonce_CMB2php' . $cmb_id ] ) ||
			! \wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST['nonce_CMB2php' . $cmb_id ] ) ), 'nonce_CMB2php' . $cmb_id ) ) {
			return;
		}

		$cmb = \cmb2_get_metabox( $cmb_id );

		// Get the submitted values
		$values = $cmb->get_sanitized_values( $_POST );
		
		if ( empty( $values[CFA_TEXTDOMAIN . '_field_email'] )
			|| empty( $values[CFA_TEXTDOMAIN . '_field_company_cvr'] )
			|| empty( $values[CFA_TEXTDOMAIN . '_field_company_id'] )
		) {
			return;
		}

			$token = new RetrieveToken;
			$data  = $token->submit(
				array(
					'company_cvr'           => $values[CFA_TEXTDOMAIN . '_field_company_cvr'],
					'citizenone_company_id' => $values[CFA_TEXTDOMAIN . '_field_company_id'],
					'email'                 => $values[CFA_TEXTDOMAIN . '_field_email'],
			)
				);

		if ( !$data ) {
			return;
		}

		$opts                            = \cfa_get_settings();
		$opts[CFA_TEXTDOMAIN . '_token'] = $data->data;
		\update_option( CFA_TEXTDOMAIN . '-settings', $opts );
	}

	/**
	 * Token validation callback
     *
	 * @since 1.0.0
	 * @param string $value The value of the token field.
	 * @return string Returns an error message if validation fails, or true if validation
     */
	public function validate_token_field( $value ) {
		$value = \sanitize_text_field( $value );

		if ( empty( trim( $value ) ) ) {
			\update_option( 'contact-form-app-connected', false );
		}

		// @TODO: Validate the token against the API.
		
		return $value;
	}

}
