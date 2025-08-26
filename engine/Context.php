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

namespace Contact_Form_App\Engine;

/**
 * Contact Form App Is Methods
 */
class Context {

	/**
	 * What type of request is this?
	 *
	 * @since 1.0.0
	 * @param  string $type admin, ajax, cron, cli, amp or frontend.
	 * @return bool
	 */
	public function request( string $type ) {
		switch ( $type ) {
			case 'backend':
				return is_admin();

			case 'ajax':
				return defined( 'DOING_AJAX' ) && DOING_AJAX;

			case 'installing_wp':
				return defined( 'WP_INSTALLING' ) && WP_INSTALLING;

			case 'rest':
				return defined( 'REST_REQUEST' ) && REST_REQUEST;

			case 'cron':
				return defined( 'DOING_CRON' ) && DOING_CRON;

			case 'frontend':
				return ! is_admin() && ! defined( 'DOING_CRON' ) && ! defined( 'DOING_AJAX' ) && ! defined( 'REST_REQUEST' );

			case 'cli':
				return defined( 'WP_CLI' ) && WP_CLI;

			case 'amp':
				return $this->is_amp();

			default:
				\_doing_it_wrong( __METHOD__, \esc_html( \sprintf( 'Unknown request type: %s', $type ) ), '1.0.0' );
				return false;
		}
	}

	/**
	 * Is AMP
	 *
	 * @return bool
	 */
	public function is_amp() {
		return \function_exists( 'is_amp_endpoint' ) && \is_amp_endpoint();
	}

	/**
	 * Whether given user is an administrator.
	 *
	 * @param \WP_User|null $user The given user.
	 * @return bool
	 */
	public static function is_user_admin( \WP_User $user = null ) {
		if ( \is_null( $user ) ) {
			$user = \wp_get_current_user();
		}

		if ( ! $user instanceof \WP_User ) {
			\_doing_it_wrong( __METHOD__, 'To check if the user is admin is required a WP_User object.', '1.0.0' );
			return false;
		}

		return \is_multisite() ? \user_can( $user, 'manage_network' ) : \user_can( $user, 'manage_options' );
	}
}