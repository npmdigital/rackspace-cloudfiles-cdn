<?php
/**
 * Hooks and classbacks for syncing CDN and file structure.
 */
class CFCDN_Util{


 /**
  * Finds and uploads all attachments to Rackspace CDN if not already there.
  */
  public static function upload_all(){
    $attachments = new \CFCDN_Attachments();
    $attachments->upload_all();
  }


 /**
  * Purges cache of files that have already been uploaded
  */
  public static function purge_cache(){
    $attachments = new \CFCDN_Attachments();
    $attachments->purge_cache();
  }


 /**
  * Deltes all local files that are uploaded to CDN.
  */
  public static function delete_local_files(){
    $attachments = new \CFCDN_Attachments();
    $attachments->delete_local_files();
  }

}
