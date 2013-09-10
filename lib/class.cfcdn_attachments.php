<?php 
/**
 * Abstraction layer over WordPress attachments for getting and 
 * pushing attachments to and from CDN.
 */
class CFCDN_Attachments{

  public $uploads;
  public $uploaded_files;

  function __construct() {
    $this->uploads = wp_upload_dir();
    $this->load_cache();
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

    $path = $this->uploads['basedir'];

    $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator($path) );
    var_dump( $this->uploaded_files );
    foreach( $files as $name => $file_info ){
      if ( substr( $name, -1 ) != "." && substr( $name, -2 ) != ".." ){
  #      echo "$name<br />";
        
      }
    }

  }


 /**
  * Upload attachment to Cloudfiles.
  */
  public function upload_attachment( $attachment, $cdn ){
    $cdn->upload_file( $attachment );

  } 


 /**
  * Gets all attachments that have not been uploaded to Cloudfiles.
  */
  public function get_local_attachments(){
    $args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent' => null );
    $attachments = get_posts($args);
  
    return $attachments;
  }


 /**
  * Load lists of files already uploaded to CDN.
  * Uses a persistance file in uploads folder
  */
  public function load_cache(){
    $cdn = new CFCDN_CDN();
    $this->uploaded_files = $cdn->get_uploaded_files();

  }

  
}
?>
