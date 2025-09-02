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

/**
 * Provide Import and Export of the settings of the plugin
 */
class ImpExp extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		if ( !\current_user_can( 'manage_options' ) ) {
			return;
		}

		// Add the export settings method
		\add_action( 'admin_init', array( $this, 'settings_export' ) );
		// Add the import settings method
		\add_action( 'admin_init', array( $this, 'settings_import' ) );
	}

	/**
	 * Process a settings export from config
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_export() {
		if (
			empty( $_POST[ 'cfa_action' ] ) || //phpcs:ignore WordPress.Security.NonceVerification
			'export_settings' !== \sanitize_text_field( \wp_unslash( $_POST[ 'cfa_action' ] ) ) //phpcs:ignore WordPress.Security.NonceVerification
		) {
			return;
		}

		if ( !\wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST[ 'cfa_export_nonce' ] ) ), 'cfa_export_nonce' ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			return;
		}

		$settings      = array();
		$settings[ 0 ] = \get_option( CFA_TEXTDOMAIN . '-settings' );
		$settings[ 1 ] = \get_option( CFA_TEXTDOMAIN . '-settings-second' );

		\ignore_user_abort( true );

		\nocache_headers();
		\header( 'Content-Type: application/json; charset=utf-8' );
		\header( 'Content-Disposition: attachment; filename=contact_form_app-settings-export-' . \gmdate( 'm-d-Y' ) . '.json' );
		\header( 'Expires: 0' );

		echo \wp_json_encode( $settings, JSON_PRETTY_PRINT );

		exit; // phpcs:ignore
	}

	/**
	 * Process a settings import from a json file
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_import() {
		if (
			empty( $_POST[ 'cfa_action' ] ) || //phpcs:ignore WordPress.Security.NonceVerification
			'import_settings' !== \sanitize_text_field( \wp_unslash( $_POST[ 'cfa_action' ] ) ) //phpcs:ignore WordPress.Security.NonceVerification
		) {
			return;
		}

		if ( !\wp_verify_nonce( \sanitize_text_field( \wp_unslash( $_POST[ 'cfa_import_nonce' ] ) ), 'cfa_import_nonce' ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			return;
		}

		if ( !isset( $_FILES[ 'cfa_import_file' ][ 'name' ] ) ) {
			return;
		}

		$file_name_parts = \explode( '.', \sanitize_text_field( \wp_unslash( $_FILES[ 'cfa_import_file' ][ 'name' ] ) ) ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$extension       = \end( $file_name_parts );

		if ( 'json' !== $extension ) {
			\wp_die( \esc_html__( 'Please upload a valid .json file', 'formular-af-citizenone-journalsystem' ) );
		}

		$import_file = \sanitize_text_field( \wp_unslash( $_FILES[ 'cfa_import_file' ][ 'tmp_name' ] ) ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		if ( empty( $import_file ) ) {
			\wp_die( \esc_html__( 'Please upload a file to import', 'formular-af-citizenone-journalsystem' ) );
		}

		// Retrieve the settings from the file and convert the json object to an array.
		$settings_file = file_get_contents( $import_file );// phpcs:ignore

		if ( $settings_file !== false ) {
			$settings = \json_decode( (string) $settings_file );

			if ( \is_array( $settings ) ) {
				\update_option( CFA_TEXTDOMAIN . '-settings', \get_object_vars( $settings[ 0 ] ) );
				\update_option( CFA_TEXTDOMAIN . '-settings-second', \get_object_vars( $settings[ 1 ] ) );
			}

			\wp_safe_redirect( \admin_url( 'options-general.php?page=' . CFA_TEXTDOMAIN ) );
			exit;
		}

		new \WP_Error(
				'contact_form_app_import_settings_failed',
				\__( 'Failed to import the settings.', 'formular-af-citizenone-journalsystem' )
			);
	}

}
