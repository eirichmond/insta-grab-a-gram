=== Plugin Name ===
Contributors: erichmond
Donate link: http://www.squareonemd.co.uk/
Tags: instagram, tag, hashtag
Requires at least: 4.1
Tested up to: 4.1
Stable tag: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin grabs list of images specific to a tagged image from the instagram API.

== Description ==

Simply register your instagram application to authenticate and authorize your requests.
Then whenever an image is posted to instagram with a specific hashtag this plugin will
request only those images and render them in your WordPress install.

This plugin uses Tom McFarlin's WP plugin boilerplate.

== Installation ==

To take full advantage of this plugin you'll need an instagram account and a registered
instagram application, simply goto http://instagram.com/developer/ once your application
has been registered you will be provided with a CLIENT ID and a CLIENT SECRET you will use
these to authenticate the requests from your site to instagram.

To install the plugin:

1. Upload `insta-grab-gram` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php do_action('insta_grab_a_gram'); ?>` in your templates

== Frequently Asked Questions ==

= I don't have an instagam account =

Simply go to http://instagram.com and register your users account.

= Where can I find my CLIENT ID and CLIENT SECRET =

Once logged in to your instagram account go to http://instagram.com/developer/ and register your application,
once activated you will be given the CLIENT ID and CLIENT SECRET in your account, you can manage mulitple applications.

== Screenshots ==

1. Insta-grab-a-gram has a simple settings pages for essential api settings <img src="screenshot.png" alt="screenshot" width="872" height="467" />

== Changelog ==

= 1.0 =

* First release.

== Upgrade Notice ==

== Arbitrary section ==

== A brief Markdown Example ==

Settings include:

1. Your chosen hashtag
2. And the amount of images requested