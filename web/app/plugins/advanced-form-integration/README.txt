=== Connect Contact Form 7, WooCommerce To Google Sheets & Other Platforms  - Advanced Form Integration ===
Contributors: nasirahmed, freemius
Tags: contact form 7, cf7, woocommerce, google sheet, google sheets, Pipedrive, active campaign, AWeber, campaign monitor, clinchpad, close.io, convertkit, curated, directiq, drip, emailoctopus, freshsales, getresponse, google sheets, jumplead, klaviyo, liondesk, mailerlite, mailify, mailjet, moonmail, moosend, omnisend, revue, Sendinblue
Requires at least: 3.0.1
Tested up to: 5.7
Stable tag: 5.7
Requires PHP: 5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send Contact Form 7 submission & WooCommerce order data to other 30+ platforms.

== DESCRIPTION ==

Connect Contact Form 7 & WooCommerce to 30+ other platforms. It works like when a form is submitted to your website, the plugin will automatically create a new row in Google Sheets, subscribe to a mailing list in Sendinblue, Mailchimp, Klaviyo, etc. Similarly, it allows to send WooCommerce order data.

* **Easy to use**: The plugin was created, keeping not-tech people in mind. New integrations can be set up in a few minutes. No coding skill is required, almost no learning curve.

* **Flexible**: Integrations can be created from any sender platform to any receiver platform. You can create as many connections as you want—single sender to multiple receivers, multiple senders to a single receiver, multiple senders to multiple receivers. Just keep in mind that all PHP server has a maximum execution time allowed.

* **Conditional Logic**: You can create single or multiple conditional logic to filter the data flow. Submitted data will only be sent if the conditions match. For example, when you want to send contact data only if the user has agreed and filed the checkbox "I agree" (Contact Form 7 acceptance field) or if the city is only New York or the subject contacts the word "Lead," etc. You can set up the conditions as you like.

* **Special Tags**: We have introduced several special tags that can be passed to receiver platforms. These are helpful when you want some more information that the user submitted, like IP address, user agent, etc. Example: `{{_date}}` same format and timezone that is saved in WordPress settings, `{{_time}}` same format and timezone that is saved in WordPress settings, `{{_weekday}}` weekday like Monday, Tuesday, etc., `{{_user_ip}}`, `{{_user_agent}}`, `{{_site_title}}`, `{{_site_description}}`, `{{_site_url}}`, `{{_site_admin_email}}`, `{{_post_id}}`, `{{_post_name}}`, `{{_post_title}}`, `{{_post_url}}`, `{{_user_id}}`, `{{_user_first_name}}`, `{{_user_last_name}}`, `{{_user_last_name}}`, `{{_user_email}}`.

* **Multisite**: Multisite supported.

[youtube https://youtu.be/iU0YmEks84Q]

[**[Website](https://advancedformintegration.com/)**]   [**[Documentation](https://advancedformintegration.com/docs/)**]   [**[Tutorial Videos](https://www.youtube.com/channel/UCyl43pLFvAi6JOMV-eMJUbA)**] [**[Comparison](https://advancedformintegration.com/pricing/)**]

### SENDER PLATFORMS (TRIGGER) ###

The following plugins work as a sender platform.

*  **[Contact Form 7](https://wordpress.org/plugins/contact-form-7/)**: Any contact form created using Contact Form 7 can be integrated. So when a user submits the form, data will be sent to connected platforms.

*  **[WooCommerce](https://wordpress.org/plugins/contact-form-7/)**: When a new order is placed or order status is processing/on-hold/completed/failed/pending/refunded/canceled in a WooCommerce shop, the order data can be sent to connected platforms. The following are the regular fields that the plugin allows to send by default:
Order ID, Parent ID, User ID, Billing First Name, Billing Last Name, Formatted Billing Full Name, Billing Company, Billing Address 1, Billing Address 2, Billing City, Billing State, Billing Postcode, Billing Country, Billing Email, Billing Phone, Formatted Billing Address, Shipping First Name, Shipping Last Name, Shipping Full Name, Shipping Company, Shipping Address 1, Shipping Address 2, Shipping City, Shipping State, Shipping Postcode, Shipping Country, Shipping Email, Shipping Phone, Formatted Shipping Address, Shipping Address Map URL, Payment Method, Payment Method Title, Transaction ID, Order Created Via, Date Completed, Date Created, Date Modified, Date Paid, Cart Hash, Currency, Customer ID, Customer IP Address, Customer User Agent, Customer Note, Total, Formatted Order Total, Order Item Total, Prices Include Tax, Discount Total, Discount Tax, Shipping Total, Shipping Tax, Cart Tax, Total Tax, Total Discount, Subtotal, Tax Totals, Items Full JSON, Line Item(s) ID, Line Item(s) Name, Line Item(s) SKU, Line Item(s) Variation ID, Line Item(s) Quantity, Line Item(s) Total, Line Item(s) Price, Line Item(s) Sale Price, Line Item(s) Regular Price, Line Item(s) Subtotal, Line Item(s) Subtotal Tax, Line Item(s) Subtotal With Tax, Line Item(s) Total Tax, Line Item(s) Total With Tax, Line Item(s) Number In Cart, Line Item(s) Attributes, Taxes, Shipping Methods, Shipping Method, Coupons Applied and Coupons Amount Total.

 In addition to regular fields, you can also use WooCommerce custom order fields. For example, to send fields created by the [Checkout Field Editor](https://wordpress.org/plugins/woo-checkout-field-editor-pro/) plugin,  you have to add the input field name value manually as a tag. For example, in the checkout page, you’ve added an extra field for Interests and its name value is “interests”, then add a tag {{interests}} while creating the integration. The plugin should parse the value from user input and send it to the connected platform field. 

<blockquote>
<p><strong>Premium Version Features.</strong></p>
<p>Following sender forms are supported in the premium version.</p>
<ul>
<li><a href="https://www.gravityforms.com/">Gravity Forms</a></li>
<li><a href="https://elementor.com/widgets/form-widget/">Elementor Pro Form</a></li>
<li><a href="https://wordpress.org/plugins/ninja-forms/">Ninja Forms</a></li>
<li><a href="https://wordpress.org/plugins/wpforms-lite/">WPForms</a></li>
<li><a href="https://wordpress.org/plugins/formidable/">Formidable Forms</a></li>
<li><a href="https://wordpress.org/plugins/fluentform/">WP Fluent Forms</a></li>
<li><a href="https://wordpress.org/plugins/caldera-forms/">Caldera Forms</a></li>
<li><a href="https://wordpress.org/plugins/weforms/">weForms</a></li>
<li><a href="https://wordpress.org/plugins/everest-forms/">Everest Forms</a></li>
<li><a href="https://wordpress.org/plugins/smart-forms/">Smart Forms</a></li>
<li><a href="https://wordpress.org/plugins/formcraft-form-builder/">FormCraft</a></li>
<li><a href="https://wordpress.org/plugins/forminator/">Forminator</a></li>
<li><a href="https://wordpress.org/plugins/happyforms/">Happy Forms</a></li>
<li><a href="https://wordpress.org/plugins/planso-forms/">Planso Forms</a></li>
<li>Inbound Webhooks</li>
</ul>
</blockquote>

### RECEIVER PLATFORMS (ACTION) ###

*  **[ActiveCampaign](https://www.activecampaign.com/)** - ActiveCampaign is a popular email marketing and automation platform. This plugin allows you to integrate it with any sender platform, so when a user submits the form with personal details, it will automatically create a contact in ActiveCampaign. The contact can be added to a list or automation. Additionally, deals and notes can be created, too, for that contact. Requires a pro license to use custom fields.

*  **[Agile CRM](https://www.agilecrm.com/)** - This plugin allows creating contact, deal and note. Requires a pro license to use tags and custom fields.

*  **[Autopilot](https://www.autopilothq.com/)** - This plugin allows creating/updating contact and adding to a list. Requires a pro license to use custom fields.

*  **[AWeber](https://www.aweber.com/)** - Allows to create contact and subscribe to a list. Pro license is required to use custom fields and tags.

*  **[Campaign Monitor](https://www.campaignmonitor.com/)** - Allows to create contact and subscribe to list. Pro license is required to use custom fields.

*  **[ClinchPad CRM](https://clinchpad.com/)** - Simpler than a traditional CRM. This plugin allows creating new contact in Clinchpad when a form is submitted.

*  **[Close CRM](https://close.com/)** - Close is the inside sales CRM of choice for startups and SMBs. You can add a new lead to Close CRM.

*  **[ConvertKit](https://convertkit.com/)** - ConvetKit is another popular email marketing software. This plugin allows you to create a new contact and subscribe to a sequence. Pro license is required to use custom fields and tags.

*  **[Copper CRM](https://www.copper.com/)** - Allows you to create a new contact in Copper CRM.

*  **[Curated](https://curated.co/)** - Add subscriber.

*  **[DirectIQ](https://www.directiq.com/)** - Allows you to create contact and add to the mailing list.

*  **[Drip](https://www.drip.com/)** - Drip is a marketing automation platform built for eCommerce - utilizing email, SMS, etc. This plugin allows you to create subscribers.

*  **[Elastic Email](https://elasticemail.com/)** - Elastic Email is a marketing platform built on the most cost-effective delivery engine. You can create a contact and add it to a mailing list. Pro license is required to use custom fields.

*  **[EmailOctopus](https://emailoctopus.com/)** - Allows you to add contact and subscribe to a list.

*  **[EverWebinar](https://home.everwebinar.com/index)** - Add registrant to webinar.

*  **[Freshsales](https://www.freshworks.com/freshsales-crm/)** - Freshsales is a full-fledged Sales CRM software for your business. This plugin allows for creating contacts and leads.

*  **[GetResponse](https://www.getresponse.com/)** - GetResponse is a powerful, simplified tool to send emails, create pages, and automate your marketing. This plugin allows you to create a subscriber and add it to the mailing list The Pro version supports custom fields and tags.

*  **[Google Sheets](https://seheets.google.com)** - When a sender form is submitted, or a WooCommerce order is created, this plugin allows you to create a new row on a selected sheet with supplied data. In the Pro version, it is allowed to create separate rows for WooCommerce Order Items. For example, if an order has 5 items so 5 separate rows will be created for each item.

*  **[Hubspot CRM](https://www.hubspot.com/)** - Allows you to create new contact in Hubspot CRM with additional custom fields support.

*  **[Insightly](https://www.insightly.com/)** - Insightly CRM is another powerful CRM. Using the Advanced Form Integration plugin, you can create a new contact on it.

*  **[Jumplead](https://jumplead.com/)** - Jumplead offers a full all-in-one inbound marketing automation platform. This plugin allows adding a contact on it.

*  **[Klaviyo](https://www.klaviyo.com/)** - Klaviyo is an email marketing platform created for online businesses — featuring powerful email and SMS marketing automation. Using Advanced Form Integration, you can add a contact, subscribe to a list. Pro license is required to use custom properties.

*  **[lemlist](https://lemlist.com/)** - A cold email tool powering sales teams, agencies, and B2B businesses to personalize and automate outreach campaigns. This plugin allows creating contact and adds it to a campaign.

*  **[LionDesk](https://www.liondesk.com/)** - LionDesk offers sales and marketing automation for Real Estate Agents and Brokers. Creating a new contact is supported using our plugin.

*  **[Mailchimp](https://mailchimp.com/)** - Mailchimp is the All-In-One integrated marketing platform for small businesses, to grow your business on your terms. This plugin allows you to create contacts, subscribe to a list, and unsubscribe from the list. Requires Pro license to use Custom|Merge fields, tags.

*  **[MailerLite](https://www.mailerlite.com/)** - MailierLite offers to create advanced email marketing campaigns with features like automation, landing pages, and surveys. Using this plugin, you can add contact and subscribe to a group. Requires a Pro license to use custom fields.

*  **[Mailify](https://www.mailify.com/)** - Mailify is a email marketing solution. Our plugin allows you to create contacts and subscribe to lists.

*  **[Mailjet](https://www.mailjet.com/)** - Allows you to create a contact and add it to a list.

*  **[Moonmail](https://www.moonmail.io/)** - Allows you to create a contact and add it to a list.

*  **[Moosend](https://moosend.com/)** - Allows you to create a contact and add it to a list. Requires a Pro license to use custom fields.

*  **[Omnisend](https://www.omnisend.com/)** - Omnisend is the eCommerce marketing automation platform built for growing eCommerce businesses. Our plugin allows you to create new contacts. Requires pro license to use custom fields.

*  **[Pabbly Email Marketing](https://www.pabbly.com//)** - Allows you to create a subscriber and add it to a list. Requires a Pro license to use custom fields.

*  **[Pipedrive](https://www.pipedrive.com/)** - Pipedrive is the easy-to-use, #1 user-rated CRM tool. This plugin allows you to create organizations, people, deals, notes, activity with custom fields support.

*  **[Pushover](https://pushover.net/)** - Allows you to send push messages to Android/iOS/Desktop.

*  **[Revue](https://www.getrevue.co/)** - Allows you to create subscriber.

*  **[SendFox](https://sendfox.com/)** - Allows you to create contact and subscribe to a list.

*  **[SendPulse](https://sendpulse.com/)** - Allows you to create contact and subscribe to a list.

*  **[Sendinblue](https://www.sendinblue.com/)** - Sendinblue is a complete all-in-one digital marketing toolbox. Our plugin allows you to create subscribers and add to a list. Pro license is required to use custom fields and other languages.

*  **[Sendy](https://sendy.co/)** - Allows creating contact and subscribe to a list. Pro license is required to use custom fields.

*  **[Smartsheet](https://smartsheet.com/)** - Allows creating new row.

*  **[Trello](https://www.trello.com/)** - This plugin allows you to create new card in Trello.

*  **[Twilio](https://www.twilio.com/)** - This plugin allows you to send customized SMS using Twilio.

*  **Webhook** - Allows you to send data to any webhook URL. In the Pro version, you can send fully customized headers and body (GET, POST, PUT, DELETE), literally can send data to any API with API token and Basic auth.

*  **[WebinarJam](https://home.webinarjam.com/index)** - Add registrant to webinar.

*  **[Woodpecker.co](https://woodpecker.co/)** - Allows creating subscriber. Requires Pro license to use custom fields.

*  **[Zapier](https://zapier.com/)** - Sends data to Zapier webhook.

### WHY I CREATED THIS PLUGIN ###

*I was using a popular form plugin on my website for new registrations. I built several integrations with CRM, email marketing soft, Google Sheets, etc. The form had add-ons for those. Then I found another form with more features but less expensive, so I decided to migrate. Here comes the challenge. The new form didn't have native add-ons to integrate all the platforms I was using. So I created a few of my own and thought it could help others If I can create a universal plugin that connects all popular forms and 3rd party platforms. This plugin is built to add new sender and receiver platforms, so the opportunity has no bound. I'm adding new platforms regularly. Currently, Contact Form 7 and WooCommerce are supported free and need a pro license for others.*

### SOME VIDEOS ON HOW TO USE THE PLUGIN ###

= Create Google API project =
[youtube https://youtu.be/VJIHgJkyyCM]

= Connect Contact Form 7 to google sheets =
[youtube https://youtu.be/-xTMz58j00k]

= Connect woocommerce new order to google sheets =
[youtube https://youtu.be/zDGNSuqYHA4]

= Connect Contact Form 7 to Agile CRM =
[youtube https://youtu.be/7QU5gt0Rpps]

= Connect Contact Form 7 to ActiveCampaign =
[youtube https://youtu.be/3bOpbDdJuQw]

= Connect Contact Form 7 to Campaign Monitor =
[youtube https://youtu.be/d60Z25oq0ns]

= Connect Contact Form 7 to ConvertKit =
[youtube https://youtu.be/JbwsWIHb7cw]

= Connect Contact Form 7 to Elastic Email =
[youtube https://youtu.be/r8pPAXuJMWw]

= Connect Contact Form 7 to EmailOctopus =
[youtube https://youtu.be/CY29B1JDhZg]

= Connect Contact Form 7 to GetResponse =
[youtube https://youtu.be/znDFRLHHwF0&t]

= Connect Contact Form 7 to Klaviyo =
[youtube https://www.youtu.be/PMMAGlc9kd0]

= Connect Contact Form 7 to Mailify =
[youtube https://www.youtu.be/OXeUy3XtJXc]

= Connect Contact Form 7 to Sendinblue =
[youtube https://www.youtu.be/9XG4ATtwWq0]

= Connect Contact Form 7 to lemlist =
[youtube https://www.youtu.be/y6GMtaY0kE0]

= Connect Contact Form 7 to SendFox =
[youtube https://www.youtu.be/8xvxa5zvIf8]

= Connect Contact Form 7 to Mailchimp =
[youtube https://www.youtu.be/0SgWjwQuMYo]

= Connect Contact Form 7 to LionDesk CRM =
[youtube https://www.youtu.be/adKZdY4rn4k]

= Connect Contact Form 7 to Omnisend =
[youtube https://www.youtu.be/dHm6W17K6j4]


== Installation ==
###Automatic Install From WordPress Dashboard

1. log in to your admin panel
2. Navigate to Plugins -> Add New
3. Search **Advanced Form Integration**
4. Click install and then active.

###Manual Install

1. Download the plugin by clicking on the **Download** button above. A ZIP file will be downloaded.
2. Login to your site’s admin panel and navigate to Plugins -> Add New -> Upload.
3. Click choose file, select the plugin file and click install

== Frequently Asked Questions ==

= Why I can't see Contact Form 7 in the dropdown list? =

Make sure that Contact Form 7 is installed and activated.

= Connection error, how can I re-authorize Google Sheets? =

If authorization is broken/not working for some reason, try re-authorizing. Please go to https://myaccount.google.com/permissions, remove app permission then authorize again from plugin settings.

= Getting "The requested URL was not found on this server" error while authorizing Google Sheets =

Please check the permalink settings in WordPress. Go to Settings > Permalinks > select Post name then Save.

= Do I need to map all fields while creating integration? =

No, but required fields must be mapped.

= Can I add additional text while filed mapping?

Sure, you can. It is possible to mix static text and form field placeholder tags. Placeholder tags will be replaced with original data after form submission.

= How can I get support? =

For any query, feel free to send an email to support@advancedformintegration.com.

== Screenshots ==

1. All integrations list
2. Settings page
3. New integration page
3. Conditional logics

== Changelog ==

= 1.37.2 [2021-04-08] =
* [Updated] GetResponse integration

= 1.37.1 [2021-03-30] =
* [Fixed] Pipedrive integration

= 1.37.0 [2021-03-29] =
* [Added] SendPulse support (Subscribe to email list)
* [Added] Trello support (Creat Card)

= 1.36.3 [2021-03-17] =
* [Fixed] CF7 id deprecated notice
* [Fixed] CF7 form submission

= 1.36.2 [2021-03-09] =
* [Added] Disable log checkbox in general settings
* [Fixed] lemlist integration issue
* [Fixed] Sendinblue update issue

= 1.36.1 [2021-02-24] =
* [Added] WooCommerce new fields
* [Fixed] FireFox submission issue
* [Fixed] Google Sheets integration issue
* [Updated] Some notifications

= 1.36.0 [2021-02-10] =
* Hubspot CRM (add new contact) support added

= 1.35.1 [2021-02-03] =
* Updated WooCommerce fields
* Updated Pipedrive integration

= 1.35.0 [2021-01-25] =
* Smartsheet (add new row) support added

= 1.34.0 [2021-01-08] =
* Pabbly Email Marketing (add contact) support added

= 1.33.1 [2020-12-16] =
* Autopilot (add/update contact) support added

= 1.33.0 [2020-12-02] =
* Autopilot (add/update contact) support added

= 1.32.3 [2020-11-16] =
* Mailchimp - user can now activate double opt-in

= 1.32.1 [2020-11-08] =
* Improved Omnisend integration

= 1.32.0 [2020-11-06] =
* Added Multisite support

= 1.31.3 [2020-10-23] =
* Improved LionDesk integration

= 1.31.2 [2020-10-23] =
* Fixed few bugs

= 1.31.1 [2020-10-21] =
* Fixed Sendinblue FIRSTNAME, LASTNAME issue on other languages

= 1.31.0 [2020-10-20] =
* Added special tags support

= 1.30.0 [2020-10-06] =
* Added lemlist support
* Temporarily disabled Kartra integration

= 1.29.4 [2020-10-04] =
* Updated Woocommerce Order fields

= 1.29.3 [2020-09-29] =
* Fixed bugs and updated triggers for WooCommerce

= 1.29.2 [2020-09-23] =
* Fixed Omnisend SMS subscription issue

= 1.29.1 [2020-09-19] =
* Updated WP REST API call
* Updated ActiveCampaign featues

= 1.29.0 [2020-08-29] =
* Added Pushover support

= 1.28.0 [2020-08-21] =
* Added Agile CRM support

= 1.27.0 [2020-07-17] =
* Added Twilio (Send SMS) support

= 1.26.4 [2020-07-17] =
* Updated Klaviyo API endpoint

= 1.26.3 [2020-07-15] =
* Fixed Contact Form 7 connection issue

= 1.26.1 [2020-06-20] =
* Fixed EverWebinar/WebinarJam field issue
* Fixed Sendinble list limits from 10 items

= 1.26.0 [2020-06-19] =
* Added WooCommerce New Order support
* Improve admin js loading

= 1.25.2 [2020-06-11] =
* Fixed log pagination

= 1.25.1 [2020-06-06] =
* Fixed EmailOctopus double opt-in

= 1.25.0 [2020-06-03] =
* Added Kartra support

= 1.24.0 [2020-05-30] =
* Added conditional logics - acceptance field check, etc.

= 1.23.1 [2020-05-28] =
* Fixed checkbox issue

= 1.23.0 [2020-05-27] =
* WebinarJam / EverWebinar support added

= 1.22.3 =
* Sendinblue update contact

= 1.22.2 =
* Changed Google Sheets authentication process

= 1.22.1 =
* LOG view improved

= 1.22.0 =
* Added SendFox support

= 1.21.2 =
* Fixed warnings

= 1.21.1 =
* Fixed Klaviyo subscribe issue

= 1.21.0 =
* Woodpecker.co support added

= 1.20.0 =
* ActiveCampaign support added

= 1.19.0 =
* Elastic Email support added

= 1.18.3 =
* Updated Sendinblue API to V3 and fixed FIRSTNAME, LASTNAME field issue

= 1.18.2 =
* Fixed Bugs

= 1.18.1 =
* Fixed Omnisend create contact issue

= 1.18.0 =
* Added Sendy support

= 1.17.0 =
* Added Jumplead support

= 1.16.0 =
* Added Omnisend support
* Added DirectIQ support

= 1.15.0 =
* Added Mailify support

= 1.14.0 =
* Added Moosend support

= 1.13.0 =
* Added MailerLite support

= 1.12.0 =
* Added Aweber support

= 1.11.0 =
* Added Curated support

= 1.10.0 =
* Added EmailOctopus support

= 1.9.0 =
* Added Close CRM support

= 1.8.1 =
* Fixed Google Sheet fetching header issue for a single worksheet

= 1.8.0 =
* Added LionDesk support

= 1.7.0 =
* Added Google Sheets support

= 1.6.0 =
* Added ClinchPad CRM support

= 1.5.0 =
* Added Moonmail support

= 1.4.0 =
* Mappings fields are now editable
* Added Campaign Monitor support
* Added log page

= 1.3.0 =
* Added Drip support

= 1.2.0 =
* Added Freshsales support

= 1.0.1 =
* Fixed Copper, Insightly & Pipedrive issues.

= 1.0.0 =
* First public release.