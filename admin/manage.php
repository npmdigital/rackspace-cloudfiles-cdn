<?php defined('CFCDN_PATH') or die(); ?>
<?php $cfcdn = new CFCDN_CDN();?>
<?php cfcdn_save_settings(); ?>
<?php $settings = $cfcdn->settings(); ?>

<div class="wrap cfcdn">

  <h2 class="left">Rackspace Cloudfiles CDN</h2>
  <div class="clear"></div>
  <hr />


  <h3>Moving Files To CDN</h3>

  <?php if($settings["first_upload"] !== "true"): ?>
    <div id="setting-error-settings_updated" class="updated settings-error"> 
      <p><strong>Waiting on first upload</strong><br />You have not run your first upload to the CDN. Click the manual upload button to move your existing files to the CDN and finish plugin activation.</p>
    </div>
  <?php endif; ?>

  <table class="form-table">
    <tbody>

      <tr valign="top">
        <th scope="row"><label>Manual Upload</label></th>
        <td>
          <p>
            <a href="#" class="button" id="cfcdn_manual_upload" data-blogurl="<?php echo site_url();?>">Upload Now</a>
            <br />
            <span class="description">Click this button to manually upload attachments to CDN.</span>
            <br />
            <span id="cfcdn_info" class="description" style="display:none">
              <img class="cfcdn_loading" style="display:none" src="<?php echo CFCDN_LOADIND_URL;?>" />
            </span>
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
            <input name="cfcdn[username]" type="text" value="<?php echo $settings['username'];?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[apiKey]">API Key</label></th>
          <td>
            <input name="cfcdn[apiKey]" type="text" value="<?php echo $settings['apiKey'];?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[container]">Container</label></th>
          <td>
            <input name="cfcdn[container]" type="text" value="<?php echo $settings['container'];?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[public_url]">Public URL to Container</label></th>
          <td>
            <input name="cfcdn[public_url]" type="text" value="<?php echo $settings['public_url'];?>" class="regular-text" required="required" />
            <br />
            <span class="description">Get from Rackspace account dashboard, without trailing slash.</span>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[region]">Region</label></th>
          <td>
            <input name="cfcdn[region]" type="text" value="<?php echo $settings['region'];?>" class="regular-text" required="required" />
            <br />
            <span class="description">Rackspace filestore region, DFW (Dallas) or ORD (Chicago).</span>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[url]">API Version URL</label></th>
          <td>
            <input name="cfcdn[url]" type="text" value="<?php echo $settings['url'];?>" class="regular-text" required="required" readonly="readonly" />
          </td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="cfcdn[serviceName]">Service Name</label></th>
          <td>
            <input name="cfcdn[serviceName]" type="text" value="<?php echo $settings['serviceName'];?>" class="regular-text" required="required" readonly="readonly" />
          </td>
        </tr>



        <tr valign="top">
          <th scope="row"><label for="cfcdn[urltype]">URL Type</label></th>
          <td>
            <input name="cfcdn[urltype]" type="text" value="<?php echo $settings['urltype'];?>" class="regular-text" required="required" readonly="readonly" />
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
