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
 * This class contain the Enqueue stuff for the backend
 */
class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

        // Register and enqueue assets
        
		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Enqueue admin assets
	 *
	 * @return void
	 */
	public function enqueue_admin_assets() {
		$admin_page = \get_current_screen();
		
		// Enqueue admin styles
		$this->enqueue_admin_styles( $admin_page );
		
		// Enqueue admin scripts
		$this->enqueue_admin_scripts( $admin_page );
	}

	/**
	 * Enqueue block editor assets
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets() {
		// Enqueue block editor styles
		\wp_enqueue_style(
			CFA_TEXTDOMAIN . '-block-editor-style',
			\plugins_url( 'assets/build/plugin-block.css', CFA_PLUGIN_ABSOLUTE ),
			array( 'wp-edit-blocks' ),
			CFA_VERSION
		);
		// Unregister editor script from block.json
		\wp_deregister_script( 'formular-af-citizenone-journalsystem-contact-form-editor-script' );

		// Enqueue block editor script
		\wp_enqueue_script(
			'formular-af-citizenone-journalsystem-contact-form-editor-script',
			\plugins_url( 'assets/build/plugin-block.js', CFA_PLUGIN_ABSOLUTE ),
			array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-api-fetch' ),
			CFA_VERSION,
			false
		);
		
		// Handle translations
		if ( function_exists( 'wp_set_script_translations' ) ) {
			\wp_set_script_translations(
				'formular-af-citizenone-journalsystem-contact-form-editor-script',
				'formular-af-citizenone-journalsystem',
				CFA_PLUGIN_ROOT . 'languages'
			);
		}
		
		// Localize script with hCaptcha settings
		$options             = \get_option( CFA_TEXTDOMAIN . '-settings' );
		$hcaptcha_site_key   = $options[CFA_TEXTDOMAIN . '_hcaptcha_site_key'] ?? false;
		$hcaptcha_secret_key = $options[CFA_TEXTDOMAIN . '_hcaptcha_secret_key'] ?? false;
		$hcaptcha_enabled    = ( $hcaptcha_site_key && $hcaptcha_secret_key );

		\wp_localize_script(
			'formular-af-citizenone-journalsystem-contact-form-editor-script',
			'cfaBlockhCaptcha',
			array(
				'hCaptchaEnabled' => $hcaptcha_enabled,
				'hCaptchaSiteKey' => $hcaptcha_site_key,
			)
		);
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @param \WP_Screen $admin_page The current admin screen.
	 * @return void
	 */
	public function enqueue_admin_styles( $admin_page ) {
		// Main admin style
		\wp_enqueue_style(
			CFA_TEXTDOMAIN . '-admin-style',
			\plugins_url( 'assets/build/plugin-admin.css', CFA_PLUGIN_ABSOLUTE ),
			array( 'dashicons' ),
			CFA_VERSION
		);
		
		// Settings page style
		if ( \is_null( $admin_page ) || 'toplevel_page_formular-af-citizenone-journalsystem' !== $admin_page->id ) {
			return;
		}

		\wp_enqueue_style(
			CFA_TEXTDOMAIN . '-settings-style',
			\plugins_url( 'assets/build/plugin-settings.css', CFA_PLUGIN_ABSOLUTE ),
			array( 'dashicons' ),
			CFA_VERSION
		);
	}
    
	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @param \WP_Screen $admin_page The current admin screen.
	 * @return void
	 */
	public function enqueue_admin_scripts( $admin_page ) {
		// Main admin script
		\wp_enqueue_script(
			CFA_TEXTDOMAIN . '-settings-admin',
			\plugins_url( 'assets/build/plugin-admin.js', CFA_PLUGIN_ABSOLUTE ),
			array(),
			CFA_VERSION,
			true
		);
		
		// Settings page script
		if ( \is_null( $admin_page ) || 'toplevel_page_formular-af-citizenone-journalsystem' !== $admin_page->id ) {
			return;
		}

		\wp_enqueue_script(
			CFA_TEXTDOMAIN . '-settings-script',
			\plugins_url( 'assets/build/plugin-settings.js', CFA_PLUGIN_ABSOLUTE ),
			array( 'jquery-ui-tabs' ),
			CFA_VERSION,
			true
		);
	}

}
