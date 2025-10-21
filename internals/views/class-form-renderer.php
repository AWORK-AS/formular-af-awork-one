<?php
/**
 * Shortcode form renderer.
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Aworkone\Internals\Views;

/**
 * Shortcode form renderer.
 */
class Form_Renderer {

	/**
	 * Render the contact form.
	 */
	public function render_form(): string|false {
		$color          = \apply_filters( 'faaone_color', '#001A56' );
		$headline       = \apply_filters( 'faaone_headline', __( 'Get in Touch With Us', 'formularer-for-awork-one' ) );
		$btn_color      = \apply_filters( 'faaone_button_color', '#368F8B' );
		$btn_text_color = \apply_filters( 'faaone_button_text_color', '#ffffff' );

		$hcaptcha_enabled = $this->is_hcaptcha_enabled();
		$form_id          = 'faaone-form-' . uniqid();

		ob_start();
		?>
		<div class="faaone-contact-form-inherit-parent">
			<div class="faaone-contact-form" id="<?php echo \esc_attr( $form_id ); ?>">
				<?php $this->render_headline( $color, $headline ); ?>
				<form class="faaone-form" id="<?php echo \esc_attr( $form_id ); ?>-form">
					<?php $this->render_form_fields( $hcaptcha_enabled ); ?>
					<?php $this->render_form_footer( $btn_color, $btn_text_color ); ?>
				</form>
				<div class="faaone-message"></div>
				<?php $this->render_powered_by(); ?>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Check if hCaptcha is enabled.
	 */
	private function is_hcaptcha_enabled(): bool {
		$opts                = \faaone_get_settings();
		$hcaptcha_site_key   = $opts['faaone_hcaptcha_site_key'] ?? '';
		$hcaptcha_secret_key = $opts['faaone_hcaptcha_secret_key'] ?? '';
		return ! empty( $hcaptcha_site_key ) && ! empty( $hcaptcha_secret_key );
	}

	/**
	 * Render the form headline.
	 *
	 * @param string $color   Color code.
	 * @param string $headline Headline text.
	 */
	private function render_headline( string $color, string $headline ): void {
		?>
		<h3 style="color: <?php echo \esc_attr( $color ); ?>" class="faaone-headline-config">
			<?php echo \esc_html( $headline ); ?>
		</h3>
		<?php
	}

	/**
	 * Render all form fields.
	 *
	 * @param bool $hcaptcha_enabled Whether hCaptcha is enabled.
	 */
	private function render_form_fields( bool $hcaptcha_enabled ): void {
		?>
		<div class="faaone-form-grid">
		<?php
		$this->render_text_input( 'name', __( 'Name', 'formularer-for-awork-one' ), true, 'full' );
		$this->render_text_input( 'company', __( 'Company', 'formularer-for-awork-one' ), true, 'full' );
		$this->render_email_input();
		$this->render_phone_input();
		$this->render_textarea();

		if ( $hcaptcha_enabled ) {
			$this->render_hcaptcha();
		}

		?>
		</div>
		<?php
	}

	/**
	 * Render a text input field.
	 *
	 * @param string $name        Field name.
	 * @param string $placeholder Placeholder text.
	 * @param bool   $required    Whether the field is required.
	 * @param string $size        Field size (empty or 'full').
	 */
	private function render_text_input(
		string $name,
		string $placeholder,
		bool $required = false,
		string $size = ''
	): void {
		$class = 'faaone-form-group';

		if ( ! empty( $size ) ) {
			$class .= ' faaone-form-group--' . $size;
		}

		?>
		<div class="<?php echo \esc_attr( $class ); ?>">
			<input
				type="text"
				id="faaone-<?php echo \esc_attr( $name ); ?>"
				name="<?php echo \esc_attr( $name ); ?>"
				placeholder="<?php echo \esc_attr( $placeholder ); ?>"
				<?php

				if ( $required ) {
					echo 'required';
				}

				?>
			>
		</div>
		<?php
	}

	/**
	 * Render email input field.
	 */
	private function render_email_input(): void {
		?>
		<div class="faaone-form-group">
			<input
				type="email"
				id="faaone-email"
				name="email"
				placeholder="<?php \esc_attr_e( 'Email', 'formularer-for-awork-one' ); ?>"
				required
			>
		</div>
		<?php
	}

	/**
	 * Render phone input field.
	 */
	private function render_phone_input(): void {
		?>
		<div class="faaone-form-group">
			<input
				type="tel"
				id="faaone-phone"
				name="phone"
				placeholder="<?php \esc_attr_e( 'Phone', 'formularer-for-awork-one' ); ?>"
				required
			>
		</div>
		<?php
	}

	/**
	 * Render textarea field.
	 */
	private function render_textarea(): void {
		?>
		<div class="faaone-form-group faaone-form-group--full">
			<textarea
				id="faaone-message"
				name="message"
				placeholder="<?php \esc_attr_e( 'Message', 'formularer-for-awork-one' ); ?>"
				required
			></textarea>
		</div>
		<?php
	}

	/**
	 * Render hCaptcha field.
	 */
	private function render_hcaptcha(): void {
		$opts              = \faaone_get_settings();
		$hcaptcha_site_key = $opts['faaone_hcaptcha_site_key'] ?? '';
		?>
		<div class="faaone-form-group faaone-form-group--full">
			<div class="h-captcha" data-sitekey="<?php echo \esc_attr( $hcaptcha_site_key ); ?>"></div>
		</div>
		<?php
	}

	/**
	 * Render form footer with submit button.
	 *
	 * @param string $btn_color       Button color.
	 * @param string $btn_text_color  Button text color.
	 */
	private function render_form_footer( string $btn_color, string $btn_text_color ): void {
		?>
		<div class="faaone-form-footer">
			<button
				type="submit"
				class="faaone-submit-btn"
				style="background-color:<?php echo \esc_attr( $btn_color ); ?>;color:<?php echo \esc_attr( $btn_text_color ); ?>"
			>
				<?php \esc_attr_e( 'Submit', 'formularer-for-awork-one' ); ?>
			</button>
		</div>
		<?php
	}

	/**
	 * Render powered by section.
	 */
	private function render_powered_by(): void {
		?>
		<div class="faaone-powered-by">
			Formular af
			<a href="https://aworkone.dk" target="_blank">
				AWORK One
			</a>
		</div>
		<?php
	}
}
