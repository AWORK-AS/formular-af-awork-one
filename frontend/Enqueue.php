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

namespace Contact_Form_App\Frontend;

use Contact_Form_App\Engine\Base;

/**
 * Enqueue stuff on the frontend
 */
class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		// Use a later hook for localization
		\add_action( 'wp_footer', array( $this, 'localize_scripts' ), 5 );
	}

	/**
	 * Enqueue assets with WordPress standard functions
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		// Load public-facing style sheet and JavaScript.
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_styles() {
		$handle = CFA_TEXTDOMAIN . '-plugin-styles';
		$src = \plugins_url( 'assets/build/plugin-public.css', CFA_PLUGIN_ABSOLUTE );
		$deps = array(); // No dependencies specified in original Inpsyde code
		$version = CFA_VERSION;
		$media = 'all';

		\wp_enqueue_style( $handle, $src, $deps, $version, $media );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		$handle = CFA_TEXTDOMAIN . '-plugin-script';
		$src = \plugins_url( 'assets/build/plugin-public.js', CFA_PLUGIN_ABSOLUTE );
		$deps = array(); // No dependencies specified in original Inpsyde code
		$version = CFA_VERSION;
		$in_footer = true; // Inpsyde's useAsyncFilter implies defer/async, which often means loading in footer

		\wp_enqueue_script( $handle, $src, $deps, $version, $in_footer );

		// Add async/defer attributes using script_loader_tag filter
		\add_filter( 'script_loader_tag', function( $tag, $handle ) {
			if ( CFA_TEXTDOMAIN . '-plugin-script' === $handle ) {
				return str_replace( '<script', '<script async defer', $tag );
			}
			return $tag;
		}, 10, 2 );
	}

	/**
	 * Localize scripts with plugin options
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function localize_scripts() {
		// Only localize if the script is enqueued
		if (!wp_script_is(CFA_TEXTDOMAIN . '-plugin-script', 'enqueued')) {
			return;
		}
		
		// Get plugin options
		$options = \get_option(CFA_TEXTDOMAIN . '-settings');
		
		$color = $options[CFA_TEXTDOMAIN . '_color_theme'] ?? '#205E77';
		$headline = $options[CFA_TEXTDOMAIN . '_headline'] ?? 'Get in Touch With Us';
		$hcaptcha_site_key = $options[CFA_TEXTDOMAIN . '_hcaptcha_site_key'] ?? false;
		$hcaptcha_secret_key = $options[CFA_TEXTDOMAIN . '_hcaptcha_secret_key'] ?? false;
		$hcaptcha_enabled = $hcaptcha_site_key && $hcaptcha_secret_key;

		
		// Localize the script using WordPress standard method
		wp_localize_script(
			CFA_TEXTDOMAIN . '-plugin-script',
			'cfa_form_vars',
			array(
				'rest_url' => rest_url('contact-form-app/v1/submit'),
				'nonce'    => \wp_create_nonce( 'wp_rest' ),
				'i18n'     => [
					'loading'           => \__('Loading...', 'contact-form-app'),
					'sending'           => \__('Sending...', 'contact-form-app'),
					'submission_failed' => \__('Submission failed', 'contact-form-app'),
					'invalid_nonce'     => \__('Session expired. Please refresh the page.', 'contact-form-app'),
					'required_field'    => \__('This field is required', 'contact-form-app'),
					'invalid_email'     => \__('Please enter a valid email address', 'contact-form-app'),
					'success_message'   => \__('Thank you! Your message has been sent.', 'contact-form-app')
				],
				'color' => $color,
				'headline' => $headline,
				'hcaptcha_site_key' => $hcaptcha_site_key,
				'hcaptcha_enabled'  => $hcaptcha_enabled,
			)
		);
	}
}