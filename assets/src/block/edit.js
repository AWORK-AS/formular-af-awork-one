import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, ColorPalette } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const { headline, color, btnColor, btnTextColor} = attributes;
    const hCaptcha     = window.cfaBlockhCaptcha || {};
    
    const formId = `facioj-form-preview`;

    return (
        <div {...useBlockProps()}>
            <PanelBody title={__( 'Form Settings', 'formular-af-citizenone-journalsystem' )} initialOpen={true}>
                <PanelRow>
                    <RichText
                        tagName="h3"
                        value={headline}
                        onChange={(value) => setAttributes({ headline: value })}
                        placeholder={__( 'Enter form headline...', 'formular-af-citizenone-journalsystem' ) }
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__( 'Headline Color', 'formular-af-citizenone-journalsystem' )}</label>
                    <ColorPalette
                        value={color}
                        onChange={(value) => setAttributes({ color: value })}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__( 'Button Color', 'formular-af-citizenone-journalsystem' )}</label>
                    <ColorPalette
                        value={btnColor}
                        onChange={(value) => setAttributes({ btnColor: value })}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__( 'Button Text Color', 'formular-af-citizenone-journalsystem' )}</label>
                    <ColorPalette
                        value={btnTextColor}
                        onChange={(value) => setAttributes({ btnTextColor: value })}
                    />
                </PanelRow>
            </PanelBody>
            {/* Form preview in editor */}
            <div className="facioj-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || __( 'Get in Touch With Us', 'formular-af-citizenone-journalsystem' )}
                </h3>
                <div className="facioj-form-preview">
                    <div className="facioj-form-grid">
                        <div className="facioj-form-group facioj-form-group--full">
                            <input type="text" disabled placeholder={__( 'Name', 'formular-af-citizenone-journalsystem' )}/>
                        </div>
                        
                        <div className="facioj-form-group">
                            <input type="text" disabled placeholder={__( 'Company', 'formular-af-citizenone-journalsystem' )}/>
                        </div>
                        
                        <div className="facioj-form-group">
                            <input type="email" disabled placeholder={__( 'Email', 'formular-af-citizenone-journalsystem' )}/>
                        </div>
                        
                        <div className="facioj-form-group">
                            <input type="tel" disabled placeholder={__( 'Phone', 'formular-af-citizenone-journalsystem' )}/>
                        </div>
                        
                        <div className="facioj-form-group facioj-form-group--full">
                            <textarea disabled placeholder={__( 'Message', 'formular-af-citizenone-journalsystem' )}></textarea>
                        </div>
                        {
                            hCaptcha.hCaptchaEnabled &&
                            <div className="facioj-form-group facioj-form-group--full">
                                <div className="h-captcha" data-sitekey={hCaptcha.hCaptchaSiteKey}></div>
                            </div>
                        }
                    </div>
                    
                    <div className="facioj-form-footer">
                        <button type="button" disabled className="facioj-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
                            {__( 'Submit', 'formular-af-citizenone-journalsystem' )}
                        </button>
                    </div>
                    
                    <div className="facioj-powered-by">
                        Formular af { ' ' }
                        <a href="https://citizenone.dk" target="_blank" rel="noreferrer">
                            CitizenOne - Journalsystem med alt inklusiv
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
}