<?php
/**
 * @package   Contact_Form_App
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://github.com/mz-aworkdk
 *
 * Plugin Name:     Formular af CitizenOne journalsystem
 * Plugin URI:      https://github.com/AWORK-AS/contact-form-app
 * Description:     Formular af CitizenOne journalsystem
 * Version:         1.0.0
 * Author:          mz@awork.dk
 * Author URI:      https://github.com/mz-aworkdk
 * Text Domain:     contact-form-app
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
define( 'CFA_PLUGIN_ABSOLUTE', __FILE__ );
define( 'CFA_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'CFA_TEXTDOMAIN', 'contact-form-app' );
define( 'CFA_VERSION', '1.0.0-alpha' );
define( 'CFA_MIN_PHP_VERSION', '7.4' );
define( 'CFA_WP_VERSION', '5.8' );
define( 'CFA_PLUGIN_API_URL', 'https://server1488.citizenone.dk/api' );
define( 'CFA_PLUGIN_API_NAME', 'CitizenOne journalsystem' );
define( 'CFA_NAME', 'Formular af CitizenOne journalsystem' );
/**
 * The main function that initializes the plugin.
 *
 * This function is hooked to 'init' to ensure all WordPress functionalities,
 * including user data and translations, are ready.
 */
function cfa_initialize_plugin() {
	// Require necessary files.
	$contact_form_app_libraries = require CFA_PLUGIN_ROOT . 'vendor/autoload.php';
	require_once CFA_PLUGIN_ROOT . 'functions/functions.php';
	require_once CFA_PLUGIN_ROOT . 'functions/debug.php';

    

	// Check for requirements.
	$requirements = new \Micropackage\Requirements\Requirements(
		__( 'Contact Form App', 'contact-form-app' ),
		array(
			'php'            => CFA_MIN_PHP_VERSION,
			'php_extensions' => array( 'mbstring' ),
			'wp'             => CFA_WP_VERSION,
		)
	);

	if ( ! $requirements->satisfied() ) {
		add_action( 'admin_notices', array( $requirements, 'print_notice' ) );

		return;
	}

	// Set up the update checker.
	$myUpdateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/AWORK-AS/contact-form-app',
		CFA_PLUGIN_ABSOLUTE,
		CFA_TEXTDOMAIN
	);
	$myUpdateChecker->setBranch( 'main' );
    
	
	
	// Initialize the plugin's core engine.
	new \Contact_Form_App\Engine\Initialize( $contact_form_app_libraries );
	
	// Load Contact form block.
	add_action(
        'enqueue_block_assets',
        function() {
		// Only load on frontend
			if ( is_admin() ) {
				return;
			}

			// Localize script with WP REST API settings
			wp_localize_script(
			'contact-form-frontend',
			'wpApiSettings',
			array(
				'root'  => esc_url_raw( rest_url() ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
			)
				);
		
			// Load hCaptcha script if needed
			wp_enqueue_script(
				'hcaptcha',
				'https://js.hcaptcha.com/1/api.js',
				array(),
				CFA_VERSION,
				array( 'async' => true, 'defer' => true )
			);
		}
        );

	// Use block.json for block registration
	$block_json_path = CFA_PLUGIN_ROOT . 'assets/block.json';

	if ( !file_exists( $block_json_path ) ) {
		return;
	}

	register_block_type( $block_json_path );
}

// Hook the initializer function to 'init'.
add_action( 'init', 'cfa_initialize_plugin' );



/**
 * Register activation and deactivation hooks.
 * These hooks are safe to be registered globally as they only create a hook,
 * they don't execute the class methods immediately.
 */

/**
 * Handle activation - use a separate function to avoid class dependency issues
 */
function cfa_activate_plugin( $network_wide ) {
    // Ensure the autoloader is available
    if ( ! file_exists( CFA_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
        wp_die( esc_html_e( 'Plugin dependencies are missing. Please run composer install.', 'contact-form-app' ) );
    }
    
    require_once CFA_PLUGIN_ROOT . 'vendor/autoload.php';
    
    // Load the ActDeact class
    if ( ! class_exists( '\Contact_Form_App\Backend\ActDeact' ) ) {
        require_once CFA_PLUGIN_ROOT . 'backend/ActDeact.php';
    }
    
    \Contact_Form_App\Backend\ActDeact::activate( $network_wide );
}

/**
 * Handle deactivation - use a separate function to avoid class dependency issues
 */
function cfa_deactivate_plugin( $network_wide ) {
    // Ensure the autoloader is available
    if ( ! file_exists( CFA_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
        return;
    }
    
    require_once CFA_PLUGIN_ROOT . 'vendor/autoload.php';
    
    // Load the ActDeact class
    if ( ! class_exists( '\Contact_Form_App\Backend\ActDeact' ) ) {
        require_once CFA_PLUGIN_ROOT . 'backend/ActDeact.php';
    }
    
    \Contact_Form_App\Backend\ActDeact::deactivate( $network_wide );
}

// Register activation and deactivation hooks
register_activation_hook( CFA_PLUGIN_ABSOLUTE, 'cfa_activate_plugin' );
register_deactivation_hook( CFA_PLUGIN_ABSOLUTE, 'cfa_deactivate_plugin' );
