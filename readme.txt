=== Premise Portfolio ===
Contributors: premisewp
Donate link: http://premisewp.com/donate
Tags: portfolio, premise portfolio, minimalistic portfolio, simple portfolio, portfolio custom post type, premise wp, premise, premisewp
Requires at least: 3.9.0
Tested up to: 4.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a modern and minimalistic portfolio on your site. This is the official portfolio plugin used across premisewp.com to display the themes and plugins that we build.

== Description ==

This plugin is in beta and should be used as such (there might be bugs but we are quickly fixing them :) ). This plugin was build to display the premise portfolio for <a href="http://premisewp.com" target="_blank">premisewp.com</a> so we could showcase the themes and plugins we build, like this one.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin main folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Start adding Portfolio Items :)

== Frequently Asked Questions ==

= Where can I find more information and documentation? =

Go to <a href="http://plugins.premisewp.com/premise-portfolio/premise-portfolio/" target="_blank">Premise Portfolio</a>.

== Changelog ==

= 1.2.2 =
* Added new filter 'pwp_portfolio_loop_excerpt' that lets you control the excerpt for portfolio items when displayed via the shortcode.
* Removed template override for portfolio categories. The loop template is now only used by the shortcode class when loading a shortcode.

= 1.2.1 =
* Added ability to change the defaults from a filter. Documented filter in the Readme.md file.

= 1.2.0 =
* Simplified templates for portfolio loop and single post.
* Added ability to filter portfolio items by category passing a param `cat` - can be a string of category names or ids sepatated by commas.

= 1.1.0 =
* Add tags and categories to Portfolio Items CPT & single template
* Fix 404 error for Portfolio Items CPT

= 1.0.0 =
* New version
