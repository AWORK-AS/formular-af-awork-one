<?php

/**
 * mzaworkdk\Citizenone
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Citizenone\Backend;

use mzaworkdk\Citizenone\Engine\Base;
use mzaworkdk\Citizenone\Internals\Models\RetrieveToken;



/**
 * Create the settings page in the backend
 */
class Settings_Page extends Base {

	/**
	 * @var object|null
	 */


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
		$plugin_basename = \plugin_basename( \plugin_dir_path( $realpath ) . FACIOJ_TEXTDOMAIN . '.php' );
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

		add_options_page( __( 'Page Title', FACIOJ_TEXTDOMAIN ), FACIOJ_NAME, 'manage_options', FACIOJ_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ) );
		 *
		 */
		/*
		 * Add a settings page for this plugin to the main menu
		 *
		 */
		\add_menu_page( \__( 'Contact Form App Settings', 'formular-af-citizenone-journalsystem' ), FACIOJ_NAME, 'manage_options', FACIOJ_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ), 'dashicons-hammer', 90 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display_plugin_admin_page() {
		include_once FACIOJ_PLUGIN_ROOT . 'backend/views/admin.php';
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
				'settings' => '<a href="' . \admin_url( 'options-general.php?page=' . FACIOJ_TEXTDOMAIN ) . '">' . \__( 'Settings', 'formular-af-citizenone-journalsystem' ) . '</a>',
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
		if ( $cmb_id !== FACIOJ_TEXTDOMAIN . '_options' ) {
			return;
		}
		
		// Nonce verification - CRITICAL!
		if ( ! isset( $_POST['nonce_CMB2php' . $cmb_id ] ) ||
			! \wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST['nonce_CMB2php' . $cmb_id ] ) ), 'nonce_CMB2php' . $cmb_id ) ) {
			return;
		}

		$required_error_messages = array();
        $required_error = false;
		// Get the submitted values
		$company_cvr = isset( $_POST[FACIOJ_TEXTDOMAIN . '_field_company_cvr'] ) ? 
						\sanitize_text_field( \wp_unslash( $_POST[FACIOJ_TEXTDOMAIN . '_field_company_cvr'] ) )
						: '';
		$citizenone_company_id = isset( $_POST[FACIOJ_TEXTDOMAIN . '_field_company_id'] ) ? 
								\sanitize_text_field( \wp_unslash( $_POST[FACIOJ_TEXTDOMAIN . '_field_company_id'] ) )
								: '';
		$email = isset( $_POST[FACIOJ_TEXTDOMAIN . '_field_email'] ) ? 
				\sanitize_email( \wp_unslash( $_POST[FACIOJ_TEXTDOMAIN . '_field_email'] ) )
				: '';

		if( empty( $company_cvr ) ) {
			\wpdesk_wp_notice( __( 'Company CVR is required.', 'formular-af-citizenone-journalsystem' ),
			 			'error', 
						true 
					);
			
			
			$required_error = true;
		}

		if( empty( $citizenone_company_id ) ) {
			\wpdesk_wp_notice( __( 'CitizenOne Company ID is required.', 'formular-af-citizenone-journalsystem' ),
							  'error',
							  true
							);
			
			$required_error = true;
		}

		if( empty( $email ) ) {
			\wpdesk_wp_notice( __( 'Email address ID is required.', 'formular-af-citizenone-journalsystem' ),
						 	'error',
							true
							);
			$required_error = true;
		}

		if( $required_error ) {
			return;
		}
        
		$token = new RetrieveToken;
		$data  = $token->submit(
			array(
				'company_cvr'           => $company_cvr,
				'citizenone_company_id' => $citizenone_company_id,
				'email'                 => $email,
				)
			);
		
		$opts = \facioj_get_settings();
		
		if ( !$data ) {
			if( isset( $opts[FACIOJ_TEXTDOMAIN . '_token'] ) ) {
				unset( $opts[FACIOJ_TEXTDOMAIN . '_token'] );
				\update_option( FACIOJ_TEXTDOMAIN . '-settings', $opts );
			}
			\wpdesk_wp_notice( __('The API did not accept the provided data. Please check your information and try again.', 
							      'formular-af-citizenone-journalsystem'
								),
								'error',
								true
							);
			return;
		}
		
		$opts[FACIOJ_TEXTDOMAIN . '_token'] = $data->data;
		\update_option( FACIOJ_TEXTDOMAIN . '-settings', $opts );
		\wpdesk_wp_notice( __( '✅ Successfully connected to CitizenOne', 
							'formular-af-citizenone-journalsystem'
							),
							'success',
							true
						);
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
			\update_option( 'formular-af-citizenone-journalsystem-connected', false );
		}

		// @TODO: Validate the token against the API.
		
		return $value;
	}

}
