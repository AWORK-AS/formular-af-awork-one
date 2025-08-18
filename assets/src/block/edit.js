import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, ColorPalette } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const { headline, color } = attributes;

    // Use randomId
    const randomId = Math.random().toString(36).substr(2, 9);
    const formId = `cfa-form-${randomId}`;

    return (
        <div {...useBlockProps()}>
            <PanelBody title={__('Form Settings', 'contact-form-app')} initialOpen={true}>
                <PanelRow>
                    <RichText
                        tagName="h3"
                        value={headline}
                        onChange={(value) => setAttributes({ headline: value })}
                        placeholder={__('Enter form headline...', 'contact-form-app')}
                    />
                </PanelRow>
                <PanelRow>
                    <label>{__('Headline Color', 'contact-form-app')}</label>
                    <ColorPalette
                        value={color}
                        onChange={(value) => setAttributes({ color: value })}
                    />
                </PanelRow>
            </PanelBody>
            
            {/* Form preview in editor */}
            <div className="cfa-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || __('Get in Touch With Us', 'contact-form-app')}
                </h3>
                <div className="cfa-form-preview">
                    <div className="cfa-form-grid">
                        <div className="cfa-form-group cfa-form-group--full">
                            <input type="text" disabled placeholder={__('Name', 'contact-form-app')}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="text" disabled placeholder={__('Company', 'contact-form-app')}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="email" disabled placeholder={__('Email', 'contact-form-app')}/>
                        </div>
                        
                        <div className="cfa-form-group">
                            <input type="tel" disabled placeholder={__('Phone', 'contact-form-app')}/>
                        </div>
                        
                        <div className="cfa-form-group cfa-form-group--full">
                            <textarea disabled placeholder={__('Message', 'contact-form-app')}></textarea>
                        </div>
                    </div>
                    
                    <div className="cfa-form-footer">
                        <button type="button" disabled className="cfa-submit-btn">
                            {__('Submit', 'contact-form-app')}
                        </button>
                    </div>
                    
                    <div className="cfa-powered-by">
                        {__('Formular af', 'contact-form-app')} { ' ' }
                        <a href="https://citizenone.dk" target="_blank" rel="noreferrer">
                            CitizenOne - Journalsystem med alt inklusiv
                        </a>
                    </div>
                </div>
            </div>
        </div>
    );
}