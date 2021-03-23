=== Retina @2x ===
Contributors: WouterPostmaNL
Tags: retina, images, iOS, iPhone, iPad, pixel density, Apple
Requires at least: 3.0.1
Tested up to: 4.8
Stable tag: 1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that looks for retina images automatically based on the @2x naming convention.

== Description ==

This plugin adds a simple Javascript to your WordPress website that will check for each image if there is a retina version available. This will make sure that your images (logo's, buttons, images with text) look sharp on Apple devices with retina displays.

When you have for example a logo of 200 by 200 pixels called "Logo.png", you will need to upload a second image of 400 by 400 pixels called "Logo@2x.png" in the exact same directory.

* [Retina.js by imulus](http://imulus.github.io/retinajs/)
* [View my other plugins](https://profiles.wordpress.org/wouterpostmanl#content-plugins)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Done!

== Frequently Asked Questions ==

= Will this work with images from a CDN? =

No, we might add this later.

= What's the difference between Retina @2x and other Retina plugins? =

Other plugins may automatically generate the retina version of your image(s). This plugin is much more simple and lightweight and only looks for retina images. If you don't upload a "@2x" version, the original image will be shown and therefore not look sharp on mobile devices.

== Changelog ==

= 1.6 =
Updated the plugin description and installation guidelines.

== Upgrade Notice ==

= 1.6 =
New version available!