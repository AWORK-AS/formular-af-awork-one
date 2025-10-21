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
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#001A56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.72"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.72-1.72"/></svg>
				</div>
				<div class="faaone-label faaone-connected"><?php esc_html_e( 'Connected', 'formularer-for-awork-one' ); ?></div>
		</div>
		<?php else : ?>
		<div class="faaone-icon-box">
				<div class="faaone-icon faaone-not-connected">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#A0A0A0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.72"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.72-1.72"/><line x1="8" y1="8" x2="16" y2="16"/></svg>
				</div>
				<div><?php esc_html_e( 'Not Connected', 'formularer-for-awork-one' ); ?></div>
		</div>
			<?php
endif;
