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

namespace mzaworkdk\Aworkone\Frontend\Extras;

use mzaworkdk\Aworkone\Engine\Base;

/**
 * Add custom css class to <body>
 */
class Body_Class extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		parent::initialize();

		\add_filter( 'body_class', array( self::class, 'add_faaone_class' ), 10, 1 );
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 * @since 1.0.0
	 * @return array
	 */
	public static function add_faaone_class( array $classes ) {
		$classes[] = FAAONE_TEXTDOMAIN;

		return $classes;
	}
}
