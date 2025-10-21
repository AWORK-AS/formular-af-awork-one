<?php
/**
 * Instructions for the AWORK One Form Plugin
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
			<h3><?php esc_html_e( 'Required Admin Settings', 'formularer-for-awork-one' ); ?></h3>
			<p><?php esc_html_e( 'To use the AWORK One form plugin, you need to configure the following required settings:', 'formularer-for-awork-one' ); ?></p>

			<ul>
				<li><strong><?php esc_html_e( 'Email', 'formularer-for-awork-one' ); ?></strong> - <?php esc_html_e( 'Your AWORK One account email', 'formularer-for-awork-one' ); ?></li>
				<li><strong><?php esc_html_e( 'Company CVR', 'formularer-for-awork-one' ); ?></strong> - <?php esc_html_e( 'Your company\'s CVR number', 'formularer-for-awork-one' ); ?></li>
				<li><strong><?php esc_html_e( 'AWORK One Client ID', 'formularer-for-awork-one' ); ?></strong> - <?php esc_html_e( 'Your client ID in the AWORK One system', 'formularer-for-awork-one' ); ?></li>
			</ul>

			<p>
			<?php
				printf(
					/* translators: %s is a link to the AWORK One dashboard */
					esc_html__( 'You can find the CVR and Client ID in your %s.', 'formularer-for-awork-one' ),
					'<a href="https://aworkone.dk/" target="_blank">' . esc_html__( 'AWORK One dashboard', 'formularer-for-awork-one' ) . '</a>'
				);
				?>
			</p>
		</div>

		<div class="faaone-section">
			<h3><?php esc_html_e( 'Optional hCaptcha Integration', 'formularer-for-awork-one' ); ?></h3>
			<p><?php esc_html_e( 'To prevent spam submissions, you can integrate hCaptcha with your forms:', 'formularer-for-awork-one' ); ?></p>

			<ul>
				<li><strong><?php esc_html_e( 'Site Key', 'formularer-for-awork-one' ); ?></strong> - <?php esc_html_e( 'Your hCaptcha site key', 'formularer-for-awork-one' ); ?></li>
				<li><strong><?php esc_html_e( 'Secret Key', 'formularer-for-awork-one' ); ?></strong> - <?php esc_html_e( 'Your hCaptcha secret key', 'formularer-for-awork-one' ); ?></li>
			</ul>

			<p>
			<?php
				printf(
					/* translators: %s is a link to the hCaptcha dashboard */
					esc_html__( 'You can get these keys from the %s after creating an account.', 'formularer-for-awork-one' ),
					'<a href="https://www.hcaptcha.com/" target="_blank">' . esc_html__( 'hCaptcha dashboard', 'formularer-for-awork-one' ) . '</a>'
				);
				?>
			</p>
		</div>

		<div class="faaone-section">
			<h3><?php esc_html_e( 'Adding Forms to Your Site', 'formularer-for-awork-one' ); ?></h3>
			<p><?php esc_html_e( 'You can add the AWORK One form to your pages or posts using two methods:', 'formularer-for-awork-one' ); ?></p>

			<h4><?php esc_html_e( '1. Gutenberg Block (Widget)', 'formularer-for-awork-one' ); ?></h4>
			<p><?php esc_html_e( 'When editing a page or post:', 'formularer-for-awork-one' ); ?></p>
			<ol>
				<li><?php esc_html_e( 'Click the "+" button to add a new block', 'formularer-for-awork-one' ); ?></li>
				<li>
				<?php
					printf(
						/* translators: %s is a list of search keywords */
						esc_html__( 'Search for: %s', 'formularer-for-awork-one' ),
						'<strong>' . esc_html__( 'aworkone, contacts, leads, or form', 'formularer-for-awork-one' ) . '</strong>'
					);
					?>
				</li>
				<li><?php esc_html_e( 'Select the "Contact Form" block', 'formularer-for-awork-one' ); ?></li>
				<li><?php esc_html_e( 'Customize the form as needed', 'formularer-for-awork-one' ); ?></li>
			</ol>

			<h4><?php esc_html_e( '2. Shortcode', 'formularer-for-awork-one' ); ?></h4>
			<p>
			<?php
				printf(
					/* translators: %s is the shortcode example */
					esc_html__( 'You can use the shortcode %s in any post, page, or widget area.', 'formularer-for-awork-one' ),
					'<code>[faaone_aworkone_form]</code>'
				);
				?>
			</p>

			<p><strong><?php esc_html_e( 'Customization options:', 'formularer-for-awork-one' ); ?></strong></p>
			<ul>
				<li><code>headline</code> - <?php esc_html_e( 'Form headline text (Default: "Get in Touch With Us")', 'formularer-for-awork-one' ); ?></li>
				<li><code>color</code> - <?php esc_html_e( 'Headline text color (Default: "#001A56")', 'formularer-for-awork-one' ); ?></li>
				<li><code>button_color</code> - <?php esc_html_e( 'Submit button color (Default: "#368F8B")', 'formularer-for-awork-one' ); ?></li>
				<li><code>button_text_color</code> - <?php esc_html_e( 'Submit button text color (Default: "#ffffff")', 'formularer-for-awork-one' ); ?></li>
			</ul>

			<p><strong><?php esc_html_e( 'Example with customization:', 'formularer-for-awork-one' ); ?></strong></p>
			<pre>[faaone_aworkone_form
	headline="<?php esc_html_e( 'Get in Touch With Us', 'formularer-for-awork-one' ); ?>"
	color="#001A56"
	button_color="#368F8B"
	button_text_color="#ffffff"
	]</pre>
		</div>
	</div>
</div>
