<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Contact_Form_App
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

$opts  = cfa_get_settings();
$token = $opts[CFA_TEXTDOMAIN . '_token'] ?? false;

if ( $token ) :
	?>
    <div class="cfa-icon-box">
        <div class="cfa-icon cfa-connected">
            <svg width="60" height="60" viewBox="0 0 100 100">
                <rect x="20" y="35" width="60" height="30" rx="15" fill="currentColor" opacity="0.2"></rect>
                <circle cx="30" cy="50" r="10" fill="currentColor"></circle>
                <circle cx="70" cy="50" r="10" fill="currentColor"></circle>
                <path d="M40,50 L60,50" stroke="white" stroke-width="4" stroke-linecap="round"></path>
            </svg>
        </div>
        <div class="cfa-label cfa-connected"><?php esc_html_e( 'Connected', 'contact-form-app' ); ?></div>
    </div>
<?php else : ?>
    <div class="cfa-icon-box">
        <div class="cfa-icon cfa-not-connected">
            <svg width="60" height="60" viewBox="0 0 100 100">
                <rect x="20" y="35" width="60" height="30" rx="15" fill="currentColor" opacity="0.2"></rect>
                <circle cx="30" cy="50" r="10" fill="currentColor"></circle>
                <circle cx="70" cy="50" r="10" fill="currentColor"></circle>
                <path d="M40,40 L60,60 M60,40 L40,60" stroke="white" stroke-width="4" stroke-linecap="round"></path>
            </svg>
        </div>
        <div><?php esc_html_e( 'Not Connected', 'contact-form-app' ); ?></div>
    </div>
	<?php
endif;
