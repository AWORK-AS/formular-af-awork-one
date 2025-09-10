<?php
/**
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://github.com/mz-aworkdk
 *
 * Plugin Name:     Formular af CitizenOne journalsystem
 * Plugin URI:      https://github.com/AWORK-AS/contact-form-app
 * Description:     Formular af CitizenOne journalsystem
 * Version:         1.1.1
 * Author:          support@citizenone.dk
 * Author URI:      https://github.com/mz-aworkdk
 * Text Domain:     formular-af-citizenone-journalsystem
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
define( 'FACIOJ_PLUGIN_ABSOLUTE', __FILE__ );
define( 'FACIOJ_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'FACIOJ_TEXTDOMAIN', 'formular-af-citizenone-journalsystem' );
define( 'FACIOJ_VERSION', '1.1.1' );
define( 'FACIOJ_MIN_PHP_VERSION', '7.4' );
define( 'FACIOJ_WP_VERSION', '5.8' );
define( 'FACIOJ_PLUGIN_API_URL', 'https://appserver.citizenone.dk/api' );
define( 'FACIOJ_PLUGIN_API_NAME', 'CitizenOne journalsystem' );
define( 'FACIOJ_NAME', 'Formular af CitizenOne journalsystem' );
/**
 * The main function that initializes the plugin.
 *
 * This function is hooked to 'init' to ensure all WordPress functionalities,
 * including user data and translations, are ready.
 */
function facioj_initialize_plugin() {
	// Require necessary files.
	$facioj_libraries = require FACIOJ_PLUGIN_ROOT . 'vendor/autoload.php';
	require_once FACIOJ_PLUGIN_ROOT . 'functions/functions.php';
	require_once FACIOJ_PLUGIN_ROOT . 'functions/debug.php';

    

	// Check for requirements.
	$requirements = new \Micropackage\Requirements\Requirements(
		__( 'Formular af CitizenOne journalsystem', 'formular-af-citizenone-journalsystem' ),
		array(
			'php'            => FACIOJ_MIN_PHP_VERSION,
			'php_extensions' => array( 'mbstring' ),
			'wp'             => FACIOJ_WP_VERSION,
		)
	);

	if ( ! $requirements->satisfied() ) {
		add_action( 'admin_notices', array( $requirements, 'print_notice' ) );

		return;
	}

	// Set up the update checker.
	$myUpdateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/AWORK-AS/contact-form-app',
		FACIOJ_PLUGIN_ABSOLUTE,
		FACIOJ_TEXTDOMAIN
	);
	$myUpdateChecker->setBranch( 'main' );
    
	
	
	// Initialize the plugin's core engine.
	new \mzaworkdk\Citizenone\Engine\Initialize( $facioj_libraries );
	
    // Load Contact form block.
	add_action(
        'enqueue_block_assets',
        function() {
		// Only load on frontend
			if ( is_admin() ) {
				return;
			}
		}
        );
	
	// Use block.json for block registration
	$block_json_path = FACIOJ_PLUGIN_ROOT . 'assets/block.json';

	if ( !file_exists( $block_json_path ) ) {
		return;
	}

	register_block_type( $block_json_path );
}

// Hook the initializer function to 'init'.
add_action( 'init', 'facioj_initialize_plugin' );



/**
 * Register activation and deactivation hooks.
 * These hooks are safe to be registered globally as they only create a hook,
 * they don't execute the class methods immediately.
 */

/**
 * Handle activation - use a separate function to avoid class dependency issues
 */
function facioj_activate_plugin( $network_wide ) {
	// Double-check if constant is defined
    if ( ! defined( 'FACIOJ_PLUGIN_ROOT' ) ) {
        define( 'FACIOJ_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
    }
	
    // Ensure the autoloader is available
    if ( ! file_exists( FACIOJ_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
        wp_die( esc_html_e( 'Plugin dependencies are missing. Please run composer install.', 'formular-af-citizenone-journalsystem' ) );
    }
    
    require_once FACIOJ_PLUGIN_ROOT . 'vendor/autoload.php';
    
    // Load the ActDeact class
    if ( ! class_exists( '\mzaworkdk\Citizenone\Backend\ActDeact' ) ) {
        require_once FACIOJ_PLUGIN_ROOT . 'backend/ActDeact.php';
    }
    
    \mzaworkdk\Citizenone\Backend\ActDeact::activate( $network_wide );
}

/**
 * Handle deactivation - use a separate function to avoid class dependency issues
 */
function facioj_deactivate_plugin( $network_wide ) {
    // Ensure the autoloader is available
    if ( ! file_exists( FACIOJ_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
        return;
    }
    
    require_once FACIOJ_PLUGIN_ROOT . 'vendor/autoload.php';
    
    // Load the ActDeact class
    if ( ! class_exists( '\mzaworkdk\Citizenone\Backend\ActDeact' ) ) {
        require_once FACIOJ_PLUGIN_ROOT . 'backend/ActDeact.php';
    }
    
    \mzaworkdk\Citizenone\Backend\ActDeact::deactivate( $network_wide );
}

// Register activation and deactivation hooks
register_activation_hook( FACIOJ_PLUGIN_ABSOLUTE, 'facioj_activate_plugin' );
register_deactivation_hook( FACIOJ_PLUGIN_ABSOLUTE, 'facioj_deactivate_plugin' );
