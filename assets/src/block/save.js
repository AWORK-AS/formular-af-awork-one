
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { headline, color, btnColor, btnTextColor } = attributes;
    const translations = window.cfaBlockTranslations || {};
    const hCaptcha     = window.cfaBlockhCaptcha || {};
    // Use randomId
    const randomId = Math.random().toString(36).substr(2, 9);
    const formId = `cfa-form-${randomId}`;
    
    return (
        <div {...useBlockProps.save()}>
            <div className="cfa-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || 'Get in Touch With Us'}
                </h3>
                <form className="cfa-form" id={`${formId}-form`}>
                    <input type="hidden" name="source_url" value="" />
                    
                    <div className="cfa-form-grid">
                        <div className="cfa-form-group cfa-form-group--full">
                            <input
                                type="text"
                                id={`${formId}-name`}
                                name="name"
                                required
								placeholder={translations.name || 'Name'}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="text"
                                id={`${formId}-company`}
                                name="company"
                                required
								placeholder={translations.company || 'Company'}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="email"
                                id={`${formId}-email`}
                                name="email"
                                required
								placeholder={translations.email || 'Email'}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="tel"
                                id={`${formId}-phone`}
                                name="phone"
                                required
								placeholder={translations.phone || 'Phone'}
                            />
                        </div>
                        
                        <div className="cfa-form-group cfa-form-group--full">
                            <textarea
                                id={`${formId}-message`}
                                name="message"
                                required
								placeholder={translations.message || 'Message'}
                            ></textarea>
                        </div>

                        {
                            hCaptcha.hCaptchaEnabled &&
                            <div className="cfa-form-group cfa-form-group--full">
                                <div className="h-captcha" data-sitekey={hCaptcha.hCaptchaSiteKey}></div>
                            </div>
                        }
                    </div>
                    
                    <div className="cfa-form-footer">
                        <button type="submit" className="cfa-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
                            {translations.submit || 'Submit'}
                        </button>
                    </div>
                </form>
                
                <div className="cfa-message"></div>
                
                <div className="cfa-powered-by">
                    Formular af { ' ' }
                    <a href="https://citizenone.dk" target="_blank" rel="noreferrer">
                        CitizenOne - Journalsystem med alt inklusiv
                    </a>
                </div>
            </div>
        </div>
    );
}