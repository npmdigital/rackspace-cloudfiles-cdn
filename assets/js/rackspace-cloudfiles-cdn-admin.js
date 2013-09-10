jQuery(document).ready(function($) {


  /* Get list of all files needing upload and push to CDN individually via AJAX */
  $("a#cfcdn_manual_upload").click( function(e){
    e.preventDefault();

    blog_url = $(this).data("blogurl");
    single_url = blog_url + "/?cfcdn_routing=upload_file&path=";
    ajax_url =  blog_url + "/?cfcdn_routing=needing_upload.json";

    $.get( ajax_url, function( data ){
      files = $.parseJSON( data );
      $.each( files, function(key, file_path){

        $.get( single_url + file_path, function( file_data ){
          $("div#manually_uploaded_files").append( "<p>" + file_data + "</p>" );
        });

      });
      
    });
  });


});
