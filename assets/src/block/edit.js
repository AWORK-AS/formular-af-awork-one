import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, ColorPalette } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {

    const { headline, color, btnColor, btnTextColor} = attributes;
    const hCaptcha     = window.faaoneBlockhCaptcha || {};

    const formId = `faaone-form-preview`;

    return (
		<div {...useBlockProps()}>
			<PanelBody title={__( 'Form Settings', 'formularer-for-awork-one' )} initialOpen={true}>
				<PanelRow>
					<RichText
						tagName="h3"
						value={headline}
						onChange={(value) => setAttributes({ headline: value })}
						placeholder={__( 'Enter form headline...', 'formularer-for-awork-one' ) }
					/>
				</PanelRow>
				<PanelRow>
					<label>{__( 'Headline Color', 'formularer-for-awork-one' )}</label>
					<ColorPalette
						value={color}
						onChange={(value) => setAttributes({ color: value })}
					/>
				</PanelRow>
				<PanelRow>
					<label>{__( 'Button Color', 'formularer-for-awork-one' )}</label>
					<ColorPalette
						value={btnColor}
						onChange={(value) => setAttributes({ btnColor: value })}
					/>
				</PanelRow>
				<PanelRow>
					<label>{__( 'Button Text Color', 'formularer-for-awork-one' )}</label>
					<ColorPalette
						value={btnTextColor}
						onChange={(value) => setAttributes({ btnTextColor: value })}
					/>
				</PanelRow>
			</PanelBody>
			{/* Form preview in editor */}
			<div className="faaone-contact-form" id={formId}>
				<h3 style={{ color: color || '#001A56' }}>
					{headline || __( 'Get in Touch With Us', 'formularer-for-awork-one' )}
				</h3>
				<div className="faaone-form-preview">
					<div className="faaone-form-grid">
						<div className="faaone-form-group">
							<input type="text" disabled placeholder={__( 'Name', 'formularer-for-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<input type="text" disabled placeholder={__( 'Company', 'formularer-for-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<input type="email" disabled placeholder={__( 'Email', 'formularer-for-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<input type="tel" disabled placeholder={__( 'Phone', 'formularer-for-awork-one' )}/>
						</div>

						<div className="faaone-form-group">
							<textarea disabled placeholder={__( 'Message', 'formularer-for-awork-one' )}></textarea>
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
							{__( 'Submit', 'formularer-for-awork-one' )}
						</button>
					</div>

					<div className="faaone-powered-by">
						Formularer for { ' ' }
						<a href="https://aworkone.dk" target="_blank" rel="noreferrer">
							AWORK One
						</a>
					</div>
				</div>
			</div>
		</div>
	);
}
