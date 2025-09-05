<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$opts  = facioj_get_settings();
$token = $opts[FACIOJ_TEXTDOMAIN . '_token'] ?? false;

if ( $token ) :
	?>
    <div class="facioj-icon-box">
        <div class="facioj-icon facioj-connected">
            <svg class="svg-icon" width="70" height="70" viewBox="0 0 38.98 38.98">
                <circle cx="19.49" cy="19.49" r="18.99" fill="#00607a" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
                <circle cx="19.43" cy="19.55" r="11.93" fill="#f3f9ee" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
            </svg>
        </div>
        <div class="facioj-label facioj-connected"><?php esc_html_e( 'Connected', 'formular-af-citizenone-journalsystem' ); ?></div>
    </div>
<?php else : ?>
    <div class="facioj-icon-box">
        <div class="facioj-icon facioj-not-connected">
            <svg class="svg-icon" width="70" height="70" viewBox="0 0 38.98 38.98">
                <circle cx="19.49" cy="19.49" r="18.99" fill="#a62b2b" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
                <circle cx="19.43" cy="19.55" r="11.93" fill="#f3f9ee" stroke="#f3f9ee" stroke-width="1" opacity="0.9"></circle>
            </svg>
        </div>
        <div><?php esc_html_e( 'Not Connected', 'formular-af-citizenone-journalsystem' ); ?></div>
    </div>
	<?php
endif;
