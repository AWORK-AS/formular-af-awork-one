<?php
/**
 * Retrieve token from API
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Aworkone\Internals;

/**
 * Render shortcode
 */
class Shortcode {

	/**
	 * Initialize shortcode.
	 */
	public function initialize(): void {
		\add_shortcode( 'faaone_aworkone_form', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Render shortcode.
	 *
	 * @param array $attributes Attributes.
	 */
	public function render_shortcode( $attributes ): string|false {
		// Pass block attributes to the renderer.
		if ( ! empty( $attributes['headline'] ) ) {
			\add_filter(
				'faaone_headline',
				function () use ( $attributes ) {
					return $attributes['headline'];
				}
			);
		}

		if ( ! empty( $attributes['color'] ) ) {
			\add_filter(
				'faaone_color',
				function () use ( $attributes ) {
					return $attributes['color'];
				}
			);
		}

		if ( ! empty( $attributes['button_color'] ) ) {
			\add_filter(
				'faaone_button_color',
				function () use ( $attributes ) {
					return $attributes['button_color'];
				}
			);
		}

		if ( ! empty( $attributes['button_text_color'] ) ) {
			\add_filter(
				'faaone_button_text_color',
				function () use ( $attributes ) {
					return $attributes['button_text_color'];
				}
			);
		}

		$renderer = new \mzaworkdk\Aworkone\Internals\Views\Form_Renderer();

		return $renderer->render_form();
	}
}
