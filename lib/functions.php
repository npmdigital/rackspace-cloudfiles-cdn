<?php

/**
 * Finds and uploads all attachments to Rackspace CDN if not already there.
 */
function cfcdn_upload_all(){
  $attachments = new CFCDN_Attachments();
  $attachments->upload_all();
}




?>
