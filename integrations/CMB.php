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

namespace mzaworkdk\CitizenOne\Integrations;

use mzaworkdk\CitizenOne\Engine\Base;

/**
 * All the CMB related code.
 */
class CMB extends Base {

	/**
	 * Initialize class.
	 *
	 * @since 1.0.0
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		require_once FACIOJ_PLUGIN_ROOT . 'vendor/cmb2/init.php';
		require_once FACIOJ_PLUGIN_ROOT . 'vendor/cmb2-grid/Cmb2GridPluginLoad.php';
	}

}
