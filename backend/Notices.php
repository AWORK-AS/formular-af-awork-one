<?php
/**
 * mzaworkdk\Citizenone
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Citizenone\Backend;

use mzaworkdk\Citizenone\Engine\Base;
use I18n_Notice_WordPressOrg;

/**
 * Everything that involves notification on the WordPress dashboard
 */
class Notices extends Base {

	/**
	 * Initialize the class
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		/*
		 * Alert after few days to suggest to contribute to the localization if it is incomplete
		 * on translate.wordpress.org, the filter enables to remove globally.
		 */
		if ( !\apply_filters( 'facioj_alert_localization', true ) ) {
			return;
		}

		new I18n_Notice_WordPressOrg(
		array(
			'textdomain'       => FACIOJ_TEXTDOMAIN,
			'facioj' => FACIOJ_NAME,
			'hook'             => 'admin_notices',
		),
		true
		);
	}

}