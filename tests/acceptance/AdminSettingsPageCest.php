<?php
class AdminSettingsPageCest {
	function _before(AcceptanceTester $I) {
		// will be executed at the beginning of each test
		$I->loginAsAdmin();
		$I->am('administrator');
	}

	function add_plugin_admin_menu(AcceptanceTester $I) {
		$I->wantTo('access to the plugin settings page as admin');
		$I->amOnPage('/wp-admin/admin.php?page=formularer-for-awork-one');
		$I->see('Formularer for AWORK One Settings', 'h2');
	}

	function add_action_link(AcceptanceTester $I) {
		$I->wantTo('check plugin list page if include mine');
		$I->amOnPluginsPage();
		$I->see('Formularer for AWORK One', 'tr.active[data-plugin="formularer-for-awork-one/formularer-for-awork-one.php"] td strong');
	}

}
