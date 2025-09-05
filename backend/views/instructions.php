<?php
/**
 * Instructions for the CitizenOne Form Plugin
 *
 * @package   mzaworkdk\Citizenone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div id="tabs-2" class="wrap">
    <div class="facioj-instructions">
        <div class="facioj-section">
            <h3><?php esc_html_e( 'Required Admin Settings', 'formular-af-citizenone-journalsystem' ); ?></h3>
            <p><?php esc_html_e( 'To use the CitizenOne form plugin, you need to configure the following required settings:', 'formular-af-citizenone-journalsystem' ); ?></p>
            
            <ul>
                <li><strong><?php esc_html_e( 'Email', 'formular-af-citizenone-journalsystem' ); ?></strong> - <?php esc_html_e( 'Your CitizenOne account email', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><strong><?php esc_html_e( 'Company CVR', 'formular-af-citizenone-journalsystem' ); ?></strong> - <?php esc_html_e( 'Your company\'s CVR number', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><strong><?php esc_html_e( 'CitizenOne Company ID', 'formular-af-citizenone-journalsystem' ); ?></strong> - <?php esc_html_e( 'Your company ID in the CitizenOne system', 'formular-af-citizenone-journalsystem' ); ?></li>
            </ul>
            
            <p><?php 
                printf(
                    /* translators: %s is a link to the CitizenOne dashboard */
                    esc_html__( 'You can find the CVR and Company ID in your %s.', 'formular-af-citizenone-journalsystem' ),
                    '<a href="https://citizenone.dk/" target="_blank">' . esc_html__( 'CitizenOne dashboard', 'formular-af-citizenone-journalsystem' ) . '</a>'
                );
            ?></p>
        </div>
        
        <div class="facioj-section">
            <h3><?php esc_html_e( 'Optional hCaptcha Integration', 'formular-af-citizenone-journalsystem' ); ?></h3>
            <p><?php esc_html_e( 'To prevent spam submissions, you can integrate hCaptcha with your forms:', 'formular-af-citizenone-journalsystem' ); ?></p>
            
            <ul>
                <li><strong><?php esc_html_e( 'Site Key', 'formular-af-citizenone-journalsystem' ); ?></strong> - <?php esc_html_e( 'Your hCaptcha site key', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><strong><?php esc_html_e( 'Secret Key', 'formular-af-citizenone-journalsystem' ); ?></strong> - <?php esc_html_e( 'Your hCaptcha secret key', 'formular-af-citizenone-journalsystem' ); ?></li>
            </ul>
            
            <p><?php 
                printf(
                    /* translators: %s is a link to the hCaptcha dashboard */
                    esc_html__( 'You can get these keys from the %s after creating an account.', 'formular-af-citizenone-journalsystem' ),
                    '<a href="https://www.hcaptcha.com/" target="_blank">' . esc_html__( 'hCaptcha dashboard', 'formular-af-citizenone-journalsystem' ) . '</a>'
                );
            ?></p>
        </div>
        
        <div class="facioj-section">
            <h3><?php esc_html_e( 'Adding Forms to Your Site', 'formular-af-citizenone-journalsystem' ); ?></h3>
            <p><?php esc_html_e( 'You can add the CitizenOne form to your pages or posts using two methods:', 'formular-af-citizenone-journalsystem' ); ?></p>
            
            <h4><?php esc_html_e( '1. Gutenberg Block (Widget)', 'formular-af-citizenone-journalsystem' ); ?></h4>
            <p><?php esc_html_e( 'When editing a page or post:', 'formular-af-citizenone-journalsystem' ); ?></p>
            <ol>
                <li><?php esc_html_e( 'Click the "+" button to add a new block', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><?php 
                    printf(
                        /* translators: %s is a list of search keywords */
                        esc_html__( 'Search for: %s', 'formular-af-citizenone-journalsystem' ),
                        '<strong>' . esc_html__( 'citizenone, contacts, leads, or form', 'formular-af-citizenone-journalsystem' ) . '</strong>'
                    );
                ?></li>
                <li><?php esc_html_e( 'Select the "Contact Form" block', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><?php esc_html_e( 'Customize the form as needed', 'formular-af-citizenone-journalsystem' ); ?></li>
            </ol>
            
            <h4><?php esc_html_e( '2. Shortcode', 'formular-af-citizenone-journalsystem' ); ?></h4>
            <p><?php 
                printf(
                    /* translators: %s is the shortcode example */
                    esc_html__( 'You can use the shortcode %s in any post, page, or widget area.', 'formular-af-citizenone-journalsystem' ),
                    '<code>[facioj_citizenone_form]</code>'
                );
            ?></p>
            
            <p><strong><?php esc_html_e( 'Customization options:', 'formular-af-citizenone-journalsystem' ); ?></strong></p>
            <ul>
                <li><code>headline</code> - <?php esc_html_e( 'Form headline text (Default: "Get in Touch With Us")', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><code>color</code> - <?php esc_html_e( 'Headline text color (Default: "#205E77")', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><code>button_color</code> - <?php esc_html_e( 'Submit button color (Default: "#42aed9")', 'formular-af-citizenone-journalsystem' ); ?></li>
                <li><code>button_text_color</code> - <?php esc_html_e( 'Submit button text color (Default: "#ffffff")', 'formular-af-citizenone-journalsystem' ); ?></li>
            </ul>
            
            <p><strong><?php esc_html_e( 'Example with customization:', 'formular-af-citizenone-journalsystem' ); ?></strong></p>
            <pre>[facioj_citizenone_form
    headline="<?php esc_html_e( 'Get in Touch With Us', 'formular-af-citizenone-journalsystem' ); ?>"
    color="#205E77"
    button_color="#42aed9"
    button_text_color="#ffffff"
    ]</pre>
        </div>
    </div>
</div>