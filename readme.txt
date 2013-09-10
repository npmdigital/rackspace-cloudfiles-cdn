=== Rackspace CloudFile CDN ===
Donate link: http://labs.saidigital.co
Tags: cdn, rackspace
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that moves attachments to Rackspace Cloudfiles.

== Description ==

Moves attachments to Cloudfiles manually or automatically (with cron), and rewrites URL in content. Optionally delete files off local server or pull back down from Cloufiles.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory 2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Is this a caching plugin? =

No! This plugin is for putting attachments on a CDN where they belong because WordPress has no native feature for that. This is not a caching plugin and it is not intended to be.

= Does this plugin require other plugins to be installed to work correctly? =

No, in the spirit of `separation of means/functionality`, this plugin simply connects attachments to a CDN network.

= Do this plugin remove local copies of file? =

You can optionally have the plugin remove the local copy of the attachment since it is not needed and taking up valuable server space. Yes can also pull all the downloads back down to local attachments and deactivate the plugin with no harm done.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif)
2. This screen shot description corresponds to screenshot-2.(png|jpg|jpeg|gif)

== Changelog ==

= 0.0.1 =
* Originating Version.
