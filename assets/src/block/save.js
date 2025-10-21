import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { headline, color, btnColor, btnTextColor } = attributes;
    const hCaptcha     = window.faaoneBlockhCaptcha || {};

    const formId = `faaone-form-save`;

    return (
        <div {...useBlockProps.save()}>
            <div className="faaone-contact-form" id={formId}>
                <h3 style={{ color: color || '#001A56' }}>
                    {headline || __( 'Get in Touch With Us', 'formularer-for-awork-one' )}
                </h3>
                <form className="faaone-form" id={`${formId}-form`}>

                    <div className="faaone-form-grid">
                        <div className="faaone-form-group">
                            <input
                                type="text"
                                id={`${formId}-name`}
                                name="name"
                                required
								placeholder={__( 'Name', 'formularer-for-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <input
                                type="text"
                                id={`${formId}-company`}
                                name="company"
                                required
								placeholder={__( 'Company', 'formularer-for-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <input
                                type="email"
                                id={`${formId}-email`}
                                name="email"
                                required
								placeholder={__( 'Email', 'formularer-for-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <input
                                type="tel"
                                id={`${formId}-phone`}
                                name="phone"
                                required
								placeholder={__( 'Phone', 'formularer-for-awork-one' )}
                            />
                        </div>

                        <div className="faaone-form-group">
                            <textarea
                                id={`${formId}-message`}
                                name="message"
                                required
								placeholder={__( 'Message', 'formularer-for-awork-one' )}
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
                            {__( 'Submit', 'formularer-for-awork-one' )}
                        </button>
                    </div>
                </form>

                <div className="faaone-message"></div>

                <div className="faaone-powered-by">
                    Formularer for { ' ' }
                    <a href="https://aworkone.dk" target="_blank" rel="noreferrer">
                        AWORK One
                    </a>
                </div>
            </div>
        </div>
    );
}
