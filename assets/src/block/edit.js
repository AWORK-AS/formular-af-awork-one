import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, ColorPalette } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const { headline, color, btnColor, btnTextColor} = attributes;
    const hCaptcha     = window.cfaBlockhCaptcha || {};
    
    const formId = `cfa-form-preview`;

    return (
        <div {...useBlockProps()}>
            <PanelBody title={__( 'Form Settings', 'contact-form-app' )} initialOpen={true}>
                <PanelRow>
                    <RichText
                        tagName="h3"
                        value={headline}
                        onChange={(value) => setAttributes({ headline: value })}
                        placeholder={__( 'Enter form headline...', 'contact-form-app' ) }
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__( 'Headline Color', 'contact-form-app' )}</label>
                    <ColorPalette
                        value={color}
                        onChange={(value) => setAttributes({ color: value })}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__( 'Button Color', 'contact-form-app' )}</label>
                    <ColorPalette
                        value={btnColor}
                        onChange={(value) => setAttributes({ btnColor: value })}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__('Button Text Color', 'contact-form-app')}</label>
                    <ColorPalette
                        value={btnTextColor}
                        onChange={(value) => setAttributes({ btnTextColor: value })}
                    />
                </PanelRow>
            </PanelBody>
            {/* Form preview in editor */}
            <div className="cfa-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || 'Get in Touch With Us'}
                </h3>
                <div className="cfa-form-preview">
                    <div className="cfa-form-grid">
                        <div className="cfa-form-group cfa-form-group--full">
                            <input type="text" disabled placeholder={__( 'Name', 'contact-form-app' )}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="text" disabled placeholder={__( 'Company', 'contact-form-app' )}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="email" disabled placeholder={__( 'Email', 'contact-form-app' )}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="tel" disabled placeholder={__( 'Phone', 'contact-form-app' )}/>
                        </div>
                        
                        <div className="cfa-form-group cfa-form-group--full">
                            <textarea disabled placeholder={__( 'Message', 'contact-form-app' )}></textarea>
                        </div>
                        {
                            hCaptcha.hCaptchaEnabled &&
                            <div className="cfa-form-group cfa-form-group--full">
                                <div className="h-captcha" data-sitekey={hCaptcha.hCaptchaSiteKey}></div>
                            </div>
                        }
                    </div>
                    
                    <div className="cfa-form-footer">
                        <button type="button" disabled className="cfa-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
                            {__( 'Submit', 'contact-form-app' )}
                        </button>
                    </div>
                    
                    <div className="cfa-powered-by">
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