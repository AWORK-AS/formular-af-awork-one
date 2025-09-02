import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { headline, color, btnColor, btnTextColor } = attributes;
    const hCaptcha     = window.cfaBlockhCaptcha || {};
 
    const formId = `facioj-form-save`;
    
    return (
        <div {...useBlockProps.save()}>
            <div className="facioj-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || __( 'Get in Touch With Us', 'formular-af-citizenone-journalsystem' )}
                </h3>
                <form className="facioj-form" id={`${formId}-form`}>
                    
                    <div className="facioj-form-grid">
                        <div className="facioj-form-group facioj-form-group--full">
                            <input
                                type="text"
                                id={`${formId}-name`}
                                name="name"
                                required
								placeholder={__( 'Name', 'formular-af-citizenone-journalsystem' )}
                            />
                        </div>
                        
                        <div className="facioj-form-group">
                            <input
                                type="text"
                                id={`${formId}-company`}
                                name="company"
                                required
								placeholder={__( 'Company', 'formular-af-citizenone-journalsystem' )}
                            />
                        </div>
                        
                        <div className="facioj-form-group">
                            <input
                                type="email"
                                id={`${formId}-email`}
                                name="email"
                                required
								placeholder={__( 'Email', 'formular-af-citizenone-journalsystem' )}
                            />
                        </div>
                        
                        <div className="facioj-form-group">
                            <input
                                type="tel"
                                id={`${formId}-phone`}
                                name="phone"
                                required
								placeholder={__( 'Phone', 'formular-af-citizenone-journalsystem' )}
                            />
                        </div>
                        
                        <div className="facioj-form-group facioj-form-group--full">
                            <textarea
                                id={`${formId}-message`}
                                name="message"
                                required
								placeholder={__( 'Message', 'formular-af-citizenone-journalsystem' )}
                            ></textarea>
                        </div>

                        {
                            hCaptcha.hCaptchaEnabled &&
                            <div className="facioj-form-group facioj-form-group--full">
                                <div className="h-captcha" data-sitekey={hCaptcha.hCaptchaSiteKey}></div>
                            </div>
                        }
                    </div>
                    
                    <div className="facioj-form-footer">
                        <button type="submit" className="facioj-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
                            {__( 'Submit', 'formular-af-citizenone-journalsystem' )}
                        </button>
                    </div>
                </form>
                
                <div className="facioj-message"></div>
                
                <div className="facioj-powered-by">
                    Formular af { ' ' }
                    <a href="https://citizenone.dk" target="_blank" rel="noreferrer">
                        CitizenOne - Journalsystem med alt inklusiv
                    </a>
                </div>
            </div>
        </div>
    );
}