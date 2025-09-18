<?php
/**
 * Formular af CitizenOne journalsystem
 *
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Loop for uninstall
 *
 * @return void
 */
function facioj_uninstall_multisite() {
	if ( is_multisite() ) {
		$blogs = get_sites();

		if ( ! empty( $blogs ) ) {
			foreach ( $blogs as $blog ) {
				switch_to_blog( (int) $blog->blog_id );
				facioj_uninstall();
				restore_current_blog();
			}

			return;
		}
	}

	facioj_uninstall();
}

/**
 * What happen on uninstall?
 *
 * @global WP_Roles $wp_roles
 * @return void
 */
function facioj_uninstall() { // phpcs:ignore
	global $wp_roles;

	// Remove the capabilities of the plugin.
	if ( ! isset( $wp_roles ) ) {
		$wp_roles = new WP_Roles; // phpcs:ignore
	}

	$caps = array(
		'create_plugins',
		'read_demo',
		'read_private_demoes',
		'edit_demo',
		'edit_demoes',
		'edit_private_demoes',
		'edit_published_demoes',
		'edit_others_demoes',
		'publish_demoes',
		'delete_demo',
		'delete_demoes',
		'delete_private_demoes',
		'delete_published_demoes',
		'delete_others_demoes',
		'manage_demoes',
	);

	foreach ( $wp_roles as $role ) {
		foreach ( $caps as $cap ) {
			$role->remove_cap( $cap );
		}
	}
}

facioj_uninstall_multisite();
