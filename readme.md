*Forked from [singlow/rackspace-cloudfiles-cdn](https://github.com/singlow/rackspace-cloudfiles-cdn)*

Rackspace CloudFiles CDN
----


A WordPress plugin that moves attachments to Rackspace Cloudfiles CDN.

### Description

Moves files uploaded through Media Manager to Cloudfiles automatically, and rewrites URL in content. Optionally delete local files after CDN upload.

### Installation

1. Add a `composer.json` file to the root of your WP install. This will set the PHP version 
```json
{
  "require": {
    "php": "^7.0.0",
    "rackspace/php-opencloud": "^1.16"
  },
  "autoload": {
    "files": [
      "wp-content/plugins/rackspace-cloudfiles-cdn/lib/db_setup.php",
      "wp-content/plugins/rackspace-cloudfiles-cdn/lib/functions.php",
      "wp-content/plugins/rackspace-cloudfiles-cdn/admin/functions.php"
    ],
    "classmap": ["wp-content/plugins/rackspace-cloudfiles-cdn/lib/"]
  }
}
```
2. Upload the plugin folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Click on the CloudFiles CDN link on the admin and enter your API settings and container name.
5. Create the container from your CloudFiles account and make it a Public CDN.
6. On the admin, click the "Upload Now" button.
7. Try adding an image from the media uploader or from within a post. File uploading will be slower due to moving the files to the CDN on the fly.

### Frequently Asked Questions

**Is this a caching plugin?**

No. This plugin is for putting WordPress Attachments and files in the WordPress uploads directory on a CDN where they belong because WordPress has no native feature for that. This is not a caching plugin and it is not intended to be.

**Does this plugin require other plugins to be installed to work correctly?**

No. This plugin simply pushes all uploaded files to a CDN network.

**Does this plugin remove the local copy of the file?**

You can optionally have the plugin remove the local copy of the file since it is not needed and taking up valuable server space.

**Does this plugin handle theme or other plugin assets (Images, CSS, JavaScript)?**

No. Those things typically belong in revision control and you should have your deployment system take care of their linking.

### Screenshots

![alt text](screenshot-1.png "Beautifully simple management")

![alt text](screenshot-2.png "Example output in content")

### Changelog

**0.0.3**
- Allows the use of `https` links from the Cloudfiles container.

**0.0.2**
- Combed through plugin with PHP strict standards to increase compatibility.
- Added configuration instructions.

**0.0.1**
- Originating Version.
