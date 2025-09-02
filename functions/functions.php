<?php
/**
 * mzaworkdk\CitizenOne
 *
 * @package   mzaworkdk\CitizenOne
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function facioj_get_settings() {
	return apply_filters( 'facioj_get_settings', get_option( FACIOJ_TEXTDOMAIN . '-settings' ) );
}
