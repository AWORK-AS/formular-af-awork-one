<?php

namespace mzaworkdk\CitizenOne\Tests\WPUnit;

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
		$classes[] = 'mzaworkdk\CitizenOne\Internals\PostTypes';
		$classes[] = 'mzaworkdk\CitizenOne\Internals\Shortcode';
		$classes[] = 'mzaworkdk\CitizenOne\Integrations\CMB';
		$classes[] = 'mzaworkdk\CitizenOne\Integrations\Cron';
		$classes[] = 'mzaworkdk\CitizenOne\Integrations\Template';
		$classes[] = 'mzaworkdk\CitizenOne\Integrations\Widgets\My_Recent_Posts_Widget';
		$classes[] = 'mzaworkdk\CitizenOne\Backend\ActDeact';
		$classes[] = 'mzaworkdk\CitizenOne\Backend\Enqueue';
		$classes[] = 'mzaworkdk\CitizenOne\Backend\ImpExp';
		$classes[] = 'mzaworkdk\CitizenOne\Backend\Notices';
		$classes[] = 'mzaworkdk\CitizenOne\Backend\Pointers';
		$classes[] = 'mzaworkdk\CitizenOne\Backend\Settings_Page';

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
		$classes[] = 'mzaworkdk\CitizenOne\Ajax\Ajax';
		$classes[] = 'mzaworkdk\CitizenOne\Ajax\Ajax_Admin';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

}
