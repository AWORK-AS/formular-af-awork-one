<?php
/**
 * Contact form for AWORK One
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://github.com/mz-aworkdk
 *
 * Plugin Name:     Formularer for AWORK One
 * Plugin URI:      https://github.com/AWORK-AS/formularer-for-awork-one
 * Description:     Formularer for AWORK One
 * Version:         1.0.1
 * Author:          support@aworkone.dk
 * Author URI:      https://aworkone.dk/kontakt-os/
 * Text Domain:     formularer-for-awork-one
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
define( 'FAAONE_TEXTDOMAIN', 'formularer-for-awork-one' );
define( 'FAAONE_VERSION', '1.0.1' );
define( 'FAAONE_MIN_PHP_VERSION', '7.4' );
define( 'FAAONE_WP_VERSION', '5.8' );
define( 'FAAONE_PLUGIN_API_URL', 'https://server6611.aworkinsight.dk/api' );
define( 'FAAONE_PLUGIN_API_NAME', 'Formularer for AWORK One' );
define( 'FAAONE_NAME', 'Formularer for AWORK One' );

/**
 * Load the Composer autoloader from the build directory.
 * This makes all our classes and scoped dependencies available globally
 * as soon as the plugin file is loaded.
 */
$autoloader_path = FAAONE_PLUGIN_ROOT . 'vendor/autoload.php';
if ( ! file_exists( $autoloader_path ) ) {
	// Add a more user-friendly admin notice if possible.
	if ( is_admin() ) {
		add_action(
			'admin_notices',
			function () {
				echo '<div class="error"><p>';
				esc_html_e( 'Formularer for AWORK One is not built correctly. Please run the build script and reactivate the plugin.', 'formularer-for-awork-one' );
				echo '</p></div>';
			}
		);
	}
	// Stop execution if the autoloader is missing.
	return;
}
require_once FAAONE_PLUGIN_ROOT . 'vendor/autoload.php';

/**
 * The main function that initializes the plugin.
 *
 * This function is hooked to 'init' to ensure all WordPress functionalities,
 * including user data and translations, are ready.
 */
function faaone_initialize_plugin(): void {
	$faaone_libraries = require FAAONE_PLUGIN_ROOT . 'vendor/autoload.php';
	// Require necessary files.
	require_once FAAONE_PLUGIN_ROOT . 'functions/functions.php';
	require_once FAAONE_PLUGIN_ROOT . 'functions/debug.php';
	// Check for requirements.
	$requirements = new \mzaworkdk\Aworkone\Dependencies\Micropackage\Requirements\Requirements(
		__( 'Formularer for AWORK One', 'formularer-for-awork-one' ),
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
	\mzaworkdk\Aworkone\Backend\ActDeact::activate( $network_wide );
}

/**
 * Handle deactivation - use a separate function to avoid class dependency issues
 *
 * @param bool $network_wide Network wide.
 */
function faaone_deactivate_plugin( $network_wide ): void {
	\mzaworkdk\Aworkone\Backend\ActDeact::deactivate( $network_wide );
}

// Register activation and deactivation hooks.
register_activation_hook( FAAONE_PLUGIN_ABSOLUTE, 'faaone_activate_plugin' );
register_deactivation_hook( FAAONE_PLUGIN_ABSOLUTE, 'faaone_deactivate_plugin' );
