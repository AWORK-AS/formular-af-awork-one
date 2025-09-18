<?php

namespace mzaworkdk\Aworkone\Tests\WPUnit;

class InitializeAdminTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp(): void {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $user_id );
		set_current_screen( 'edit.php' );
	}

	public function tearDown(): void {
		parent::tearDown();
	}

	/**
	 * @test
	 * it should be admin
	 */
	public function it_should_be_admin() {
		add_filter( 'wp_doing_ajax', '__return_false' );
		do_action('plugins_loaded');

		$classes   = array();
		$classes[] = 'mzaworkdk\Aworkone\Internals\PostTypes';
		$classes[] = 'mzaworkdk\Aworkone\Internals\Shortcode';
		$classes[] = 'mzaworkdk\Aworkone\Integrations\CMB';
		$classes[] = 'mzaworkdk\Aworkone\Integrations\Cron';
		$classes[] = 'mzaworkdk\Aworkone\Integrations\Template';
		$classes[] = 'mzaworkdk\Aworkone\Integrations\Widgets\My_Recent_Posts_Widget';
		$classes[] = 'mzaworkdk\Aworkone\Backend\ActDeact';
		$classes[] = 'mzaworkdk\Aworkone\Backend\Enqueue';
		$classes[] = 'mzaworkdk\Aworkone\Backend\ImpExp';
		$classes[] = 'mzaworkdk\Aworkone\Backend\Notices';
		$classes[] = 'mzaworkdk\Aworkone\Backend\Pointers';
		$classes[] = 'mzaworkdk\Aworkone\Backend\Settings_Page';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

	/**
	 * @test
	 * it should be ajax
	 */
	public function it_should_be_admin_ajax() {
		add_filter( 'wp_doing_ajax', '__return_true' );
		do_action('plugins_loaded');

		$classes   = array();
		$classes[] = 'mzaworkdk\Aworkone\Ajax\Ajax';
		$classes[] = 'mzaworkdk\Aworkone\Ajax\Ajax_Admin';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

}
