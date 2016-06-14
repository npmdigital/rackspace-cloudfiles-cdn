<?php
/*
Plugin Name: Rackspace Cloudfiles CDN
Plugin URI: https://github.com/npmdigital/rackspace-cloudfiles-cdn
Description: A plugin that moves attachments to Rackspace Cloudfiles.
Version: 0.0.3
Author: NPM Digital
Author URI: http://npmdigital.org
License: GPLv2
*/

defined('WP_PLUGIN_URL') or die('Restricted access');

global $wpdb;

define('CFCDN_PATH', plugin_dir_path(__FILE__));
define('CFCDN_URL', plugins_url('/' , __FILE__));
define('CFCDN_ROUTE', get_bloginfo('url').'/?cfcdn_routing=');
define('CFCDN_UPLOAD_CURL', CFCDN_ROUTE . "upload_ping" );
define('CFCDN_PURGE_CACHE_CURL', CFCDN_ROUTE . "purge_cache" );
define('CFCDN_DELETE_CURL', CFCDN_ROUTE . "delete_ping" );
define('CFCDN_NEEDING_UPLOAD_JSON', CFCDN_ROUTE . "needing_upload.json" );
define('CFCDN_OPTIONS', "wp_cfcdn_settings" );
define('CFCDN_LOADING_URL', plugins_url('/assets/images/loading.gif' , __FILE__));

require_once(ABSPATH.'wp-admin/includes/upgrade.php');

require __DIR__ . '/vendor/autoload.php';

/**
 *  Register and enqueue frontend CSS
 */
function cfcdn_stylesheets() {
    if(!is_admin()){
        wp_enqueue_style('rackspace-cloudfiles-cdn-style', CFCDN_URL.'assets/css/rackspace-cloudfiles-cdn.css');
    }
}
add_action('wp_print_styles', 'cfcdn_stylesheets');


/**
 *  Register and enqueue frontend JavaScript
 */
function cfcdn_js() {
    if(!is_admin()){
        wp_enqueue_script('jquery');
        wp_enqueue_script('rackspace-cloudfiles-cdn-js', CFCDN_URL.'assets/js/rackspace-cloudfiles-cdn.js');
    }
}
add_action('wp_enqueue_scripts', 'cfcdn_js');


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
}
add_action('admin_enqueue_scripts', 'cfcdn_admin_js');


/**
 * Parse requests from specific URLs.
 */
function cfcdn_parse_url_requests($wp) {
    if (!array_key_exists('cfcdn_routing', $wp->query_vars) ) {
        return;
    }

    /* Uploads files to Cloudfiles CDN on GET request to "/?cfcdn_routing=upload_ping". */
    if ( $wp->query_vars['cfcdn_routing'] == 'upload_ping') {
        CFCDN_Util::upload_all();
    }

    /* Purges cached list of files that have been uploaded */
    if ( $wp->query_vars['cfcdn_routing'] == 'purge_cache') {
        $cdn = new CFCDN_CDN();
        if($cdn->purge_cache()) {
            echo "Cache purged successfully!";
        } else {
            echo "Something went wrong purging the cache!";
        }
    }

    /* List of files that need to be uploaded, GET "/?cfcdn_routing=needing_upload.json". */
    if ( $wp->query_vars['cfcdn_routing'] == 'needing_upload.json') {
        $attachments = new CFCDN_Attachments();
        echo $attachments->needing_upload_as_json();
    }

    /* Uploads individual file to Cloudfiles CDN on GET request to "/?cfcdn_routing=upload_file&path={PATH_TO_FILE}". */
    if ( $wp->query_vars['cfcdn_routing'] == 'upload_file') {
        $file_path = $_GET['path'];
        $cdn = new CFCDN_CDN();
        if( !empty( $file_path ) ){
            $cdn->upload_file( $file_path );
            echo "Uploading $file_path";
        }
        $cdn->update_setting( "first_upload", "true" );
    }

    /* Delete local files that are already pushed to CDN on GET request to "/?cfcdn_routing=delete_ping".*/
    if ( $wp->query_vars['cfcdn_routing'] == 'delete_ping') {
        CFCDN_Util::delete_local_files();
    }

    die();exit();
}
add_action('parse_request', 'cfcdn_parse_url_requests');


function cfcdn_parse_query_vars($vars) {
    $vars[] = 'cfcdn_routing';
    return $vars;
}
add_filter('query_vars', 'cfcdn_parse_query_vars');
