import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { headline, color, btnColor, btnTextColor } = attributes;
    const hCaptcha     = window.cfaBlockhCaptcha || {};

    const formId = `faaone-form-save`;

    return (
        <div {...useBlockProps.save()}>
            <div className="faaone-contact-form" id={formId}>
                <h3 style={{ color: color || '#001A56' }}>
                    {headline || __( 'Get in Touch With Us', 'formular-af-awork-one' )}
                </h3>
                <form className="faaone-form" id={`${formId}-form`}>

                    <div className="faaone-form-grid">
                        <div className="faaone-form-group">
                            <input
                                type="text"
                                id={`${formId}-name`}
                                name="name"
                                required
								placeholder={__( 'Name', 'formular-af-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <input
                                type="text"
                                id={`${formId}-company`}
                                name="company"
                                required
								placeholder={__( 'Company', 'formular-af-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <input
                                type="email"
                                id={`${formId}-email`}
                                name="email"
                                required
								placeholder={__( 'Email', 'formular-af-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <input
                                type="tel"
                                id={`${formId}-phone`}
                                name="phone"
                                required
								placeholder={__( 'Phone', 'formular-af-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <textarea
                                id={`${formId}-message`}
                                name="message"
                                required
								placeholder={__( 'Message', 'formular-af-awork-one' )}
                            ></textarea>
                        </div>

                        {
                            hCaptcha.hCaptchaEnabled &&
                            <div className="faaone-form-group">
                                <div className="h-captcha" data-sitekey={hCaptcha.hCaptchaSiteKey}></div>
                            </div>
                        }
                    </div>

                    <div className="faaone-form-footer">
                        <button type="submit" className="faaone-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
                            {__( 'Submit', 'formular-af-awork-one' )}
                        </button>
                    </div>
                </form>

                <div className="faaone-message"></div>

                <div className="faaone-powered-by">
                    Formular af { ' ' }
                    <a href="https://aworkone.dk" target="_blank" rel="noreferrer">
                        AWORK ONE
                    </a>
                </div>
            </div>
        </div>
    );
}
