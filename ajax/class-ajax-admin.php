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

namespace mzaworkdk\Citizenone\Ajax;

use mzaworkdk\Citizenone\Engine\Base;

/**
 * AJAX as logged user
 */
class Ajax_Admin extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( ! \apply_filters( 'facioj_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged user.
		\add_action( 'wp_ajax_facioj_your_admin_method', array( $this, 'facioj_your_admin_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function facioj_your_admin_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 2,
		);

		\wp_send_json_success( $return );
	}
}
