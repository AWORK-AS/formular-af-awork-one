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

$opts  = faaone_get_settings();
$token = $opts[ FAAONE_TEXTDOMAIN . '_token' ] ?? false;

if ( $token ) :
	?>
		<div class="faaone-icon-box">
				<div class="faaone-icon faaone-connected">
						<svg class="svg-icon" width="70" height="70" viewBox="0 0 38.98 38.98">
								<circle cx="19.49" cy="19.49" r="18.99" fill="#00607a" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
								<circle cx="19.43" cy="19.55" r="11.93" fill="#f3f9ee" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
						</svg>
				</div>
				<div class="faaone-label faaone-connected"><?php esc_html_e( 'Connected', 'formular-af-awork-one' ); ?></div>
		</div>
		<?php else : ?>
		<div class="faaone-icon-box">
				<div class="faaone-icon faaone-not-connected">
						<svg class="svg-icon" width="70" height="70" viewBox="0 0 38.98 38.98">
								<circle cx="19.49" cy="19.49" r="18.99" fill="#a62b2b" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
								<circle cx="19.43" cy="19.55" r="11.93" fill="#f3f9ee" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
						</svg>
				</div>
				<div><?php esc_html_e( 'Not Connected', 'formular-af-awork-one' ); ?></div>
		</div>
			<?php
endif;
