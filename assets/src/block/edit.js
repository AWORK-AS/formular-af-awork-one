import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, ColorPalette } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const { headline, color, btnColor, btnTextColor} = attributes;
    const translations = window.cfaBlockTranslations || {};
    // Use randomId
    const randomId = Math.random().toString(36).substr(2, 9);
    const formId = `cfa-form-${randomId}`;

    return (
        <div {...useBlockProps()}>
            <PanelBody title={translations.formSettings || 'Form Settings'} initialOpen={true}>
                <PanelRow>
                    <RichText
                        tagName="h3"
                        value={headline}
                        onChange={(value) => setAttributes({ headline: value })}
                        placeholder={translations.enterHeadline || 'Enter form headline...'}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{translations.headlineColor || 'Headline Color'}</label>
                    <ColorPalette
                        value={color}
                        onChange={(value) => setAttributes({ color: value })}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{translations.btnColor || 'Button Color'}</label>
                    <ColorPalette
                        value={btnColor}
                        onChange={(value) => setAttributes({ btnColor: value })}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{translations.btnTextColor || 'Button Text Color'}</label>
                    <ColorPalette
                        value={btnTextColor}
                        onChange={(value) => setAttributes({ btnTextColor: value })}
                    />
                </PanelRow>
            </PanelBody>
            
            {/* Form preview in editor */}
            <div className="cfa-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {translations.headline || 'Get in Touch With Us'}
                </h3>
                <div className="cfa-form-preview">
                    <div className="cfa-form-grid">
                        <div className="cfa-form-group cfa-form-group--full">
                            <input type="text" disabled placeholder={translations.name || 'Name'}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="text" disabled placeholder={translations.company || 'Company'}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="email" disabled placeholder={translations.email || 'Email'}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="tel" disabled placeholder={translations.phone || 'Phone'}/>
                        </div>
                        
                        <div className="cfa-form-group cfa-form-group--full">
                            <textarea disabled placeholder={translations.message || 'Message'}></textarea>
                        </div>
                    </div>
                    
                    <div className="cfa-form-footer">
                        <button type="button" disabled className="cfa-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
                            {translations.submit || 'Submit'}
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