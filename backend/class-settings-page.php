<?php
/**
 * Form by AWORK One
 *
 * @package   mzaworkdk\Aworkone
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace mzaworkdk\Aworkone\Backend;

use mzaworkdk\Aworkone\Engine\Base;
use mzaworkdk\Aworkone\Internals\Models\Retrieve_Token;

/**
 * Create the settings page in the backend using the WordPress Settings API.
 */
class Settings_Page extends Base {

	/**
	 * Option group key.
	 *
	 * @var string The key for the options in the database.
	 */
	private $option_group = FAAONE_TEXTDOMAIN . '_group';

	/**
	 * Option name.
	 *
	 * @var string The name of the option in the wp_options table.
	 */
	private $option_name = FAAONE_TEXTDOMAIN . '-settings';

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Add the options page and menu item.
		\add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Register settings, sections, and fields.
		\add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Intercept form submission BEFORE settings are saved.
		\add_filter( 'pre_update_option_' . $this->option_name, array( $this, 'before_save_settings' ), 10, 2 );

		\add_action( 'admin_init', array( $this, 'handle_notice_dismissal' ) );
		\add_action( 'admin_notices', array( $this, 'display_admin_notices' ) );

		$realpath        = (string) \realpath( __DIR__ );
		$plugin_basename = \plugin_basename( \plugin_dir_path( $realpath ) . FAAONE_TEXTDOMAIN . '.php' );
		\add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register the administration menu for this plugin.
	 */
	public function add_plugin_admin_menu(): void {
		\add_menu_page(
			\__( 'Contact Form App Settings', 'formularer-for-awork-one' ),
			FAAONE_NAME,
			'manage_options',
			FAAONE_TEXTDOMAIN, // Page slug.
			array( $this, 'display_plugin_admin_page' ),
			'dashicons-hammer',
			90
		);
	}

	/**
	 * Render the settings page for this plugin.
	 */
	public function display_plugin_admin_page(): void {
		// This view file will also be modified.
		include_once FAAONE_PLUGIN_ROOT . 'backend/views/admin.php';
	}

	/**
	 * Register all settings, sections, and fields.
	 */
	public function register_settings(): void {
		// Register the setting. This will create the entry in the wp_options table.
		register_setting(
			$this->option_group,
			$this->option_name,
			array(
				'sanitize_callback' => array( $this, 'sanitize_main_settings' ),
			)
		);

		// Section 1: Main Settings.
		add_settings_section(
			'faaone_main_section',
			__( 'API Credentials', 'formularer-for-awork-one' ),
			// @phpstan-ignore argument.type
			null, // No callback needed for the section description.
			FAAONE_TEXTDOMAIN // Page slug.
		);

		// Section 2: hCaptcha Settings.
		add_settings_section(
			'faaone_hcaptcha_section',
			__( 'hCaptcha Settings (Optional)', 'formularer-for-awork-one' ),
			// @phpstan-ignore argument.type
			null, // No callback needed for the section description.
			FAAONE_TEXTDOMAIN
		);

		// Add fields for Main Settings.
		add_settings_field(
			'faaone_field_email',
			__( 'Email', 'formularer-for-awork-one' ),
			array( $this, 'render_text_field' ),
			FAAONE_TEXTDOMAIN,
			'faaone_main_section',
			array(
				'id'       => 'faaone_field_email',
				'required' => true,
			)
		);
		add_settings_field(
			'faaone_field_company_cvr',
			__( 'Company CVR', 'formularer-for-awork-one' ),
			array( $this, 'render_text_field' ),
			FAAONE_TEXTDOMAIN,
			'faaone_main_section',
			array(
				'id'       => 'faaone_field_company_cvr',
				'required' => true,
			)
		);
		add_settings_field(
			'faaone_field_client_id',
			__( 'AWORK One Client ID', 'formularer-for-awork-one' ),
			array( $this, 'render_text_field' ),
			FAAONE_TEXTDOMAIN,
			'faaone_main_section',
			array(
				'id'       => 'faaone_field_client_id',
				'required' => true,
			)
		);

		// Add fields for hCaptcha.
		add_settings_field(
			'faaone_hcaptcha_secret_key',
			'hCaptcha ' . __( 'secret key', 'formularer-for-awork-one' ),
			array( $this, 'render_text_field' ),
			FAAONE_TEXTDOMAIN,
			'faaone_hcaptcha_section',
			array( 'id' => 'faaone_hcaptcha_secret_key' )
		);
		add_settings_field(
			'faaone_hcaptcha_site_key',
			'hCaptcha ' . __( 'site key', 'formularer-for-awork-one' ),
			array( $this, 'render_text_field' ),
			FAAONE_TEXTDOMAIN,
			'faaone_hcaptcha_section',
			array( 'id' => 'faaone_hcaptcha_site_key' )
		);
	}

	/**
	 * Renders a generic text input field.
	 *
	 * @param array $args Arguments passed from add_settings_field.
	 */
	public function render_text_field( array $args ): void {
		// 1. Get all options.
		$all_options = \get_option( $this->option_name, array() );
		if ( ! is_array( $all_options ) ) {
			$all_options = array();
		}

		// 2. Define the default value for this field.
		$defaults = array(
			$args['id'] => '', // Make sure the default is a string.
		);

		// 3. Merge the saved options with defaults.
		// If $all_options is not an array, wp_parse_args will convert it to an array.
		$options = \wp_parse_args( $all_options, $defaults );

		// Now, we're sure that $options[$args['id']] is a string
		// unless it was intentionally saved as an array.
		// Let's still add is_scalar for 100% safety.
		$value = \is_scalar( $options[ $args['id'] ] ) ? (string) $options[ $args['id'] ] : '';

		printf(
			'<input type="text" id="%s" name="%s" value="%s" class="regular-text"',
			esc_attr( $args['id'] ),
			esc_attr( "{$this->option_name}[{$args['id']}]" ), // name attribute.
			esc_attr( $value )                               // value attribute.
		);
		// Use separate 'if' for conditional attribute.
		if ( isset( $args['required'] ) && $args['required'] ) {
			// Directly print the static string. Since it doesn't contain variables,
			// PHPCS knows it's safe.
			echo ' required="required"';
		}
		// Close the tag.
		echo ' />';
	}

	/**
	 * Action before settings are saved.
	 *
	 * @param array $new_value The new, unsanitized value for the option.
	 * @param array $old_value The old value of the option.
	 * @return array The new value to save, or the old value if there's an error.
	 */
	public function before_save_settings( $new_value, $old_value ) {
		$submitted_values = $this->get_sanitized_submitted_values( $new_value );

		if ( $this->has_validation_errors( $submitted_values ) ) {
			// Return the old value to prevent saving if there are errors.
			return $old_value;
		}

		$token_data = $this->process_token_retrieval( $submitted_values );

		// Merge the new token data with the submitted values.
		if ( $token_data ) {
			$new_value[ FAAONE_TEXTDOMAIN . '_token' ] = $token_data;
		} else {
			// If API fails, remove the old token.
			unset( $new_value[ FAAONE_TEXTDOMAIN . '_token' ] );
		}

		// Sanitize all fields before returning.
		foreach ( $new_value as $key => $value ) {
			$new_value[ $key ] = sanitize_text_field( $value );
		}

		return $new_value;
	}

	/**
	 * Get and sanitize submitted form values.
	 *
	 * @param array $values The raw $_POST values for our option.
	 * @return array Sanitized values.
	 */
	private function get_sanitized_submitted_values( array $values ): array {
		$data = array(
			'company_cvr' => isset( $values['faaone_field_company_cvr'] ) ? sanitize_text_field( $values['faaone_field_company_cvr'] ) : '',
			'client_id'   => isset( $values['faaone_field_client_id'] ) ? sanitize_text_field( $values['faaone_field_client_id'] ) : '',
			'email'       => isset( $values['faaone_field_email'] ) ? sanitize_email( $values['faaone_field_email'] ) : '',
		);
		return $data;
	}

	/**
	 * Process token retrieval from API.
	 *
	 * @param array $values The data.
	 * @return mixed The token data on success, false on failure.
	 */
	private function process_token_retrieval( array $values ) {
		$token = new Retrieve_Token();
		$data  = $token->submit(
			array(
				'company_cvr'        => $values['company_cvr'],
				'aworkone_client_id' => $values['client_id'],
				'email'              => $values['email'],
			)
		);

		if ( ! is_object( $data ) || ! isset( $data->data ) ) {
			$error_message = __( 'The API did not accept the provided data. Please check your information and try again.', 'formularer-for-awork-one' );
			add_settings_error( 'faaone_messages', 'api_error', $error_message, 'error' );
			return false;
		}

		$success_message = __( '✅ Successfully connected to AWORK One', 'formularer-for-awork-one' );
		add_settings_error( 'faaone_messages', 'api_success', $success_message, 'updated' ); // 'updated' is the class for green notices.
		return $data->data;
	}

	/**
	 * Validate required fields.
	 *
	 * @param array $values Data.
	 */
	private function has_validation_errors( array $values ): bool {
		$has_errors = false;
		if ( empty( $values['company_cvr'] ) ) {
			add_settings_error( 'faaone_messages', 'cvr_required', __( 'Company CVR is required.', 'formularer-for-awork-one' ), 'error' );
			$has_errors = true;
		}
		if ( empty( $values['client_id'] ) ) {
			add_settings_error( 'faaone_messages', 'id_required', __( 'AWORK One Client ID is required.', 'formularer-for-awork-one' ), 'error' );
			$has_errors = true;
		}
		if ( empty( $values['email'] ) ) {
			add_settings_error( 'faaone_messages', 'email_required', __( 'Email address is required.', 'formularer-for-awork-one' ), 'error' );
			$has_errors = true;
		}
		return $has_errors;
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @param array $links Action links.
	 */
	public function add_action_links( array $links ): array {
		// Update the URL to point to the correct menu page.
		return \array_merge(
			array(
				'settings' => '<a href="' . \admin_url( 'admin.php?page=' . FAAONE_TEXTDOMAIN ) . '">' . \__( 'Settings', 'formularer-for-awork-one' ) . '</a>',
			),
			$links
		);
	}

	/**
	 * Display admin notices when needed.
	 */
	public function display_admin_notices(): void {
		// Check if the user has the capability to install plugins.
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		// Check if our transient is set.
		if ( get_transient( 'faaone_autoloader_not_optimized' ) ) {
			$message = sprintf(
				// Use esc_html() for security.
				/* translators: %s is a link to dismiss the notice */
				esc_html__( 'For better performance, the Formularer for AWORK One plugin recommends regenerating the autoloader. This is a developer-level task. %s', 'formularer-for-awork-one' ),
				// Add a link to dismiss the notice.
				'<a href="' . esc_url( add_query_arg( 'faaone_dismiss_notice', 'autoloader_warning' ) ) . '">' . esc_html__( 'Dismiss this notice', 'formularer-for-awork-one' ) . '</a>'
			);

			// Show the notice. 'notice-warning' gives a yellow color.
			echo '<div class="notice notice-warning"><p>' . $message . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			// We'll ignore PHPCS here because we built the $message with escaping.
		}
	}

	/**
	 * Handle the dismissal of the notice.
	 */
	public function handle_notice_dismissal(): void {
		if ( isset( $_GET['faaone_dismiss_notice'] ) && 'autoloader_warning' === $_GET['faaone_dismiss_notice'] ) { //phpcs:ignore
			// Remove the transient so the notice doesn't appear again.
			delete_transient( 'faaone_autoloader_not_optimized' );
		}
	}

	/**
	 * ✅ NEW FUNCTION: Main sanitization callback for the settings.
	 *
	 * @param array $input The raw input from the form.
	 * @return array The sanitized input.
	 */
	public function sanitize_main_settings( array $input ): array {
		$new_input = array();

		// Sanitize each expected field.
		if ( isset( $input['faaone_field_email'] ) ) {
			$new_input['faaone_field_email'] = sanitize_email( $input['faaone_field_email'] );
		}
		if ( isset( $input['faaone_field_company_cvr'] ) ) {
			$new_input['faaone_field_company_cvr'] = sanitize_text_field( $input['faaone_field_company_cvr'] );
		}
		if ( isset( $input['faaone_field_client_id'] ) ) {
			$new_input['faaone_field_client_id'] = sanitize_text_field( $input['faaone_field_client_id'] );
		}
		if ( isset( $input['faaone_hcaptcha_secret_key'] ) ) {
			$new_input['faaone_hcaptcha_secret_key'] = sanitize_text_field( $input['faaone_hcaptcha_secret_key'] );
		}
		if ( isset( $input['faaone_hcaptcha_site_key'] ) ) {
			$new_input['faaone_hcaptcha_site_key'] = sanitize_text_field( $input['faaone_hcaptcha_site_key'] );
		}
		if ( isset( $input[ FAAONE_TEXTDOMAIN . '_token' ] ) ) {
			$new_input[ FAAONE_TEXTDOMAIN . '_token' ] = sanitize_text_field( $input[ FAAONE_TEXTDOMAIN . '_token' ] );
		}
		return $new_input;
	}
}
