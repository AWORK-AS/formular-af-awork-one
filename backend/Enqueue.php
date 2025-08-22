<?php

/**
 * Contact_Form_App
 *
 * @package   Contact_Form_App
 * @author    Mindell Zamora <mz@awork.dk>
 * @copyright 2025 AWORK A/S
 * @license   GPL 2.0+
 * @link      https://awork.dk
 */

namespace Contact_Form_App\Backend;

use Inpsyde\Assets\Asset;
use Inpsyde\Assets\AssetManager;
use Inpsyde\Assets\Script;
use Inpsyde\Assets\Style;
use Contact_Form_App\Engine\Base;

/**
 * This class contain the Enqueue stuff for the backend
 */
class Enqueue extends Base {

	/**
	 * Initialize the class.
	 *
	 * @return void|bool
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}
        \add_action('init', array( $this, 'register_block' ), 20);
		\add_action( AssetManager::ACTION_SETUP, array( $this, 'enqueue_assets' ) );
		
		\add_action('admin_enqueue_scripts', array( $this, 'attach_block_editor_data'), 19);
	}
    
	/**
     * Registers the Gutenberg block, linking it to its scripts, styles,
     * and server-side translations.
     */
    public function register_block() {
        
        \register_block_type_from_metadata(
            CFA_PLUGIN_ROOT . 'block.json'
        );
    }

	/**
	 * Enqueue assets with Inpyside library https://inpsyde.github.io/assets
	 *
	 * @param \Inpsyde\Assets\AssetManager $asset_manager The class.
	 * @return void
	 */
	public function enqueue_assets( AssetManager $asset_manager ) {
		// Load admin style sheet and JavaScript.
		$assets = $this->enqueue_admin_styles();

		if ( !empty( $assets ) ) {
			foreach ( $assets as $asset ) {
				$asset_manager->register( $asset );
			}
		}

		$assets = $this->enqueue_admin_scripts();

		if ( !empty( $assets ) ) {
			foreach ( $assets as $asset ) {
				$asset_manager->register( $asset );
			}
		}

		

	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function enqueue_admin_styles() {
		$admin_page = \get_current_screen();
		$styles     = array();

		if ( !\is_null( $admin_page ) && 'toplevel_page_contact-form-app' === $admin_page->id ) {
			$styles[0] = new Style( CFA_TEXTDOMAIN . '-settings-style', \plugins_url( 'assets/build/plugin-settings.css', CFA_PLUGIN_ABSOLUTE ) );
			$styles[0]->forLocation( Asset::BACKEND )->withVersion( CFA_VERSION );
			$styles[0]->withDependencies( 'dashicons' );
		}

		$styles[1] = new Style( CFA_TEXTDOMAIN . '-admin-style', \plugins_url( 'assets/build/plugin-admin.css', CFA_PLUGIN_ABSOLUTE ) );
		$styles[1]->forLocation( Asset::BACKEND )->withVersion( CFA_VERSION );
		$styles[1]->withDependencies( 'dashicons' );
        
		$styles[2] = new Style(
			CFA_TEXTDOMAIN . '-block-editor-style',
			\plugins_url('assets/build/plugin-block.css', CFA_PLUGIN_ABSOLUTE)
		);
		$styles[2]->forLocation(Asset::BACKEND)
				->withVersion(CFA_VERSION)
				->withDependencies('wp-edit-blocks'); // Important dependency for block editor

		return $styles;
	}
    
	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function enqueue_admin_scripts() {
		$admin_page = \get_current_screen();
		$scripts    = array();

		if ( !\is_null( $admin_page ) && 'toplevel_page_contact-form-app' === $admin_page->id ) {
			$scripts[0] = new Script( CFA_TEXTDOMAIN . '-settings-script', \plugins_url( 'assets/build/plugin-settings.js', CFA_PLUGIN_ABSOLUTE ) );
			$scripts[0]->forLocation( Asset::BACKEND )->withVersion( CFA_VERSION );
			$scripts[0]->withDependencies( 'jquery-ui-tabs' );
			$scripts[0]->canEnqueue(
				function() {
					return \current_user_can( 'manage_options' );
				}
			);
		}
        
		
		$scripts[1] = new Script( CFA_TEXTDOMAIN . '-settings-admin', \plugins_url( 'assets/build/plugin-admin.js', CFA_PLUGIN_ABSOLUTE ) );
		$scripts[1]->forLocation( Asset::BACKEND )->withVersion( CFA_VERSION );
		$scripts[1]->dependencies();

		$is_block_editor = $admin_page && method_exists($admin_page, 'is_block_editor') && $admin_page->is_block_editor();
		if ($is_block_editor) {
			
			$block_script = new Script(
				CFA_TEXTDOMAIN . '-block-editor-script',
				\plugins_url('assets/build/plugin-block.js', CFA_PLUGIN_ABSOLUTE)
			);
			$block_script->forLocation(Asset::BACKEND)
				->withVersion(CFA_VERSION);
			$block_script->withDependencies('wp-blocks')
            ->withDependencies('wp-element')
            ->withDependencies('wp-editor')
            ->withDependencies('wp-components')
            ->withDependencies('wp-i18n')
            ->withDependencies('wp-api-fetch');

			
			$block_script->canEnqueue(function() {
				return \current_user_can('edit_posts');
			});
			$scripts[] = $block_script;
		}
		return $scripts;
	}
    

	/**
	 * Attaches translations and other data to the block editor script.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function attach_block_editor_data() {
		$screen = \get_current_screen();

		// Make sure we're in the block editor
		if ($screen && $screen->is_block_editor()) {

			// THIS IS THE CORRECT WAY FOR MODERN BLOCK TRANSLATIONS
			// Make sure this is called after the script is enqueued.
			// The hook priority (19) in add_action is important for this.
			if (function_exists('wp_set_script_translations')) {
				wp_set_script_translations(
					CFA_TEXTDOMAIN . '-block-editor-script', // Use the handle you registered with Inpsyde
					'contact-form-app',
					CFA_PLUGIN_ROOT . 'languages'
				);
			}

			// Keep localize for NON-translation data, such as hCaptcha settings
			$options = \get_option(CFA_TEXTDOMAIN . '-settings');
			$hcaptcha_site_key = $options[CFA_TEXTDOMAIN . '_hcaptcha_site_key'] ?? false;
			$hcaptcha_secret_key = $options[CFA_TEXTDOMAIN . '_hcaptcha_secret_key'] ?? false;
			$hcaptcha_enabled = $hcaptcha_site_key && $hcaptcha_secret_key;

			wp_localize_script(
				CFA_TEXTDOMAIN . '-block-editor-script', // Still use the correct handle
				'cfaBlockhCaptcha',
				[
					'hCaptchaEnabled' => $hcaptcha_enabled,
					'hCaptchaSiteKey' => $hcaptcha_site_key
				]
			);

			
		}
	}
}
