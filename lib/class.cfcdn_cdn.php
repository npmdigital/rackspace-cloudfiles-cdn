<?php

use \OpenCloud\Rackspace;

/**
 * Connection layer to CDN.
 */
class CFCDN_CDN{

  public $api_settings;
  public $uploads;
  public $cache_option_name;

  function __construct() {
    $this->api_settings = $this->settings();
    $this->uploads = wp_upload_dir();
    $this->cache_option_name = 'cfcdn_cache';
  }

 /**
  * CloudFiles CDN Settings.
  */
  public static function settings(){
    $default_settings = array( 'username' => 'YOUR USERNAME',
                               'apiKey' => 'YOUR API KEY',
                               'container' => 'YOUR CONTAINER',
                               'public_url' => 'http://YOUR LONG URL.rackcdn.com',
                               'region' => 'IAD',
                               'url' => 'https://identity.api.rackspacecloud.com/v2.0/',
                               'serviceName' => 'cloudFiles',
                               'urltype' => 'publicURL',
                               'first_upload' => 'false',
                               'delete_local_files' => 'true' );

    return get_option( CFCDN_OPTIONS, $default_settings );
  }


 /**
  *  Openstack Connection Object.
  */
  function connection_object(){
    $api_settings = $this->api_settings;
    $connection = new Rackspace(
      $api_settings['url'],
      [
          'username' => $api_settings['username'],
          'apiKey' => $api_settings['apiKey']
      ]
    );

    $cdn = $connection->objectStoreService( $api_settings['serviceName'], $api_settings['region'], $api_settings['urltype'] );

    return $cdn;
  }


 /**
  *  Openstack CDN Container Object.
  */
  public function container_object(){
    $api_settings = $this->api_settings;
    $cdn = $this->connection_object();
    $container = $cdn->getContainer($api_settings['container']);

    return $container;
  }


 /**
  * Puts given file attachment onto CDN.
  */
  public function upload_file( $file_path ){
    $relative_file_path = str_replace( $this->uploads['basedir'] . "/", '',  $file_path );
    $container = $this->container_object();
    $container->uploadObject($relative_file_path, file_get_contents( $file_path ));

    $this->write_to_cache( $file_path );
  }


 /**
  * List of files uploaded to CDN as recorded in cache file.
  */
  public function get_uploaded_files(){
    if(!get_option($this->cache_option_name)) {
        add_option($this->cache_option_name, [], null, 'no');
    }

    $excludes = [".", "..", $this->cache_file];
    $cache = get_option($this->cache_option_name);
    $files = array_diff($cache, $excludes);

    return $files;
  }


 /**
  * Write file path the cache file once file is uploaded to CDN.
  */
  public function write_to_cache( $file_path ){
    $cache = get_option($this->cache_option_name);
    if(get_option($this->cache_option_name) !== false) {
        $cache[] = $file_path;
        update_option($this->cache_option_name, $cache);
    } else {
        add_option($this->cache_option_name, [$file_path], null, 'no');
    }
  }


 /**
  * Purge the cached list of files already uploaded
  */
  public function purge_cache(){
    return update_option($this->cache_option_name, []);
  }


 /**
  * Change setting via key value pair.
  */
  public function update_setting( $setting, $value ){
    if( current_user_can('manage_options') && !empty($setting) ){
      $api_settings = $this->api_settings;
      $api_settings[$setting] = $value;
      update_option( CFCDN_OPTIONS, $api_settings );
      $this->api_settings = $api_settings;
    }

  }

}
