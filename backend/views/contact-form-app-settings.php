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
    /** Hide first */
    /*
    $cmb->add_field(
        array(
            'name'       => __( 'Token', 'contact-form-app' ),
            'desc'       => __( 'Enter your token from CitizenOne dashboard.', 'contact-form-app' ),
            'id'         => CFA_TEXTDOMAIN . '_token',
            'type'       => 'textarea',
            'attributes' => array(
                'required' => 'required', // HTML5 validation
                            ),
        )
    );
    */
    $cmb->add_field(
        array(
            'name'    => __( 'Email', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_field_email',
            'type'    => 'text',
        )
    );
    
    $cmb->add_field(
        array(
            'name'    => __( 'Company CVR', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_field_company_cvr',
            'type'    => 'text',
        )
    );
    
    $cmb->add_field(
        array(
            'name'    => __( 'Email', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_field_email',
            'type'    => 'text',
        )
    );
    
    $cmb->add_field(
        array(
            'name'    => "hCaptcha " . __( 'secret key', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_hcaptcha_secret_key',
            'type'    => 'text',
        )
    );
    $cmb->add_field(
        array(
            'name'    => "hCaptcha " . __( 'site key', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_hcaptcha_site_key',
            'type'    => 'text',
        )
    );
    
    
    cmb2_metabox_form( CFA_TEXTDOMAIN . '_options', CFA_TEXTDOMAIN . '-settings' );
?>
</div>