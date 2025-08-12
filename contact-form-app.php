<?php

/**
 * @package   Contact_Form_App
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 *
 * Plugin Name:     Formular af CitizenOne journalsystem
 * Plugin URI:      https://github.com/AWORK-AS/contact-form-app
 * Description:     Formular af CitizenOne journalsystem
 * Version:         1.0.0
 * Author:          mz@awork.dk
 * Author URI:      https://awork.dk
 * Text Domain:     contact-form-app
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.4
 * WordPress-Plugin-Boilerplate-Powered: v3.3.0
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'CFA_VERSION', '1.0.0' );
define( 'CFA_TEXTDOMAIN', 'contact-form-app' );
define( 'CFA_NAME', 'Formular af CitizenOne journalsystem' );
define( 'CFA_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'CFA_PLUGIN_ABSOLUTE', __FILE__ );
define( 'CFA_MIN_PHP_VERSION', '7.4' );
define( 'CFA_WP_VERSION', '5.3' );
define( 'CFA_PLUGIN_API_URL', 'https://citizenone.dk/api' );
define( 'CFA_PLUGIN_API_NAME', 'CitizenOne journalsystem' );

add_action(
	'init',
	static function () {
		load_plugin_textdomain( CFA_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	);


$contact_form_app_libraries = require CFA_PLUGIN_ROOT . 'vendor/autoload.php'; //phpcs:ignore

require_once CFA_PLUGIN_ROOT . 'functions/functions.php';
require_once CFA_PLUGIN_ROOT . 'functions/debug.php';

// Add your new plugin on the wiki: https://github.com/WPBP/WordPress-Plugin-Boilerplate-Powered/wiki/Plugin-made-with-this-Boilerplate

$requirements = new \Micropackage\Requirements\Requirements(
	'Contact Form App',
	array(
		'php'            => CFA_MIN_PHP_VERSION,
		'php_extensions' => array( 'mbstring' ),
		'wp'             => CFA_WP_VERSION,
		// 'plugins'            => array(
		// array( 'file' => 'hello-dolly/hello.php', 'name' => 'Hello Dolly', 'version' => '1.5' )
		// ),
	)
);

if ( ! $requirements->satisfied() ) {
	$requirements->print_notice();

	return;
}



// Documentation to integrate GitHub, GitLab or BitBucket https://github.com/YahnisElsts/plugin-update-checker/blob/master/README.md
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

PucFactory::buildUpdateChecker( 'https://github.com/AWORK-AS/contact-form-app', __FILE__, 'contact-form-app' );

if ( ! wp_installing() ) {
	register_activation_hook( CFA_TEXTDOMAIN . '/' . CFA_TEXTDOMAIN . '.php', array( new \Contact_Form_App\Backend\ActDeact, 'activate' ) );
	register_deactivation_hook( CFA_TEXTDOMAIN . '/' . CFA_TEXTDOMAIN . '.php', array( new \Contact_Form_App\Backend\ActDeact, 'deactivate' ) );
	add_action(
		'plugins_loaded',
		static function () use ( $contact_form_app_libraries ) {
			new \Contact_Form_App\Engine\Initialize( $contact_form_app_libraries );
		}
	);
}
