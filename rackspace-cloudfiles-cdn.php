<?php
/*
Plugin Name: Rackspace CloudFile CDN
Plugin URI: http://labs.saidigital.co/products/rackspace-cloudfiles-cdn
Description: A plugin that moves attachments to Rackspace Cloudfiles.
Version: 0.0.1
Author: richardroyal
Author URI: http://saidigital.co/about-us/people/richard-royal/
License: GPLv2
*/
?>
<?php
/*
    Copyright 2013 richardroyal (richard@saidigital.co)
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
?>
<?php
defined('WP_PLUGIN_URL') or die('Restricted access');

global $wpdb;
define('CFCDN_PATH', ABSPATH.PLUGINDIR.'/rackspace-cloudfiles-cdn/');
define('CFCDN_URL', WP_PLUGIN_URL.'/rackspace-cloudfiles-cdn/');
define('CFCDN_ROUTE', get_bloginfo('url').'/?cfcdn_routing=');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
require_once("lib/db_setup.php");
require_once("lib/functions.php");
require_once("admin/functions.php");




/**
 *  Register and enqueue frontend CSS
 */
function cfcdn_stylesheets() {
  if(!is_admin()){
    wp_enqueue_style('rackspace-cloudfiles-cdn-style', CFCDN_URL.'assets/css/rackspace-cloudfiles-cdn.css');
  }
}add_action('wp_print_styles', 'cfcdn_stylesheets');


/**
 *  Register and enqueue frontend JavaScript
 */
function cfcdn_js() {
  if(!is_admin()){
    wp_enqueue_script('jquery');
    wp_enqueue_script('rackspace-cloudfiles-cdn-js', CFCDN_URL.'assets/js/rackspace-cloudfiles-cdn.js');
  }
}add_action('wp_enqueue_scripts', 'cfcdn_js');


/**
 *  Register and enqueue admin JavaScript
 */
function cfcdn_admin_js() {
  wp_enqueue_script('jquery');
  wp_enqueue_media();
  wp_enqueue_style('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_script('rackspace-cloudfiles-cdn-admin-js', CFCDN_URL.'assets/js/rackspace-cloudfiles-cdn-admin.js');
}add_action('admin_enqueue_scripts', 'cfcdn_admin_js');


?>