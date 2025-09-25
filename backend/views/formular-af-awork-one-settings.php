<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div id="tabs-1" class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<?php
		settings_errors( 'faaone_messages' );
	?>
	<form action="options.php" method="post">
		<?php
		// Output security fields for the registered setting.
		settings_fields( FAAONE_TEXTDOMAIN . '_group' );

		// Output setting sections and their fields.
		do_settings_sections( FAAONE_TEXTDOMAIN );

		// Output save settings button.
		submit_button( __( 'Save Settings', 'formular-af-awork-one' ) );
		?>
	</form>
</div>
