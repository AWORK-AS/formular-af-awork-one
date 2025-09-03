<?php

namespace mzaworkdk\Citizenone\Internals\Views;

class FormRenderer {

    public function render_form() {
        $color        = \apply_filters( 'facioj_color', '#205E77' );
        $headline     = \apply_filters( 'facioj_headline', __( 'Get in Touch With Us', 'formular-af-citizenone-journalsystem' ) );
        $btnColor     = \apply_filters( 'facioj_button_color', '#42aed9' );
        $btnTextColor = \apply_filters( 'facioj_button_text_color', '#ffffff');
        $opts         = \facioj_get_settings();
        
        $hcaptcha_site_key   = $opts[ FACIOJ_TEXTDOMAIN . '_hcaptcha_site_key' ];
        $hcaptcha_secret_key = $opts[ FACIOJ_TEXTDOMAIN. '_hcaptcha_secret_key'];
        $hcaptcha_enabled    = ($hcaptcha_site_key && $hcaptcha_secret_key);
        
        // Unique ID for form instance
        $form_id = 'facioj-form-' . uniqid();

        // Using `wp-rest` nonce
     
        ob_start(); ?>
       
        <div class="facioj-contact-form-inherit-parent">
            <div class="facioj-contact-form" id="<?php echo \esc_attr( $form_id ); ?>">
                <h3 style="color: <?php echo \esc_attr( $color ); ?>" class="facioj-headline-config"><?php echo \esc_html( $headline ); ?></h3>
                <form class="facioj-form" id="<?php echo \esc_attr( $form_id ); ?>-form">
                    
                    <div class="facioj-form-grid">
                        <div class="facioj-form-group facioj-form-group--full">
                            
                            <input 
                                type="text" 
                                id="facioj-name" 
                                name="name" 
                                placeholder="<?php \esc_attr_e( 'Name', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                                >
                        </div>
                        
                        <div class="facioj-form-group">
                            <input 
                                type="text" 
                                id="facioj-company" 
                                name="company" 
                                placeholder="<?php \esc_attr_e( 'Company', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                                >
                        </div>
                        
                        <div class="facioj-form-group">
                            <input 
                                type="email" 
                                id="facioj-email" 
                                name="email"
                                placeholder="<?php \esc_attr_e( 'Email', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                            >
                        </div>
                        
                        <div class="facioj-form-group">
                            <input 
                            type="tel" 
                            id="facioj-phone" 
                            name="phone"
                            placeholder="<?php \esc_attr_e( 'Phone', 'formular-af-citizenone-journalsystem' ); ?>"
                            required
                            >
                        </div>
                        
                        <div class="facioj-form-group facioj-form-group--full">
                            <textarea 
                                id="facioj-message"
                                name="message"
                                placeholder="<?php \esc_attr_e( 'Message', 'formular-af-citizenone-journalsystem' ); ?>"
                                required
                                ></textarea>
                        </div>

                        <?php if($hcaptcha_enabled):?>
                            <div class="facioj-form-group facioj-form-group--full">
                                <div class="h-captcha" data-sitekey="<?php echo \esc_attr( $hcaptcha_site_key ); ?>"></div>
                            </div>
                        <?php endif;?>
                    </div>
                    
                    <div class="facioj-form-footer">
                        <button 
                        type="submit" 
                        class="facioj-submit-btn"
                        style="background-color:<?php echo \esc_attr( $btnColor );?>;color:<?php echo \esc_attr( $btnTextColor );?>"
                        >
                            <?php \esc_attr_e( 'Submit', 'formular-af-citizenone-journalsystem' ); ?>
                        </button>
                    </div>
                </form>
                
                <div class="facioj-message"></div>
                
                <div class="facioj-powered-by">
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