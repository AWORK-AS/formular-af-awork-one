=== Formular af CitizenOne journalsystem ===
Contributors: mzc74b331b9fdbc
Tags: contacts, leads, citizenone, kontaktformular
Requires at least: 5.8
Tested up to: 6.8
Stable tag: 1.0.0
License: GPLv3+
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 7.4

Integrer tilpasselige kontaktformularer fra CitizenOne på enhver WordPress-side. Fang leads direkte ind i dit CitizenOne-dashboard med realtidsnotifikationer.

== Beskrivelse ==

* Tilpasselige indlejringsformularer med farvetilpasning
* Realtids lead-indsendelse til CitizenOne-dashboard
* Gutenberg-blokimplementering
* "Formular af CitizenOne - Journalsystem med alt inklusiv" branding
* Mobilvenligt responsivt design

== Installation ==

= Upload i WordPress Dashboard =

1. Gå til 'Tilføj nye' i plugin-dashboardet
2. Gå til 'Upload'-området
3. Vælg `formular-af-citizenone-journalsystem.zip` fra din computer
4. Klik på 'Installer nu'
5. Aktiver pluginet i Plugin-dashboardet

= Via FTP =

1. Download `formular-af-citizenone-journalsystem.zip`
2. Udpak `formular-af-citizenone-journalsystem`-mappen til din computer
3. Upload `formular-af-citizenone-journalsystem`-mappen til `/wp-content/plugins/`-mappen
4. Aktiver pluginet i Plugin-dashboardet

= Efter installation =

1. Gå til CitizenOne Formular-indstillinger under 'Indstillinger'
2. Konfigurer dine formularindstillinger
3. Tilføj formularblokken til din side via Gutenberg-editor

== Ofte Stillede Spørgsmål ==

= Hvordan aktiverer jeg hCaptcha? =
For at hCaptcha skal virke, skal du tilføje din **Secret Key** og **Site Key** fra hCaptcha i Admin-indstillingerne.
**Vigtigt**: Hvis du allerede havde en **Contact Form**-blok på din webside før du tilføjede hCaptcha-nøglerne, skal du erstatte den med en ny for at indstillingerne træder i kraft.

= Kan jeg tilpasse formularfelter? =
Ja! Rediger feltetiketter i plugin-indstillinger. Yderligere felter kræver konfiguration i CitizenOne-dashboardet.

= Hvordan vises leads i CitizenOne? =
Alle indsendelser vises i dit dashboard > Leads-sektion med tidsstempel, kilde-URL og kontaktoplysninger.

= Understøtter formularerne dansk sprog? =
Ja, formularerne er fuldt oversat til dansk og andre sprog.

== Screenshots ==
1. Contact Form App Setup
2. Gutenberg block interface
3. Example embedded form on frontend

== Oversættelse ==
Dette plugin er klar til oversættelse med .pot-fil inkluderet i mappen /languages/.

== Ændringslog ==
= 1.0.0 =
* Første release med kernefunktionalitet
* Gutenberg-blokunderstøttelse
* Indstillinger-dashboard
* Dansk oversættelse inkluderet
