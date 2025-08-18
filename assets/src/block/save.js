import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { headline, color } = attributes;
    
    // Use randomId
    const randomId = Math.random().toString(36).substr(2, 9);
    const formId = `cfa-form-${randomId}`;

    return (
        <div {...useBlockProps.save()}>
            <div className="cfa-contact-form" id={formId}>
                <h3 style={{ color: color || '#205E77' }}>
                    {headline || __('Get in Touch With Us', 'contact-form-app')}
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
								placeholder={__('Name', 'contact-form-app')}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="text"
                                id={`${formId}-company`}
                                name="company"
                                required
								placeholder={__('Company', 'contact-form-app')}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="email"
                                id={`${formId}-email`}
                                name="email"
                                required
								placeholder={__('Email', 'contact-form-app')}
                            />
                        </div>
                        
                        <div className="cfa-form-group">
                            <input
                                type="tel"
                                id={`${formId}-phone`}
                                name="phone"
                                required
								placeholder={__('Phone', 'contact-form-app')}
                            />
                        </div>
                        
                        <div className="cfa-form-group cfa-form-group--full">
                            <textarea
                                id={`${formId}-message`}
                                name="message"
                                required
								placeholder={__('Message', 'contact-form-app')}
                            ></textarea>
                        </div>
                    </div>
                    
                    <div className="cfa-form-footer">
                        <button type="submit" className="cfa-submit-btn">
                            {__('Submit', 'contact-form-app')}
                        </button>
                    </div>
                </form>
                
                <div className="cfa-message"></div>
                
                <div className="cfa-powered-by">
                    {__('Formular af', 'contact-form-app')} { ' ' }
                    <a href="https://citizenone.dk" target="_blank" rel="noreferrer">
                        CitizenOne - Journalsystem med alt inklusiv
                    </a>
                </div>
            </div>
        </div>
    );
}