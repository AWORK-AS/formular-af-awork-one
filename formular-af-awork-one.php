<?php
/**
 * Contact form for AWORK ONE
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://github.com/mz-aworkdk
 *
 * Plugin Name:     Formular af AWORK ONE
 * Plugin URI:      https://github.com/AWORK-AS/contact-form-app
 * Description:     Formular af AWORK ONE
 * Version:         1.0.0
 * Author:          support@aworkone.dk
 * Author URI:      https://aworkone.dk/kontakt-os/
 * Text Domain:     formular-af-awork-one
 * License:         GPLv3+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.4
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

// Define constants that are safe to be global.
define( 'FAAONE_PLUGIN_ABSOLUTE', __FILE__ );
define( 'FAAONE_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'FAAONE_TEXTDOMAIN', 'formular-af-awork-one' );
define( 'FAAONE_VERSION', '1.0.0' );
define( 'FAAONE_MIN_PHP_VERSION', '7.4' );
define( 'FAAONE_WP_VERSION', '5.8' );
define( 'FAAONE_PLUGIN_API_URL', 'https://appserver.citizenone.dk/api' );
define( 'FAAONE_PLUGIN_API_NAME', 'Formular af AWORK ONE' );
define( 'FAAONE_NAME', 'Formular af AWORK ONE' );
/**
 * The main function that initializes the plugin.
 *
 * This function is hooked to 'init' to ensure all WordPress functionalities,
 * including user data and translations, are ready.
 */
function faaone_initialize_plugin(): void {
	// Require necessary files.
	$faaone_libraries = require FAAONE_PLUGIN_ROOT . 'vendor/autoload.php';
	require_once FAAONE_PLUGIN_ROOT . 'functions/functions.php';
	require_once FAAONE_PLUGIN_ROOT . 'functions/debug.php';

	// Check for requirements.
	$requirements = new \Micropackage\Requirements\Requirements(
		__( 'Formular af AWORK ONE', 'formular-af-awork-one' ),
		array(
			'php'            => FAAONE_MIN_PHP_VERSION,
			'php_extensions' => array( 'mbstring' ),
			'wp'             => FAAONE_WP_VERSION,
		)
	);

	if ( ! $requirements->satisfied() ) {
		add_action( 'admin_notices', array( $requirements, 'print_notice' ) );

		return;
	}

	// Set up the update checker.
	\YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/AWORK-AS/formular-af-awork-one',
		FAAONE_PLUGIN_ABSOLUTE,
		FAAONE_TEXTDOMAIN
	);
	// Initialize the plugin's core engine.
	new \mzaworkdk\Aworkone\Engine\Initialize( $faaone_libraries );
	// Load Contact form block.
	add_action(
		'enqueue_block_assets',
		function () {
			// Only load on frontend.
			if ( is_admin() ) {
				return;
			}
		}
	);
	// Use block.json for block registration.
	$block_json_path = FAAONE_PLUGIN_ROOT . 'assets/block.json';

	if ( ! file_exists( $block_json_path ) ) {
		return;
	}

	register_block_type( $block_json_path );
}

// Hook the initializer function to 'init'.
add_action( 'init', 'faaone_initialize_plugin' );



/**
 * Register activation and deactivation hooks.
 * These hooks are safe to be registered globally as they only create a hook,
 * they don't execute the class methods immediately.
 */

/**
 * Handle activation - use a separate function to avoid class dependency issues
 *
 * @param bool $network_wide Network wide.
 */
function faaone_activate_plugin( $network_wide ): void {
	// Double-check if constant is defined.
	if ( ! defined( 'FAAONE_PLUGIN_ROOT' ) ) {
		define( 'FAAONE_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
	}
	// Ensure the autoloader is available.
	if ( ! file_exists( FAAONE_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
		wp_die( esc_html_e( 'Plugin dependencies are missing. Please run composer install.', 'formular-af-awork-one' ) );
	}

	require_once FAAONE_PLUGIN_ROOT . 'vendor/autoload.php';
	// Load the ActDeact class.
	if ( ! class_exists( '\mzaworkdk\Aworkone\Backend\ActDeact' ) ) {
		require_once FAAONE_PLUGIN_ROOT . 'backend/class-actdeact.php';
	}

	\mzaworkdk\Aworkone\Backend\ActDeact::activate( $network_wide );
}

/**
 * Handle deactivation - use a separate function to avoid class dependency issues
 *
 * @param bool $network_wide Network wide.
 */
function faaone_deactivate_plugin( $network_wide ): void {
	// Ensure the autoloader is available.
	if ( ! file_exists( FAAONE_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
		return;
	}
	require_once FAAONE_PLUGIN_ROOT . 'vendor/autoload.php';

	// Load the ActDeact class.
	if ( ! class_exists( '\mzaworkdk\Aworkone\Backend\ActDeact' ) ) {
		require_once FAAONE_PLUGIN_ROOT . 'backend/class-actdeact.php';
	}

	\mzaworkdk\Aworkone\Backend\ActDeact::deactivate( $network_wide );
}

// Register activation and deactivation hooks.
register_activation_hook( FAAONE_PLUGIN_ABSOLUTE, 'faaone_activate_plugin' );
register_deactivation_hook( FAAONE_PLUGIN_ABSOLUTE, 'faaone_deactivate_plugin' );
