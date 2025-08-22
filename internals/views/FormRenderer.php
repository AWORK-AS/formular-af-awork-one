<?php
namespace Contact_Form_App\Internals\Views;

class FormRenderer {
    public function render_form() {
        
        $color = \apply_filters('cfa_form_color', '#205E77');
        $headline = \apply_filters('cfa_form_headline', __('Get in Touch With Us', 'contact-form-app'));
        
        
        
        // Unique ID for form instance
        $form_id = 'cfa-form-' . uniqid();

        //Using `wp-rest` nonce
     
        ob_start(); ?>
       
        
        <div class="cfa-contact-form" id="<?php echo \esc_attr($form_id) ?>">
            <h3 style="color: <?php echo \esc_attr($color) ?>" class="cfa-headline-config"><?php echo \esc_html($headline) ?></h3>
            <form class="cfa-form" id="<?php echo \esc_attr($form_id) ?>-form">
                
                <div class="cfa-form-grid">
                    <div class="cfa-form-group cfa-form-group--full">
                        <label for="cfa-name"><?php \esc_attr_e('Name', 'contact-form-app') ?> *</label>
                        <input type="text" id="cfa-name" name="name" required>
                    </div>
                    
                    <div class="cfa-form-group">
                        <label for="cfa-company"><?php \esc_attr_e('Company', 'contact-form-app') ?> *</label>
                        <input type="text" id="cfa-company" name="company" required>
                    </div>
                    
                    <div class="cfa-form-group">
                        <label for="cfa-email"><?php \esc_attr_e('Email', 'contact-form-app') ?> *</label>
                        <input type="email" id="cfa-email" name="email" required>
                    </div>
                    
                    <div class="cfa-form-group">
                        <label for="cfa-phone"><?php \esc_attr_e('Phone', 'contact-form-app') ?> *</label>
                        <input type="tel" id="cfa-phone" name="phone" required>
                    </div>
                    
                    <div class="cfa-form-group cfa-form-group--full">
                        <label for="cfa-message"><?php \esc_attr_e('Message', 'contact-form-app') ?> *</label>
                        <textarea id="cfa-message" name="message" required></textarea>
                    </div>
                    
                </div>
                
                <div class="cfa-form-footer">
                    <button type="submit" class="cfa-submit-btn">
                        <?php \esc_attr_e('Submit', 'contact-form-app') ?>
                    </button>
                </div>
            </form>
            
            <div class="cfa-message"></div>
            
            <div class="cfa-powered-by">
                <?php \esc_attr_e('Formular af', 'contact-form-app') ?>
                <a href="https://citizenone.dk" target="_blank">
                    CitizenOne - Journalsystem med alt inklusiv
                </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}