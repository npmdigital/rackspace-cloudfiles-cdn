<?php

/**
 * Finds and uploads all attachments to Rackspace CDN if not already there.
 */
function cfcdn_upload_all(){
  $attachments = new CFCDN_Attachments();
  $attachments->upload_all();
}




/**
 * Rewrite asset URLs on the fly to pull from CDN.
 */
function cfcdn_reqrite_on_fly( $content ){

  $uploads = wp_upload_dir();
  $uploads_url = str_replace( array('http://', 'https://'), '', $uploads['baseurl'] );

  $cdn_settings = CFCDN_CDN::settings();
  $public_url = str_replace( array('http://', 'https://'), '', $cdn_settings['public_url'] );

  return str_replace( $uploads_url, $public_url, $content );

}add_filter( "the_content", "cfcdn_reqrite_on_fly" );


?>
