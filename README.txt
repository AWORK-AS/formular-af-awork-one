=== Formular af AWORK ONE ===
Contributors: mzaworkdk
Tags: contacts, leads, aworkone
Requires at least: 5.8
Tested up to: 6.8
Stable tag: 1.0.0
License: GPLv3+
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 7.4

Embed customizable contact forms from AWORK ONE on any WordPress site.
== Description ==

* Customizable embed forms with color matching
* Real-time lead submission to AWORK ONE dashboard
* Shortcode & Gutenberg block implementation
* "Formular af AWORK ONE - Journalsystem med alt inklusiv" branding
* Mobile-responsive design

== External Services ==

This plugin utilizes the following third-party services to enhance functionality:

=== hCaptcha ===
* **Purpose**: Optional spam protection for contact forms
* **Data Sent**: User interaction data through hCaptcha's API
* **When**: Only when site administrator has configured hCaptcha keys in plugin settings
* **Terms**: https://hcaptcha.com/terms
* **Privacy Policy**: https://hcaptcha.com/privacy

=== Awork One API ===
* **Purpose**: Processing form submissions and generating authentication tokens
* **Data Sent**: Form submission data (as provided by users) and authentication tokens
* **When**: When users submit forms through the contact form
* **Terms**: https://aworkone.dk/vilkaarogbetingelser/
* **Privacy Policy**: https://aworkone.dk/privatlivspolitik/

== Installation ==


= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `formular-af-awork-one.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `formular-af-awork-one.zip`
2. Extract the `formular-af-awork-one` directory to your computer
3. Upload the `formular-af-awork-one` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= How to Enable hCaptcha? =
For hCaptcha to work, you need to add your **Secret Key** and **Site Key** from hCaptcha into the Admin Settings.
**Important**: If you already had a **Contact Form** block on your web page before adding the hCaptcha keys, you must replace it with a new one for the settings to take effect.


= How do leads appear in AWORK ONE? =
All submissions populate in your dashboard > Leads section with timestamp, source URL, and contact details.


== Screenshots ==

1. Contact Form App Setup
2. Gutenberg block interface
3. Example embedded form on frontend


== Changelog ==
= 1.0.0 =
* Initial release with core functionality
* Gutenberg block support
* Settings dashboard
* phpcs --standard=WordPress passed.
* Refactor: Replaced CMB2 dependency with the native WordPress Settings API.
* Refactor: Removed `yahnis-elsts/plugin-update-checker` dependency to use the WordPress.org update system exclusively.
* Refactor: Implemented PHP-Scoper to prefix all third-party dependencies, preventing library conflicts.
* Refactor: Added a Composer autoloader suffix for better isolation.
* Fix: Resolved multiple PHPStan and PHPCS errors related to type safety and output escaping.
* Refactor: Removed unnecessary capabilities.
* Fix: Resolved a JavaScript conflict by using `window.addEventListener` instead of `window.onload`. This prevents form submission failures when another plugin is active on the same page.
* Tweak: Prefixed the REST API callback function to ensure uniqueness and prevent potential conflicts with other plugins.
* Optimization: Frontend assets (CSS/JS) are now loaded conditionally, only on pages where the form block or shortcode is present.
* Optimization: Backend assets are now loaded strictly on the plugin's own settings page, reducing unnecessary load across the WordPress admin area.


