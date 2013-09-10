<?php 
/**
 * Abstraction layer over WordPress attachments for getting and 
 * pushing attachments to and from CDN.
 */
class CFCDN_Attachments{

  public $uploads;


  function __construct() {
    $this->uploads = wp_upload_dir();
  }




 /**
  * Finds local attachment files and uploads them to CDN.
  */
  public function upload_all(){
    $cdn = new CFCDN_CDN();
    $attachments = scandir( $this->uploads['basedir'] );
    error_log( var_export($attachments, true) );
#    foreach( $attachments as $attachment ){
#      $this->upload_attachment($attachment, $cdn );
#    }
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


  
}

?>
