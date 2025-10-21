<?php
/**
 * Formularer for AWORK One
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Log text inside the debugging plugins.
 *
 * @param string $text The text.
 * @return void
 */
function faaone_log( string $text ) {
	$faaone_debug = new WPBP_Debug( __( 'Contact Form App', 'formularer-for-awork-one' ) );
	$faaone_debug->log( $text );
}
