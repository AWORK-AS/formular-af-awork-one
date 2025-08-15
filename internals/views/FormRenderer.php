<?php
namespace Contact_Form_App\Internals\Views;

class FormRenderer {
    public function render_form() {
        
       
        $color =  '#0055ff';
        $headline = 'Get in Touch With Us';
        
        
        // Unique ID for form instance
        $form_id = 'cfa-form-' . uniqid();

        //Using `wp-rest` nonce
     
        ob_start(); ?>
       
        <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
        <div class="cfa-contact-form" id="<?= esc_attr($form_id) ?>">
            <h3 style="color: <?= esc_attr($color) ?>" class="cfa-headline-config"><?= esc_html($headline) ?></h3>
            <form class="cfa-form" id="<?= esc_attr($form_id) ?>-form">
                <input type="hidden" name="source_url" value="<?= esc_url($_SERVER['HTTP_REFERER'] ?? '') ?>">
                
                <div class="cfa-form-grid">
                    <div class="cfa-form-group cfa-form-group--full">
                        <label for="cfa-name"><?php _e('Name', 'contact-form-app') ?> *</label>
                        <input type="text" id="cfa-name" name="name" required>
                    </div>
                    
                    <div class="cfa-form-group">
                        <label for="cfa-company"><?php _e('Company', 'contact-form-app') ?> *</label>
                        <input type="text" id="cfa-company" name="company" required>
                    </div>
                    
                    <div class="cfa-form-group">
                        <label for="cfa-email"><?php _e('Email', 'contact-form-app') ?> *</label>
                        <input type="email" id="cfa-email" name="email" required>
                    </div>
                    
                    <div class="cfa-form-group">
                        <label for="cfa-phone"><?php _e('Phone', 'contact-form-app') ?> *</label>
                        <input type="tel" id="cfa-phone" name="phone" required>
                    </div>
                    
                    <div class="cfa-form-group cfa-form-group--full">
                        <label for="cfa-message"><?php _e('Message', 'contact-form-app') ?> *</label>
                        <textarea id="cfa-message" name="message" required></textarea>
                    </div>
                    
                </div>
                
                <div class="cfa-form-footer">
                    <button type="submit" class="cfa-submit-btn">
                        <?php _e('Submit', 'contact-form-app') ?>
                    </button>
                </div>
            </form>
            
            <div class="cfa-message"></div>
            
            <div class="cfa-powered-by">
                <?php _e('Formular af', 'contact-form-app') ?>
                <a href="https://citizenone.dk" target="_blank">
                    CitizenOne - Journalsystem med alt inklusiv
                </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}