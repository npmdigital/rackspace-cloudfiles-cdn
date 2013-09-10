<?php
/**
 * Connection layer to CDN.
 */
class CFCDN_CDN{

  public $api_settings;
  public $uploads;

  function __construct() {
    $this->api_settings = $this->settings();
    $this->uploads = wp_upload_dir();
  }
  
 /**
  * CloudFiles CDN Settings.
  */
  public function settings(){
    $default_settings = array( 'username' => 'YOUR USERNAME',
                               'apiKey' => 'YOUR API KEY',
                               'container' => 'YOUR CONTAINER',
                               'url' => 'https://identity.api.rackspacecloud.com/v2.0/',
                               'serviceName' => 'cloudFiles',
                               'region' => 'DFW',
                               'urltype' => 'publicURL' );
  
    return get_option( CFCDN_OPTIONS, $default_settings );
  }
  
  
 /**
  *  Openstack Connection Object.
  */
  function connection_object(){
  
    $api_settings = $this->$api_settings;
    $connection = new \OpenCloud\Rackspace(
                            $api_settings['url'],
                            array(  'username' => $api_settings['username'],
                                    'apiKey' => $api_settings['apiKey']  ) );
  
    $cdn = $connection->ObjectStore( $api_settings['serviceName'], $api_settings['region'], $api_settings['urltype'] );
    return $cdn;
  }
  
  
 /**
  *  Openstack CDN Container Object.
  */
  public function container_object(){
    $api_settings = $this->$api_settings;
    $cdn = $this->connection_object();
    $container = $cdn->Container($api_settings['container']);
    return $container;
  }
  

 /**
  * Puts given file attachment onto CDN.
  */
  public function upload_file( $attachment ){
    $path = get_attached_file( $attachment->ID );
    $meta = wp_get_attachment_metadata();
    
    $container = $this->container_object();
    $file = $container->DataObject();
    $file->SetData( file_get_contents( $path ) );
    $file->name = 'pickle.gif';
    $file->content_type = 'image/jpeg';
    $file->Create();
    
  }


 /**
  * List of files uploaded to CDN as recorded in cache file.
  */
  public function get_uploaded_files(){
  
    $cache_folder = $this->uploads['basedir'] . "/cdn/tmp/";
    $cache_file = $cache_folder . "cache.csv";
    if( !file_exists( $cache_file ) ){
      mkdir( $cache_folder, 0777, true );
    }

    $fp = fopen( $cache_file, 'w' ) or die('Cannot open file:  ' . $cache_file );
    $files = str_getcsv( $cache_file );
    fclose( $fp );

    return $files;
  }




  public function test(){
    $container = $this->container_object();
    $att = $container->DataObject();
    $att->SetData( file_get_contents("/home/rroyal/Desktop/pickle.gif") );
    $att->name = 'pickle.gif';
    $att->content_type = 'image/jpeg';
    $att->Create();

  }

  
}
?>
