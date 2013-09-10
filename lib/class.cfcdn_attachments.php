<?php 
/**
 * Abstraction layer over WordPress attachments for getting and 
 * pushing attachments to and from CDN.
 */
class CFCDN_Attachments{

  public $uploads;
  public $cache_file;

  public $local_files;
  public $uploaded_files;
  public $file_needing_upload;

  function __construct() {
    $this->uploads = wp_upload_dir();
    $this->load_cache();
    $this->load_local_files();
  }




 /**
  * Finds local attachment files and uploads them to CDN.
  * Requires PHP Directory Iterator installed on server.
  * Included in Standard PHP Library (SPL) - http://php.net/manual/en/book.spl.php
  *
  * @see http://de.php.net/manual/en/directoryiterator.construct.php
  */
  public function upload_all(){
    $cdn = new CFCDN_CDN();
    $this->load_files_needing_upload();

    foreach( $this->files_needing_upload as $file_path ){
      $cdn->upload_file( $file_path );
    }
  }




 /**
  * Gets all files in the local WP Uploads folder and set into $local_files.
  */
  public function load_local_files(){
    $path = $this->uploads['basedir'];
    $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator($path) );
    $local_files = array();
    foreach( $files as $name => $file_info ){
      if( substr($name, -1) != "." && substr($name, -1) != ".." ){
        $local_files[] = $name;
      }
    }

    $this->local_files = array_diff( $local_files, array(".", "..", $this->cache_file) );
  }


 /**
  * Load lists of files already uploaded to CDN.
  * Uses a persistance file in uploads folder
  */
  public function load_cache(){
    $cdn = new CFCDN_CDN();
    $this->cache_file = $cdn->cache_file;
    $this->uploaded_files = $cdn->get_uploaded_files();

  }

 /**
  * Calculate files that need to be uploaded. Not done on class init.
  * Sticks into array $this->files_needing_upload;
  */
  public function load_files_needing_upload(){
    $this->files_needing_upload = array_diff( $this->local_files, $this->uploaded_files );
  }

  
}
?>
