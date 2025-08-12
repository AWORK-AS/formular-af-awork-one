<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Formular_af_CitizenOne
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<div id="tabs" class="settings-tab">
		<ul>
			<li><a href="#tabs-1"><?php esc_html_e( 'Configuration', 'contact-form-app' ); ?></a></li>
		</ul>
		<?php
		    require_once plugin_dir_path( __FILE__ ) . 'contact-form-app-settings.php';
		
		?>
		
	</div>

	<div class="right-column-settings-page metabox-holder">
		<div class="postbox">
			<h3 class="hndle"><span><?php esc_html_e( 'Formular af CitizenOne journalsystem', 'contact-form-app' ); ?></span></h3>
		</div>
	</div>
</div>