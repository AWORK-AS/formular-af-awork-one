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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function faaone_get_settings() {
	return apply_filters( 'faaone_get_settings', get_option( FAAONE_TEXTDOMAIN . '-settings' ) );
}
