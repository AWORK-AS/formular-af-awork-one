<div id="tabs-1" class="wrap">
<?php
        $cmb = new_cmb2_box(
            array(
                'id'         => CFA_TEXTDOMAIN . '_options',
                'hookup'     => false,
                'show_on'    => array( 'key' => 'options-page', 'value' => array( CFA_TEXTDOMAIN ) ),
                'show_names' => true,
            )
        );
        $cmb->add_field(
            array(
                'name'       => __( 'Token', 'contact-form-app' ),
                'desc'       => __( 'Enter your API token from '.CFA_PLUGIN_API_NAME.' here.', 'contact-form-app' ),
                'id'         => CFA_TEXTDOMAIN . '_token',
                'type'       => 'text',
                'attributes' => array(
					'required' => 'required', // HTML5 validation
                                ),
            )
        );
        $cmb->add_field(
            array(
                'name'    => __( 'Company Name', 'contact-form-app' ),
                'type'    => 'text',
                'id'      => CFA_TEXTDOMAIN . '_company_name',
                'default' => get_bloginfo( 'name' ),
            )
        );
        $cmb->add_field(
            array(
                'name'    => __( 'Headline', 'contact-form-app' ),
                'id'      => CFA_TEXTDOMAIN . '_headline',
                'type'    => 'text',
                'default' => 'Get in Touch With Us',
            )
        );
        $cmb->add_field(
            array(
                'name'    => __( 'Color Theme', 'contact-form-app' ),
                'id'      => CFA_TEXTDOMAIN . '_color_theme',
                'type'    => 'colorpicker',
                'default' => '#0055ff',
            )
        );
        cmb2_metabox_form( CFA_TEXTDOMAIN . '_options', CFA_TEXTDOMAIN . '-settings' );
		?>
</div>