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

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 * @return array
 */
function cfa_get_settings() {
	return apply_filters( 'cfa_get_settings', get_option( CFA_TEXTDOMAIN . '-settings' ) );
}
