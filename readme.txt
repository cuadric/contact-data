=== Contact Data ===

Plugin Name: Contact Data
Plugin URI: http://www.cuadric.com/plugins/contact-data
Description: Manage all your contact and social information from a single admin page and recover it and render you social buttons through a function or shortcode. 
Tags: Contact information, Contact data, Contact admin page, Social networks
Author URI: http://www.cuadric.com/
Author: Gonzalo Sanchez
Contributors: Gonzalo Sanchez
Donate link: http://www.cuadric.com/plugins/contact-data
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.0
Version: 1.0
License: GPLv2 or later

Manage all your contact and social information from a single admin page.

== Description ==

This plugins adds an admin page in which to store all your contact information such as Company Name, Telephone, Fax, Email, Address, Google Map, ect.
It can also store addresses of the major social networks like Facebook, Twitter, LiknkedIn, Google Plus, YouTube, etc..

All these data can be retrieved by:

* `get_contact_data()` function, you get all your contact fields in an array to use in PHP templates
* `get_contact_data('field_name')` function, retrieve one contact field at a time tu use in PHP templates
* `[contact-data field="field_name"]` shortcode, echoes one contact field at a time to use in the text editor
* `follow_me_icons()` function, render a buttons block of your social networks links from your PHP code
* `[follow-me-icons]` shortcode, render a social networks block in your contents from the text editor

Valid values for the `field_name` parameter:

Contact data fields

* name
* url
* dir
* dir_2
* email
* tel
* fax
* map

Social Networks

* facebook
* twitter
* linkedin
* googleplus
* youtube
* vimeo
* rss


Use it like this: 

* `<?php $email = get_contact_data('email'); ?>`
* `[contact-data field="url"]`

By the moment it's only provided a 32x32px icons for the social buttons. 
In the short future it will provide a wider set of options to choose from.




Hi everybody,

This plugin, my first plugin ever in the WordPress.org plugin directory!, is an attempt to fill a gap in the use of WordPress as a complete CMS.

A modest attempt by the way :)

Through the years and through my experience creating websites based on WordPress for a lot of clients I encounter me once and again with the need of a central place to store all the contact information related to a company.

I encounter me, once and again, hard coding in the footer, in the header and in widgets the most basic contact information. No more of this!!!

Should not there be a specific place in the control panel to store this so basic information?

This plugin is, at the moment, a very basic compilation of the most useful contact data fields that my clients request all the time and the most common social networks they use at default.

I`m already using it in a dozen of sites, implementing it through the functions.php file, but I think it's time to go public and useful.

I'd love to hear your comment and know of any improvements that you think appropriate.

As you can see, my English is quite limited thus also appreciate any grammatical correction that could you make to the readme.txt file and to these texts.

I hope you find this plugin useful and promising and I count on your help to improve it in any way we can.

This plugin is yours as much as mine! go ahead!

Best regards,
Gonzalo.

== Installation ==

1. Upload `contact-data` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Settings->Contact Data and fill in all relevant data fields

== Screenshots ==

1. Appearance of the Contact Data admin page
2. Social Icons displayed through the follow_me_icons() function and the [follow-me-icons] shortcode

== Changelog ==

= 0.2 =
* Localization supported
* Spanish translation
* Some typo fixes

= 0.1 =
* First basic version.
