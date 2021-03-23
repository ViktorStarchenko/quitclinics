=== Cloudcheck Integration ===
Contributors: eurohlam, gvadalahara
Tags: cloudcheck, integration, identification verification
Requires at least: 4.9
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integration with cloudcheck service for electronic identification verification. Only for New Zealand and Australia

== Description ==

Wordpress plugin for integration with Cloudcheck service for electronic identification verification. Only for New Zealand and Australia
www.verifidentity.com/cloudcheck.
Using this plugin you can create a page with form that contains a number of fields required for identification verification,
send request to www.verifidentity.com/cloudcheck service and get resulted report in PDF format. The resulted report will be send by email as well.



== Configuration ==

* Firstly, you have to contact to Cloudcheck service team to get permissions to use the service.
If it's done, you have to configure the plugin and set cloudcheck endpoint and credentials.
Navigate to Settings -> Cloudcheck Integration and fill the following fields:
	Cloudcheck URL - by default it is https://api.cloudcheck.co.nz, unless you are going to use custom URL https://<companyname>.cloudcheck.co.nz
	Cloudcheck Access Key - uniquie access key that has to be provided by www.verifidentity.com
	Cloudcheck Secret Key - uniquie secret key that has to be provided by www.verifidentity.com

* Secondly, you have to create a page that will be showing Cloudcheck form. The form must be added into page via predefined shortcodes like below:
[cloudcheck_main_form]
	[cloudcheck_basic_info]
	[cloudcheck_nz_passport]
	[cloudcheck_nz_driving_license]
	[cloudcheck_emails]
[/cloudcheck_main_form]

To run the integration your page must include at least the minimal structure of the following shortcodes:
[cloudcheck_main_form]
	[cloudcheck_basic_info]
	[cloudcheck_emails]
[/cloudcheck_main_form]

Other shortcodes are optional and different for New Zealand and Australia.

You are free to customize view of the page using basic html. We are using bootstrap 4 in our forms. Bootstrap 4 styles and scripts are imported as part of the plugin.
So, you can combine html with bootstrap styles.
Example of customized view:

[cloudcheck_main_form]
	<h2>Identification Verification</h2>
	<hr>
	[cloudcheck_basic_info]
	[cloudcheck_emails]

	<h2>Verification for Australia</h2>
	<hr>
    [cloudcheck_au_driving_license]
	[cloudcheck_au_citizenship]
	[cloudcheck_au_passport]
	[cloudcheck_au_visa]
	[cloudcheck_au_immicard]

	<h2>Verification for New Zealand</h2>
	<hr>
    [cloudcheck_nz_passport]
	[cloudcheck_nz_driving_license]
	[cloudcheck_nz_citizenship]
	[cloudcheck_nz_birth_certificate]
	[cloudcheck_nz_vehicle_plate_number]

[/cloudcheck_main_form]

Important Note: Since identification verification operates with sensible information, it is not allowed to run verification for users that are not logged in.
Even if form page is accessible for not logged-in users, verification will not work anyway and plugin will return error 400 Bad request.



== Shortcodes ==

The basic shortcodes:
	[cloudcheck_main_form] - Enclosing main shortcode that shows the main container form. All other shortcodes must be placed inside this one.
	[cloudcheck_basic_info] - Shortcode that shows basic fields always required for verification: first name, middle name, surname, address
	[cloudcheck_emails] - Shortcode that shows email fields: Client email, Agent email, Administrator email. Report will be send to those emails

The list of available shortcodes for verfication in New Zealand:
	[cloudcheck_nz_passport] - Shortcode that shows fields for verification by NZ passport: passport number, passport expiry
	[cloudcheck_nz_driving_license] - Shortcode that shows fields for verification by NZ driving license via NZTA: driving license number, driving llicense version
	[cloudcheck_nz_citizenship] - Shortcode that shows fields for verification by NZ birth certificate: birthcertificate
	[cloudcheck_nz_birth_certificate] - Shortcode that shows fields for verification by NZ citizenship: certificatenumber, countryofbirth
	[cloudcheck_nz_vehicle_plate_number] - Shortcode that shows fields for verification by vehicle plate number via NZTA: vehicle number plate

The list of available shortcodes for verfication in Australia:
	[cloudcheck_au_driving_license] - Shortcode that shows fields for verification by Australian driving license: state of issue, driving license number
	[cloudcheck_au_citizenship] - Shortcode that shows fields for verification by Australian citizenship:acquisition date, citizenship by descent, stock number
	[cloudcheck_au_passport] - Shortcode that shows fields for verification by Australian passport: passport number, passport gender
	[cloudcheck_au_visa] - Shortcode that shows fields for verification by Australian Visa: Country of Issue, Passport Number
	[cloudcheck_au_immicard] - Shortcode that shows fields for verification by Australian ImmiCard: immicard number





== Verification Data History ==

The plugin keeps all requests-responses to Cloudcheck service in database table with name $prefix_cc_message_log.
All resulted PDF files are stored in folder wp-content/uploads/cloudcheck_int.




== Changelog ==

1.0.0
* Pilot version
