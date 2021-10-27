=== Commerce7 for WordPress ===
Contributors: michaelbourne
Donate link: https://www.paypal.me/yycpro
Tags: commerce7
Requires at least: 4.5
Tested up to: 5.8.1
Stable tag: 1.2.3
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Add Commerce7 to your WordPress site easily!

== Description ==

A free plugin for Commerce7 customers who wish to integrate their javascript widgets into a WordPress site. Commerce7 is a state of the art SaaS platform for breweries and wineries to offer modern DTC ecommerce solutions. It also offers a point of sale software, clubs, CRM, and tasting room reservations.


= Plugin Features =
 
*   Automatically create the needed pages and pass-through redirects for proper Commerce7 Integration
*   Embed Commerce7 widgets into any page through the use of shortcodes or pagebuilder elements
*   Full integration with popular pagebuilders like Cornerstone, Elementor, Beaver Builder, and WPBakery
*   Full integration with Gutenberg

This plugin relies on a third party service for it's functionality provided by [Commerce7](https://commerce7.com/). As an ecommerce solution, an SSL certificate is required on your website. Your privacy policy should be ammended to include the use of third party software for order processing. 

Read the [Commerce7 for WordPress Documentation](https://c7wp.com) to get started.


== Installation ==

1.  Upload your plugin folder to the '/wp-content/plugins' directory, or install directly from the plugin repo.
2.  Activate the plugin through the 'Plugins' menu in WordPress.
3.  Go to settings page and enter your Tenant ID.
4.  Read the docs and start selling!


== Frequently Asked Questions ==

= What can I do with this plugin? =

You can integrate your Commerce7 ecommerce account with your WordPress website, saving the hassle of manual integration.

= Is this plugin free? =

You bet! This plugin is 100% free, however it relies on a 3rd party service from Commerce7 that has multiple price points.


== Plugin Removal ==

Removing this plugin will render your widgets inactive.


== Screenshots ==

1. **Plugin Settings** - Easy to install and set up, in many cases all you have to do is provide your tenant ID.
2. **Gutenberg Integration** - Native Gutenberg blocks for all your Commerce7 front-end widgets.
3. **Beaver Builder** - Native Beaver Builder modules for easy to use, drag and drop Commerce7 front-end widgets.
4. **Elementor Integration** - Native Elementor widgets for easy to use, drag and drop Commerce7 front-end widgets.


== Changelog ==

= 1.2.3 =
* Small CSS tweak for users on V2 and still using the floating cart box.

= 1.2.2 =
* Fix login widget for V2 frontend
* Add Buy Button to V2 frontend
* Adjust V2 widgets in pagebuilder supports

= 1.2.1 =
* Fix small error in previous v1 frontend settings.

= 1.2.0 =
* Added support for Commerce7's new V2 Front End. As per their docs, some front end widgets no longer exist. Be sure to read their designer docs and undertsand what needs to be done on your end prior to upgrading.

= 1.1.3 =
* Added 'default content' Gutenberg block for better visualization when editing dynamic C7 pages. (too many people deleted the original div by accident)

= 1.1.2 =
* Small tweaks.

= 1.1.1 = 
* Fixed Subscription widget error in Gutenberg
* Changed default code to HTML blocks for required pages.
* Text update to Buy Button (slug) to reference Bundles.

= 1.1.0 =
* Full Gutenberg support with custom blocks for all Commerce7 widgets
* Massive expansion to Elementor page builder elements
* Massive expansion to Beaver Builder page builder elements
* Added new front end widgets: Quick Shop, Login Form, Create Account Form, Buy Button (Slug support for variable products)
* Code structure and formatting cleanup
* Better internationalization support

= 1.0.5 =
* Added support for the new "Join Now / Edit Membership" magic button for clubs, which should be used on landing pages you've created for your clubs.

= 1.0.4 =
* Fix activation error

= 1.0.3 =
* Added support for Commerce7 forms widgets

= 1.0.2 =
* Fixed compatibility when Woocommerce and Elementor Pro are installed

= 1.0.1 =
* Added support for the new reservations system. If you are upgrading to this version, please create a new Page in WordPress and give it the slug: reservation, or deactivate and activate this plugin after upgrade.

= 1.0.0 =
* Initial Public Version


== Upgrade Notice ==

= 1.2.0 =
Added support for Commerce7 V2 frontend. Please read their docs before choosing to change front end versions. Resave permalinks after update.

= 1.1.0=
Large update, clear cache after update to prevent display issues

= 1.0.5 =
Add support for new club join/edit magic button

= 1.0.4 =
Fix activation error

= 1.0.3 =
Added support for Commerce7 Forms

= 1.0.2 =
Fixed Elementor and Woocomerce conflict

= 1.0.1 =
Reservations support