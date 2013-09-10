<?php

/**
 * Finds and uploads all attachments to Rackspace CDN if not already there.
 */
function cfcdn_upload_all(){
  $attachments = cfcdn_get_local_attachments();
  
}


/**
 * Gets all attachments that have not been uploaded to Cloudfiles.
 */
function cfcdn_get_local_attachments(){
  $args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent' => null );
  $attachments = get_posts($args);
  
  return $attachments;  
}


/**
 * CloudFiles CDN Settings
 */
function cfcdn_settings(){
  
}

?>
