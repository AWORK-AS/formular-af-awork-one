<?php

namespace Contact_Form_App\Tests\WPUnit;
use Inpsyde\WpContext;

class InitializeTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp(): void {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

		wp_set_current_user(0);
		wp_logout();
		wp_safe_redirect(wp_login_url());
	}

	public function tearDown(): void {
		parent::tearDown();
	}

	/**
	 * @test
	 * it should be front
	 */
	public function it_should_be_front() {
		do_action('plugins_loaded');

		$classes   = array();
		$classes[] = 'Contact_Form_App\Internals\PostTypes';
		$classes[] = 'Contact_Form_App\Internals\Shortcode';
		$classes[] = 'Contact_Form_App\Internals\Transient';
		$classes[] = 'Contact_Form_App\Integrations\CMB';
		$classes[] = 'Contact_Form_App\Integrations\Cron';
		$classes[] = 'Contact_Form_App\Integrations\Template';
		$classes[] = 'Contact_Form_App\Integrations\Widgets\My_Recent_Posts_Widget';
		$classes[] = 'Contact_Form_App\Frontend\Enqueue';
		$classes[] = 'Contact_Form_App\Frontend\Extras\Body_Class';

		$all_classes = get_declared_classes();
		foreach( $classes as $class ) {
			$this->assertTrue( in_array( $class, $all_classes ) );
		}
	}

	/**
	 * @test
	 * it should be ajax
	 */
	public function it_should_be_ajax() {
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
