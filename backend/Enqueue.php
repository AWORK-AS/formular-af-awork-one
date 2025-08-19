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

		\add_action( AssetManager::ACTION_SETUP, array( $this, 'enqueue_assets' ) );
		\add_action('admin_enqueue_scripts', [$this, 'localize_block_editor_script'], 20);
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
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function localize_block_editor_script() {
    	$screen = \get_current_screen();
    
		if ($screen && $screen->is_block_editor()) {
			$translations = [
				'headline' => __('Get in Touch With Us', 'contact-form-app'),
				'headlineColor' => __('Headline Color', 'contact-form-app'),
				'enterHeadline' => __('Enter form headline...', 'contact-form-app'),
				'name' => __('Name', 'contact-form-app'),
				'company' => __('Company', 'contact-form-app'),
				'email' => __('Email', 'contact-form-app'),
				'phone' => __('Phone', 'contact-form-app'),
				'message' => __('Message', 'contact-form-app'),
				'submit' => __('Submit', 'contact-form-app'),
				'formSettings' => __('Form Settings', 'contact-form-app'),
				'btnColor' => __('Button Color', 'contact-form-app'),
				'btnTextColor' => __('Button Text Color', 'contact-form-app'),
			];
			wp_localize_script(
				CFA_TEXTDOMAIN . '-block-editor-script',
				'cfaBlockTranslations',
				$translations
			);
		}
	}
}
