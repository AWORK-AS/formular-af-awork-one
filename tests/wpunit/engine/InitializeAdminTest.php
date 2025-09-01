<?php

namespace Contact_Form_App\Tests\WPUnit;

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
		$classes[] = 'Contact_Form_App\Internals\PostTypes';
		$classes[] = 'Contact_Form_App\Internals\Shortcode';
		$classes[] = 'Contact_Form_App\Integrations\CMB';
		$classes[] = 'Contact_Form_App\Integrations\Cron';
		$classes[] = 'Contact_Form_App\Integrations\Template';
		$classes[] = 'Contact_Form_App\Integrations\Widgets\My_Recent_Posts_Widget';
		$classes[] = 'Contact_Form_App\Backend\ActDeact';
		$classes[] = 'Contact_Form_App\Backend\Enqueue';
		$classes[] = 'Contact_Form_App\Backend\ImpExp';
		$classes[] = 'Contact_Form_App\Backend\Notices';
		$classes[] = 'Contact_Form_App\Backend\Pointers';
		$classes[] = 'Contact_Form_App\Backend\Settings_Page';

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
		$classes[] = 'Contact_Form_App\Ajax\Ajax';
		$classes[] = 'Contact_Form_App\Ajax\Ajax_Admin';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

}
