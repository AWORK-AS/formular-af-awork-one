<?php
/**
 * Formular af AWORK ONE
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Aworkone\Backend;

use mzaworkdk\Aworkone\Engine\Base;
use mzaworkdk\Aworkone\Internals\Models\Retrieve_Token;

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
		if ( ! parent::initialize() ) {
			return;
		}

		// Add the options page and menu item.
		\add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add CMB2 save hook.
		\add_action( 'cmb2_save_options-page_fields', array( $this, 'before_save_settings' ), 10, 2 );

		$realpath        = (string) \realpath( __DIR__ );
		$plugin_basename = \plugin_basename( \plugin_dir_path( $realpath ) . FAAONE_TEXTDOMAIN . '.php' );
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
		 *
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities

		add_options_page( __( 'Page Title', FAAONE_TEXTDOMAIN ), FAAONE_NAME, 'manage_options', FAAONE_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ) );
		 *
		 */

		/*
		 * Add a settings page for this plugin to the main menu
		 *
		 */
		\add_menu_page( \__( 'Contact Form App Settings', 'formular-af-awork-one' ), FAAONE_NAME, 'manage_options', FAAONE_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ), 'dashicons-hammer', 90 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display_plugin_admin_page() {
		if ( ! defined( 'FAAONE_PLUGIN_ROOT' ) ) {
			define( 'FAAONE_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) . '../' );
		}

		include_once FAAONE_PLUGIN_ROOT . 'backend/views/admin.php';
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
				'settings' => '<a href="' . \admin_url( 'options-general.php?page=' . FAAONE_TEXTDOMAIN ) . '">' . \__( 'Settings', 'formular-af-awork-one' ) . '</a>',
			),
			$links
		);
	}

	/**
	 * Action before CMB2 saves settings
	 *
	 * @param string $obj_id Object ID.
	 * @param string $cmb_id CMB2 instance ID.
	 */
	public function before_save_settings( string $obj_id, string $cmb_id ): void {
		if ( ! $this->is_valid_cmb_id( $cmb_id ) ) {
			return;
		}

		$submitted_values = $this->get_sanitized_submitted_values( $cmb_id );

		if ( $this->has_validation_errors( $submitted_values ) ) {
			return;
		}

		$this->process_token_retrieval( $submitted_values );
	}

	/**
	 * Check if CMB ID is valid
	 *
	 * @param string $cmb_id CMB ID.
	 */
	private function is_valid_cmb_id( string $cmb_id ): bool {
		return FAAONE_TEXTDOMAIN . '_options' === $cmb_id;
	}

	/**
	 * Get and sanitize submitted form values
	 *
	 * @param string $cmb_id CMB ID.
	 * @return array Sanitized values.
	 */
	private function get_sanitized_submitted_values( string $cmb_id ) {
		$data = array(
			'company_cvr' => '',
			'company_id'  => '',
			'email'       => '',
		);

		// Nonce verification - CRITICAL!
		if ( ! isset( $_POST[ 'nonce_CMB2php' . $cmb_id ] ) ) {
			return $data;
		}

		if ( ! \wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST[ 'nonce_CMB2php' . $cmb_id ] ) ), 'nonce_CMB2php' . $cmb_id ) ) {
			return $data;
		}

		if ( isset( $_POST[ FAAONE_TEXTDOMAIN . '_field_company_cvr' ] ) ) {
			$data['company_cvr'] = \sanitize_text_field( \wp_unslash( $_POST[ FAAONE_TEXTDOMAIN . '_field_company_cvr' ] ) );
		}

		if ( isset( $_POST[ FAAONE_TEXTDOMAIN . '_field_company_id' ] ) ) {
			$data['company_id'] = \sanitize_text_field( \wp_unslash( $_POST[ FAAONE_TEXTDOMAIN . '_field_company_id' ] ) );
		}

		if ( isset( $_POST[ FAAONE_TEXTDOMAIN . '_field_email' ] ) ) {
			$data['email'] = \sanitize_email( \wp_unslash( $_POST[ FAAONE_TEXTDOMAIN . '_field_email' ] ) );
		}

		return $data;
	}

	/**
	 * Validate required fields
	 *
	 * @param array $values Data.
	 */
	private function has_validation_errors( array $values ): bool {
		$has_errors = false;

		if ( empty( $values['company_cvr'] ) ) {
			$this->add_error_notice( __( 'Company CVR is required.', 'formular-af-awork-one' ) );
			$has_errors = true;
		}

		if ( empty( $values['company_id'] ) ) {
			$this->add_error_notice( __( 'AWORK ONE Company ID is required.', 'formular-af-awork-one' ) );
			$has_errors = true;
		}

		if ( empty( $values['email'] ) ) {
			$this->add_error_notice( __( 'Email address is required.', 'formular-af-awork-one' ) );
			$has_errors = true;
		}

		return $has_errors;
	}

	/**
	 * Add error notice
	 *
	 * @param string $message Message.
	 */
	private function add_error_notice( string $message ): void {
		wpdesk_wp_notice( $message, 'error', true );
	}

	/**
	 * Process token retrieval from API
	 *
	 * @param array $values The data.
	 */
	private function process_token_retrieval( array $values ): void {
		$token = new Retrieve_Token();
		$data  = $token->submit(
			array(
				'company_cvr'         => $values['company_cvr'],
				'aworkone_company_id' => $values['company_id'],
				'email'               => $values['email'],
			)
		);

		$opts = faaone_get_settings();

		if ( ! $data ) {
			$this->handle_api_failure( $opts );
		} else {
			$this->handle_api_success( $opts, $data );
		}
	}

	/**
	 * Handle API failure
	 *
	 * @param array $opts Options.
	 */
	private function handle_api_failure( array $opts ): void {
		if ( isset( $opts[ FAAONE_TEXTDOMAIN . '_token' ] ) ) {
			unset( $opts[ FAAONE_TEXTDOMAIN . '_token' ] );
			update_option( FAAONE_TEXTDOMAIN . '-settings', $opts );
		}

		$error_message = __(
			'The API did not accept the provided data. Please check your information and try again.',
			'formular-af-awork-one'
		);
		wpdesk_wp_notice( $error_message, 'error', true );
	}

	/**
	 * Handle API success
	 *
	 * @param array $opts Options.
	 * @param mixed $data Data.
	 */
	private function handle_api_success( array $opts, $data ): void {
		// Check if $data is an object and has the property 'data'.
		if ( ! is_object( $data ) || ! isset( $data->data ) ) {
			return;
		}

		$opts[ FAAONE_TEXTDOMAIN . '_token' ] = $data->data;
		update_option( FAAONE_TEXTDOMAIN . '-settings', $opts );

		$success_message = __( '✅ Successfully connected to AWORK ONE', 'formular-af-awork-one' );
		wpdesk_wp_notice( $success_message, 'success', true );
	}
}
