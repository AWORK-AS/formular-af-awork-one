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
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$cfa_debug = new WPBP_Debug( __( 'Contact Form App', 'formular-af-citizenone-journalsystem' ) );

/**
 * Log text inside the debugging plugins.
 *
 * @param string $text The text.
 * @return void
 */
function cfa_log( string $text ) {
	global $cfa_debug;
	$cfa_debug->log( $text );
}
