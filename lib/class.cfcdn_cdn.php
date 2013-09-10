<?php
/**
 * Connection layer to CDN.
 */
class CFCDN_CDN{
  
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
  *  Openstack Connection Object
  */
  function connection_object(){
  
    $api_settings = $this->settings();
    $connection = new OpenCloudRackspace(
                            $api_settings['url'],
                            array(  'username' => $api_settings['username'],
                                    'apiKey' => $api_settings['apiKey']  ) );
  
    $cdn = $connection->ObjectStore( $api_settings['serviceName'], $api_settings['region'], $api_settings['urltype'] );
    error_log( var_export( $cdn, true ) );
    $cdn->Container()->Create(array('name' => 'test_1'));
  }
  
  
  
  
}
?>
