<?php


/**
 * Rewrite asset URLs on the fly to pull from CDN.
 */
function cfcdn_rewrite_on_fly( $content ) {
  $uploads_url = wp_upload_dir()['baseurl'];
  $cdn_public_url = \CFCDN_CDN::settings()['public_url'];

  return str_replace( $uploads_url, $cdn_public_url, $content );
}
add_filter( "the_content", "cfcdn_rewrite_on_fly" );
add_filter('wp_get_attachment_url', 'cfcdn_rewrite_on_fly');



/**
 * Save file to cloudfiles when uploading new attachment.
 */
function cfcdn_send_to_cdn_on_attachment_post_save( $post_id ){
  \CFCDN_Util::upload_all();
}
add_action( 'add_attachment', 'cfcdn_send_to_cdn_on_attachment_post_save' );



/**
 * Make sure all files are pushed to CDN on admin page load after initial push.
 */
function cfcdn_admin_page_load() {
  if( is_admin() ){
    \CFCDN_Util::upload_all();
  }
}
// add_action( 'shutdown', 'cfcdn_admin_page_load' );
