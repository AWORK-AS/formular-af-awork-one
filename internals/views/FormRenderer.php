<?php

namespace Contact_Form_App\Internals\Views;

class FormRenderer {

    public function render_form() {
        $color        = \apply_filters( 'cfa_color', '#205E77' );
        $headline     = \apply_filters( 'cfa_headline', __( 'Get in Touch With Us', 'formular-af-citizenone-journalsystem' ) );
        $btnColor     = \apply_filters( 'cfa_button_color', '#42aed9' );
        $btnTextColor = \apply_filters( 'cfa_button_text_color', '#ffffff');
        $opts         = \cfa_get_settings();
        
        $hcaptcha_site_key   = $opts[ CFA_TEXTDOMAIN . '_hcaptcha_site_key' ];
        $hcaptcha_secret_key = $opts[ CFA_TEXTDOMAIN. '_hcaptcha_secret_key'];
        $hcaptcha_enabled    = ($hcaptcha_site_key && $hcaptcha_secret_key);
        
        // Unique ID for form instance
        $form_id = 'cfa-form-' . uniqid();

        // Using `wp-rest` nonce
     
        ob_start(); ?>
       
        <div class="cfa-contact-form-inherit-parent">
            <div class="cfa-contact-form" id="<?php echo \esc_attr( $form_id ); ?>">
                <h3 style="color: <?php echo \esc_attr( $color ); ?>" class="cfa-headline-config"><?php echo \esc_html( $headline ); ?></h3>
                <form class="cfa-form" id="<?php echo \esc_attr( $form_id ); ?>-form">
                    
                    <div class="cfa-form-grid">
                        <div class="cfa-form-group cfa-form-group--full">
                            
                            <input 
                                type="text" 
                                id="cfa-name" 
                                name="name" 
                                placeholder="<?php \esc_attr_e( 'Name', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                                >
                        </div>
                        
                        <div class="cfa-form-group">
                            <input 
                                type="text" 
                                id="cfa-company" 
                                name="company" 
                                placeholder="<?php \esc_attr_e( 'Company', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                                >
                        </div>
                        
                        <div class="cfa-form-group">
                            <input 
                                type="email" 
                                id="cfa-email" 
                                name="email"
                                placeholder="<?php \esc_attr_e( 'Email', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                            >
                        </div>
                        
                        <div class="cfa-form-group">
                            <input 
                            type="tel" 
                            id="cfa-phone" 
                            name="phone"
                            placeholder="<?php \esc_attr_e( 'Phone', 'formular-af-citizenone-journalsystem' ); ?>"
                            required
                            >
                        </div>
                        
                        <div class="cfa-form-group cfa-form-group--full">
                            <textarea 
                                id="cfa-message"
                                name="message"
                                placeholder="<?php \esc_attr_e( 'Message', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                                ></textarea>
                        </div>

                        <?php if($hcaptcha_enabled):?>
                            <div class="cfa-form-group cfa-form-group--full">
                                <div class="h-captcha" data-sitekey="<?php echo \esc_attr( $hcaptcha_site_key ); ?>"></div>
                            </div>
                        <?php endif;?>
                    </div>
                    
                    <div class="cfa-form-footer">
                        <button 
                        type="submit" 
                        class="cfa-submit-btn"
                        style="background-color:<?php echo \esc_attr( $btnColor );?>;color:<?php echo \esc_attr( $btnTextColor );?>"
                        >
                            <?php \esc_attr_e( 'Submit', 'formular-af-citizenone-journalsystem' ); ?>
                        </button>
                    </div>
                </form>
                
                <div class="cfa-message"></div>
                
                <div class="cfa-powered-by">
                    Formular af 
                    <a href="https://citizenone.dk" target="_blank">
                        CitizenOne - Journalsystem med alt inklusiv
                    </a>
                </div>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

}