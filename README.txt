=== Formular af CitizenOne journalsystem ===
Contributors: mzc74b331b9fdbc
Tags: contacts, leads, citizenone
Requires at least: 5.8
Tested up to: 6.8
Stable tag: 1.0.3
License: GPLv3+
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 7.4

Embed customizable contact forms from CitizenOne on any WordPress site.
== Description ==

* Customizable embed forms with color matching
* Real-time lead submission to CitizenOne dashboard
* Gutenberg block implementation
* "Formular af CitizenOne - Journalsystem med alt inklusiv" branding
* Mobile-responsive design

== Installation ==


= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `contact-form-app.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `contact-form-app.zip`
2. Extract the `contact-form-app` directory to your computer
3. Upload the `contact-form-app` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= How to Enable hCaptcha? =
For hCaptcha to work, you need to add your **Secret Key** and **Site Key** from hCaptcha into the Admin Settings.
**Important**: If you already had a **Contact Form** block on your web page before adding the hCaptcha keys, you must replace it with a new one for the settings to take effect.


= How do leads appear in CitizenOne? =
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

= 1.0.1 =
* keyword search fixes (failed)

= 1.0.2 = 
* keyword search fixes

= 1.0.3 =
* Unauthorized WordPress plugin files were removed.