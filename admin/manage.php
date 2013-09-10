<?php defined('CFCDN_PATH') or die();?>
<?php $settings = cfcdn_settings();?>

<div class="wrap cfcdn">

  <h2 class="left">Rackspace Cloudfiles CDN</h2>
  <div class="clear"></div>
  <hr />


  <h3>Moving Files To CDN</h3>


  <table class="form-table">
    <tbody>

      <tr valign="top">
        <th scope="row"><label>Manual Upload</label></th>
        <td>
          <p>
            <a href="" class="button">Upload Now</a><br />
            <span class="description">Click this button to uploads attachments to CDN.</span>
          </p>
        </td>
      </tr>
        
      <tr valign="top">
        <th scope="row"><label>Cron Upload</label></th>
        <td>
          <input type="text" class="regular-text" readonly="readonly" value="<?php echo CFCDN_UPLOAD_CURL;?>" />
          <a class="button" target="_blank" href="<?php echo CFCDN_UPLOAD_CURL;?>">Go</a>
          <p><span class="description">Hit this URL to move files to CDN. <a href="" target="_blank">Example cron file</a>.</span></p>
          <div id="cfcdn_move_files"></div>
        </td>
      </tr>

    </tbody>
  </table>



  <h3>Manage Files</h3>


  <table class="form-table">
    <tbody>

      <tr valign="top">
        <th scope="row"><label>Delete Local Files</label></th>
        <td>
          <a href="" class="button">Delete Files</a>
          <span class="description">Click here to delete local copies of attachment files.</span>
        </td>
      </tr>



      <tr valign="top">
        <th scope="row"><label>Download Files</label></th>
        <td>
          <a href="" class="button">Download Files</a>
          <span class="description">Click here to download files off Cloudfiles into local WordPress.</span>
        </td>
      </tr>

    </tbody>
  </table>


  



  <br />


  <h3>Rackspace CDN Settings</h3>

  <form method="post" action="">
    
    <table class="form-table">
      <tbody>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[username]">Username</label></th>
          <td>
            <input name="cfcdn[username]" type="text" value="<?php echo $settings->username;?>" class="regular-text" required="required" />
          </td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="cfcdn[api_key]">API Key</label></th>
          <td>
            <input name="cfcdn[api_key]" type="text" value="<?php echo $settings->api_key;?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[container]">Container</label></th>
          <td>
            <input name="cfcdn[container]" type="text" value="<?php echo $settings->container;?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"></th>
          <td>
            <p>
              <input class="button-primary" class="left" type="submit" name="save_settings" value="Save" />&nbsp;
            </p>
          </td>
        </tr>
        
      </tbody>
    </table>



  </form>
  


</div>
