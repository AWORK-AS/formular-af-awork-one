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
            'name'    => __( 'Email', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_field_email',
            'type'    => 'text_email',
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
            'name'    => __( 'CitizenOne Company ID', 'contact-form-app' ),
            'id'      => CFA_TEXTDOMAIN . '_field_company_id',
            'type'    => 'text',
        )
    );
    
    // DIVIDER: hCaptcha Settings
    $cmb->add_field(
        array(
            'name' => __( 'hCaptcha Settings (Optional)', 'contact-form-app' ),
            'desc' => __( 'Configure your hCaptcha integration', 'contact-form-app' ),
            'type' => 'title',
            'id'   => 'hcaptcha_divider'
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