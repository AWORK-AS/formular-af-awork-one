<?php
/**
 * Instructions for the AWORK ONE Form Plugin
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

<div id="tabs-2" class="wrap">
	<div class="faaone-instructions">
		<div class="faaone-section">
			<h3><?php esc_html_e( 'Required Admin Settings', 'formular-af-awork-one' ); ?></h3>
			<p><?php esc_html_e( 'To use the AWORK ONE form plugin, you need to configure the following required settings:', 'formular-af-awork-one' ); ?></p>

			<ul>
				<li><strong><?php esc_html_e( 'Email', 'formular-af-awork-one' ); ?></strong> - <?php esc_html_e( 'Your AWORK ONE account email', 'formular-af-awork-one' ); ?></li>
				<li><strong><?php esc_html_e( 'Company CVR', 'formular-af-awork-one' ); ?></strong> - <?php esc_html_e( 'Your company\'s CVR number', 'formular-af-awork-one' ); ?></li>
				<li><strong><?php esc_html_e( 'AWORK ONE Client ID', 'formular-af-awork-one' ); ?></strong> - <?php esc_html_e( 'Your client ID in the AWORK ONE system', 'formular-af-awork-one' ); ?></li>
			</ul>

			<p>
			<?php
				printf(
					/* translators: %s is a link to the AWORK ONE dashboard */
					esc_html__( 'You can find the CVR and Client ID in your %s.', 'formular-af-awork-one' ),
					'<a href="https://aworkone.dk/" target="_blank">' . esc_html__( 'AWORK ONE dashboard', 'formular-af-awork-one' ) . '</a>'
				);
				?>
			</p>
		</div>

		<div class="faaone-section">
			<h3><?php esc_html_e( 'Optional hCaptcha Integration', 'formular-af-awork-one' ); ?></h3>
			<p><?php esc_html_e( 'To prevent spam submissions, you can integrate hCaptcha with your forms:', 'formular-af-awork-one' ); ?></p>

			<ul>
				<li><strong><?php esc_html_e( 'Site Key', 'formular-af-awork-one' ); ?></strong> - <?php esc_html_e( 'Your hCaptcha site key', 'formular-af-awork-one' ); ?></li>
				<li><strong><?php esc_html_e( 'Secret Key', 'formular-af-awork-one' ); ?></strong> - <?php esc_html_e( 'Your hCaptcha secret key', 'formular-af-awork-one' ); ?></li>
			</ul>

			<p>
			<?php
				printf(
					/* translators: %s is a link to the hCaptcha dashboard */
					esc_html__( 'You can get these keys from the %s after creating an account.', 'formular-af-awork-one' ),
					'<a href="https://www.hcaptcha.com/" target="_blank">' . esc_html__( 'hCaptcha dashboard', 'formular-af-awork-one' ) . '</a>'
				);
				?>
			</p>
		</div>

		<div class="faaone-section">
			<h3><?php esc_html_e( 'Adding Forms to Your Site', 'formular-af-awork-one' ); ?></h3>
			<p><?php esc_html_e( 'You can add the AWORK ONE form to your pages or posts using two methods:', 'formular-af-awork-one' ); ?></p>

			<h4><?php esc_html_e( '1. Gutenberg Block (Widget)', 'formular-af-awork-one' ); ?></h4>
			<p><?php esc_html_e( 'When editing a page or post:', 'formular-af-awork-one' ); ?></p>
			<ol>
				<li><?php esc_html_e( 'Click the "+" button to add a new block', 'formular-af-awork-one' ); ?></li>
				<li>
				<?php
					printf(
						/* translators: %s is a list of search keywords */
						esc_html__( 'Search for: %s', 'formular-af-awork-one' ),
						'<strong>' . esc_html__( 'aworkone, contacts, leads, or form', 'formular-af-awork-one' ) . '</strong>'
					);
					?>
				</li>
				<li><?php esc_html_e( 'Select the "Contact Form" block', 'formular-af-awork-one' ); ?></li>
				<li><?php esc_html_e( 'Customize the form as needed', 'formular-af-awork-one' ); ?></li>
			</ol>

			<h4><?php esc_html_e( '2. Shortcode', 'formular-af-awork-one' ); ?></h4>
			<p>
			<?php
				printf(
					/* translators: %s is the shortcode example */
					esc_html__( 'You can use the shortcode %s in any post, page, or widget area.', 'formular-af-awork-one' ),
					'<code>[faaone_aworkone_form]</code>'
				);
				?>
			</p>

			<p><strong><?php esc_html_e( 'Customization options:', 'formular-af-awork-one' ); ?></strong></p>
			<ul>
				<li><code>headline</code> - <?php esc_html_e( 'Form headline text (Default: "Get in Touch With Us")', 'formular-af-awork-one' ); ?></li>
				<li><code>color</code> - <?php esc_html_e( 'Headline text color (Default: "#001A56")', 'formular-af-awork-one' ); ?></li>
				<li><code>button_color</code> - <?php esc_html_e( 'Submit button color (Default: "#368F8B")', 'formular-af-awork-one' ); ?></li>
				<li><code>button_text_color</code> - <?php esc_html_e( 'Submit button text color (Default: "#ffffff")', 'formular-af-awork-one' ); ?></li>
			</ul>

			<p><strong><?php esc_html_e( 'Example with customization:', 'formular-af-awork-one' ); ?></strong></p>
			<pre>[faaone_aworkone_form
	headline="<?php esc_html_e( 'Get in Touch With Us', 'formular-af-awork-one' ); ?>"
	color="#001A56"
	button_color="#368F8B"
	button_text_color="#ffffff"
	]</pre>
		</div>
	</div>
</div>
