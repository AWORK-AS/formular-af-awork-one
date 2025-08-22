import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { headline, color, btnColor, btnTextColor } = attributes;
    const hCaptcha     = window.cfaBlockhCaptcha || {};
 
    const formId = `cfa-form-save`;
    
    return (
        <div {...useBlockProps.save()}>
            <div className="cfa-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || 'Get in Touch With Us'}
                </h3>
                <form className="cfa-form" id={`${formId}-form`}>
                    
                    <div className="cfa-form-grid">
                        <div className="cfa-form-group cfa-form-group--full">
                            <input
                                type="text"
                                id={`${formId}-name`}
                                name="name"
                                required
								placeholder={__( 'Name', 'contact-form-app' )}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="text"
                                id={`${formId}-company`}
                                name="company"
                                required
								placeholder={__( 'Company', 'contact-form-app' )}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="email"
                                id={`${formId}-email`}
                                name="email"
                                required
								placeholder={__( 'Email', 'contact-form-app' )}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="tel"
                                id={`${formId}-phone`}
                                name="phone"
                                required
								placeholder={__( 'Phone', 'contact-form-app' )}
                            />
                        </div>
                        
                        <div className="cfa-form-group cfa-form-group--full">
                            <textarea
                                id={`${formId}-message`}
                                name="message"
                                required
								placeholder={__( 'Message', 'contact-form-app' )}
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
                            {__( 'Submit', 'contact-form-app' )}
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