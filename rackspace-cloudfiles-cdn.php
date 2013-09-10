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
define('CFCDN_UPLOAD_CURL', CFCDN_ROUTE . "upload_ping" );
define('CFCDN_NEEDING_UPLOAD_JSON', CFCDN_ROUTE . "needing_upload.json" );
define('CFCDN_OPTIONS', "wp_cfcdn_settings" );
define('CFCDN_LOADIND_URL', WP_PLUGIN_URL.'/rackspace-cloudfiles-cdn/assets/images/loading.gif');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
require_once("lib/db_setup.php");
require_once("lib/functions.php");
require_once("admin/functions.php");
require_once("lib/class.cfcdn_cdn.php");
require_once("lib/class.cfcdn_attachments.php");
require_once("lib/class.cfcdn_util.php");
require_once("lib/php-opencloud-1.5.10/lib/php-opencloud.php");




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





/**
 * Uploads files to Cloudfiles CDN on GET request to "/?cfcdn_routing=upload_ping".
 */
function cfcdn_parse_upload_ping($wp) {
  if (array_key_exists('cfcdn_routing', $wp->query_vars) && $wp->query_vars['cfcdn_routing'] == 'upload_ping') {
    CFCDN_Util::upload_all();
    die();exit();
  }
}add_action('parse_request', 'cfcdn_parse_upload_ping');


/**
 * List of files that need to be uploaded, GET "/?cfcdn_routing=needing_upload.json".
 */
function cfcdn_parse_needing_upload_json($wp) {
  if (array_key_exists('cfcdn_routing', $wp->query_vars) && $wp->query_vars['cfcdn_routing'] == 'needing_upload.json') {
    $attachments = new CFCDN_Attachments();
    echo $attachments->needing_upload_as_json();
    die();exit();
  }
}add_action('parse_request', 'cfcdn_parse_needing_upload_json');


/**
 * Uploads individual file to Cloudfiles CDN on GET request to "/?cfcdn_routing=upload_file&path={PATH_TO_FILE}".
 */
function cfcdn_parse_upload_file($wp) {
  if (array_key_exists('cfcdn_routing', $wp->query_vars) && $wp->query_vars['cfcdn_routing'] == 'upload_file') {
    $file_path = $_GET['path'];
    if( !empty( $file_path ) ){
      $cdn = new CFCDN_CDN();
      #$cdn->upload_file( $file_path );
      echo "Uploading $file_path";
    }
    die();exit();
  }
}add_action('parse_request', 'cfcdn_parse_upload_file');







function cfcdn_parse_query_vars($vars) {
  $vars[] = 'cfcdn_routing';
  return $vars;
}add_filter('query_vars', 'cfcdn_parse_query_vars');

?>
