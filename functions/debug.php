<?php

/**
 * Formular af CitizenOne journalsystem
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Log text inside the debugging plugins.
 *
 * @param string $text The text.
 * @return void
 */
function facioj_log( string $text ) {
	$facioj_debug = new WPBP_Debug( __( 'Contact Form App', 'formular-af-citizenone-journalsystem' ) );
	$facioj_debug->log( $text );
}
