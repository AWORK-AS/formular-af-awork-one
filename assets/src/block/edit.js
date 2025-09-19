import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, ColorPalette } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const { headline, color, btnColor, btnTextColor} = attributes;
    const hCaptcha     = window.cfaBlockhCaptcha || {};

    const formId = `faaone-form-preview`;

    return (
		<div {...useBlockProps()}>
			<PanelBody title={__( 'Form Settings', 'formular-af-awork-one' )} initialOpen={true}>
				<PanelRow>
					<RichText
						tagName="h3"
						value={headline}
						onChange={(value) => setAttributes({ headline: value })}
						placeholder={__( 'Enter form headline...', 'formular-af-awork-one' ) }
					/>
				</PanelRow>
				<PanelRow>
					<label>{__( 'Headline Color', 'formular-af-awork-one' )}</label>
					<ColorPalette
						value={color}
						onChange={(value) => setAttributes({ color: value })}
					/>
				</PanelRow>
				<PanelRow>
					<label>{__( 'Button Color', 'formular-af-awork-one' )}</label>
					<ColorPalette
						value={btnColor}
						onChange={(value) => setAttributes({ btnColor: value })}
					/>
				</PanelRow>
				<PanelRow>
					<label>{__( 'Button Text Color', 'formular-af-awork-one' )}</label>
					<ColorPalette
						value={btnTextColor}
						onChange={(value) => setAttributes({ btnTextColor: value })}
					/>
				</PanelRow>
			</PanelBody>
			{/* Form preview in editor */}
			<div className="faaone-contact-form" id={formId}>
				<h3 style={{ color: color || '#001A56' }}>
					{headline || __( 'Get in Touch With Us', 'formular-af-awork-one' )}
				</h3>
				<div className="faaone-form-preview">
					<div className="faaone-form-grid">
						<div className="faaone-form-group">
							<input type="text" disabled placeholder={__( 'Name', 'formular-af-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<input type="text" disabled placeholder={__( 'Company', 'formular-af-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<input type="email" disabled placeholder={__( 'Email', 'formular-af-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<input type="tel" disabled placeholder={__( 'Phone', 'formular-af-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<textarea disabled placeholder={__( 'Message', 'formular-af-awork-one' )}></textarea>
						</div>
						{
							hCaptcha.hCaptchaEnabled &&
							<div className="faaone-form-group">
								<div className="h-captcha" data-sitekey={hCaptcha.hCaptchaSiteKey}></div>
							</div>
						}
					</div>

					<div className="faaone-form-footer">
						<button type="button" disabled className="faaone-submit-btn" style={{backgroundColor: btnColor, color: btnTextColor}}>
							{__( 'Submit', 'formular-af-awork-one' )}
						</button>
					</div>

					<div className="faaone-powered-by">
						Formular af { ' ' }
						<a href="https://aworkone.dk" target="_blank" rel="noreferrer">
							AWORK ONE
						</a>
					</div>
				</div>
			</div>
		</div>
	);
}
