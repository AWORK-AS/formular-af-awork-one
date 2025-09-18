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
<?php
	$cmb = new_cmb2_box(
		array(
			'id'         => FAAONE_TEXTDOMAIN . '_options',
			'hookup'     => false,
			'show_on'    => array(
				'key'   => 'options-page',
				'value' => array( FAAONE_TEXTDOMAIN ),
			),
			'show_names' => true,
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'Email', 'formular-af-awork-one' ),
			'id'         => FAAONE_TEXTDOMAIN . '_field_email',
			'type'       => 'text_email',
			'attributes' => array(
				'required' => 'required',
			),
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'Company CVR', 'formular-af-awork-one' ),
			'id'         => FAAONE_TEXTDOMAIN . '_field_company_cvr',
			'type'       => 'text',
			'attributes' => array(
				'required' => 'required',
			),
		)
	);

	$cmb->add_field(
		array(
			'name'       => __( 'AWORK ONE Company ID', 'formular-af-awork-one' ),
			'id'         => FAAONE_TEXTDOMAIN . '_field_company_id',
			'type'       => 'text',
			'attributes' => array(
				'required' => 'required', // HTML5 validation.
			),
		)
	);

	// DIVIDER: hCaptcha Settings.
	$cmb->add_field(
		array(
			'name' => __( 'hCaptcha Settings (Optional)', 'formular-af-awork-one' ),
			'desc' => __( 'Configure your hCaptcha integration', 'formular-af-awork-one' ),
			'type' => 'title',
			'id'   => 'hcaptcha_divider',
		)
	);

	$cmb->add_field(
		array(
			'name' => 'hCaptcha ' . __( 'secret key', 'formular-af-awork-one' ),
			'id'   => FAAONE_TEXTDOMAIN . '_hcaptcha_secret_key',
			'type' => 'text',
		)
	);

	$cmb->add_field(
		array(
			'name' => 'hCaptcha ' . __( 'site key', 'formular-af-awork-one' ),
			'id'   => FAAONE_TEXTDOMAIN . '_hcaptcha_site_key',
			'type' => 'text',
		)
	);


	cmb2_metabox_form( FAAONE_TEXTDOMAIN . '_options', FAAONE_TEXTDOMAIN . '-settings' );
	?>
</div>
