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

namespace mzaworkdk\Aworkone\Integrations;

use mzaworkdk\Aworkone\Engine\Base;

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

		if ( ! defined( 'FAAONE_PLUGIN_ROOT' ) ) {
			define( 'FAAONE_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) . '../' );
		}

		require_once FAAONE_PLUGIN_ROOT . 'vendor/cmb2/init.php';
		require_once FAAONE_PLUGIN_ROOT . 'vendor/cmb2-grid/Cmb2GridPluginLoad.php';
	}
}
