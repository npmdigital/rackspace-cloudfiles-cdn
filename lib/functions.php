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
  $uploads_pattern = addslashes($uploads_url); #str_replace( array('/'), array('\/'), $uploads_url );
  error_log( $uploads_pattern );

  $pattern = "/\/wp-content\/uploads\/(.*)\/(.*)\/(.*).gif/";
  $pattern = "/$uploads_pattern\/(.*)\/(.*)\/(.*).gif/";
  $replacement = "cdn.cyberciti.biz/uploads/$1/$2/$3.gif";
  
  return preg_replace( $pattern, $replacement, $content );
}add_filter( "the_content", "cfcdn_reqrite_on_fly" );


?>
