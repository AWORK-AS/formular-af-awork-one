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

namespace mzaworkdk\Aworkone\Frontend;

use mzaworkdk\Aworkone\Engine\Base;

/**
 * Enqueue stuff on the frontend
 */
class Enqueue extends Base {

	/**
	 * The shortcode name.
	 *
	 * @var string Shortcode tag name.
	 */
	private $shortcode_tag = 'faaone_aworkone_form';

	/**
	 * The block name
	 *
	 * @var string Block name.
	 */
	private $block_name = 'formular-af-awork-one/contact-form';


	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		// We will change the hook from 'wp_enqueue_scripts' to 'wp'.
		// The 'wp' hook runs after the $post object has been set up.
		\add_action( 'wp', array( $this, 'conditionally_enqueue_assets' ) );
	}

	/**
	 * Checks if the shortcode or block exists before enqueueing assets.
	 *
	 * @return void
	 */
	public function conditionally_enqueue_assets() {
		// Get the global post object.
		global $post;
		if ( ! isset( $post->post_content ) ) {
			return;
		}

		if (
			\has_shortcode( $post->post_content, $this->shortcode_tag )
			|| has_block( $this->block_name, $post->post_content )
			) {
			\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			// Use a later hook for localization.
			\add_action( 'wp_footer', array( $this, 'localize_scripts' ), 5 );
		}
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
		$handle  = FAAONE_TEXTDOMAIN . '-plugin-styles';
		$src     = \plugins_url( 'assets/build/plugin-public.css', FAAONE_PLUGIN_ABSOLUTE );
		$deps    = array(); // No dependencies specified in original Inpsyde code.
		$version = FAAONE_VERSION;
		$media   = 'all';

		\wp_enqueue_style( $handle, $src, $deps, $version, $media );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		$handle    = FAAONE_TEXTDOMAIN . '-plugin-script';
		$src       = \plugins_url( 'assets/build/plugin-public.js', FAAONE_PLUGIN_ABSOLUTE );
		$deps      = array(); // No dependencies specified in original Inpsyde code.
		$version   = FAAONE_VERSION;
		$in_footer = true; // Inpsyde's useAsyncFilter implies defer/async, which often means loading in footer.

		\wp_enqueue_script( $handle, $src, $deps, $version, $in_footer );

		// Add async/defer attributes using script_loader_tag filter.
		\add_filter(
			'script_loader_tag',
			function ( $tag, $handle ) {
				if ( FAAONE_TEXTDOMAIN . '-plugin-script' === $handle ) {
					return str_replace( '<script', '<script async defer', $tag );
				}

				return $tag;
			},
			10,
			2
		);

		// Load hCaptcha.
		$this->load_hcaptcha_script();
	}

	/**
	 * Localize scripts with plugin options
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function localize_scripts() {
		// Only localize if the script is enqueued.
		if ( ! wp_script_is( FAAONE_TEXTDOMAIN . '-plugin-script', 'enqueued' ) ) {
			return;
		}

		// Get plugin options.
		$options = \faaone_get_settings();

		$color               = $options['faaone_color_theme'] ?? '#001A56';
		$headline            = $options['faaone_headline'] ?? 'Get in Touch With Us';
		$hcaptcha_site_key   = $options['faaone_hcaptcha_site_key'] ?? false;
		$hcaptcha_secret_key = $options['faaone_hcaptcha_secret_key'] ?? false;

		$hcaptcha_enabled = false;

		if ( $hcaptcha_site_key && $hcaptcha_secret_key ) {
			$hcaptcha_enabled = true;
		}

		// Localize the script using WordPress standard method.
		wp_localize_script(
			FAAONE_TEXTDOMAIN . '-plugin-script',
			'faaone_form_vars',
			array(
				'rest_url'          => rest_url( 'formular-af-awork-one/v1/submit' ),
				'nonce'             => \wp_create_nonce( 'wp_rest' ),
				'i18n'              => array(
					'loading'           => \__( 'Loading...', 'formular-af-awork-one' ),
					'sending'           => \__( 'Sending...', 'formular-af-awork-one' ),
					'submission_failed' => \__( 'Submission failed', 'formular-af-awork-one' ),
					'invalid_nonce'     => \__( 'Session expired. Please refresh the page.', 'formular-af-awork-one' ),
					'required_field'    => \__( 'This field is required', 'formular-af-awork-one' ),
					'invalid_email'     => \__( 'Please enter a valid email address', 'formular-af-awork-one' ),
					'success_message'   => \__( 'Thank you! Your message has been sent.', 'formular-af-awork-one' ),
				),
				'color'             => $color,
				'headline'          => $headline,
				'hcaptcha_site_key' => $hcaptcha_site_key,
				'hcaptcha_enabled'  => $hcaptcha_enabled,
			)
		);
	}

	/**
	 * Load hCaptcha script
	 *
	 * @since 1.0.0
	 * @return void
	 */
	protected function load_hcaptcha_script() {
		$opts                = \faaone_get_settings();
		$hcaptcha_site_key   = $opts['faaone_hcaptcha_site_key'] ?? false;
		$hcaptcha_secret_key = $opts['faaone_hcaptcha_secret_key'] ?? false;

		$hcaptcha_enabled = false;

		if ( $hcaptcha_site_key && $hcaptcha_secret_key ) {
			$hcaptcha_enabled = true;
		}

		if ( ! $hcaptcha_enabled || \wp_script_is( 'hcaptcha', 'enqueued' ) ) {
			return;
		}

		// Load hCaptcha script if needed.
		wp_enqueue_script( 'hcaptcha', 'https://js.hcaptcha.com/1/api.js', array(), FAAONE_VERSION, true );
	}
}
