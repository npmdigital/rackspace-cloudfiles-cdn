<?php defined('CFCDN_PATH') or die(); ?>
<?php $cfcdn = new CFCDN_CDN();?>
<?php cfcdn_save_settings(); ?>
<?php $settings = $cfcdn->settings(); ?>

<div class="wrap cfcdn">

  <h2 class="left">Rackspace Cloudfiles CDN</h2>
  <div class="clear"></div>
  <hr />

  <form method="post" action="">

    <h3>Moving Files To CDN</h3>

    <?php if( !empty($settings) || empty($settings["first_upload"]) || $settings["first_upload"] !== "true"): ?>
      <div id="setting-error-settings_updated" class="updated settings-error">
        <p><strong>Waiting on first upload</strong><br />You have not run your first upload to the CDN. Click the manual upload button to move your existing files to the CDN and finish plugin activation.</p>
      </div>
    <?php else: ?>
      <input type="hidden" name="cfcdn[first_upload]" value="true" />
    <?php endif; ?>

    <table class="form-table">
      <tbody>

        <tr valign="top">
          <th scope="row"><label>Manual Upload</label></th>
          <td>
            <p>
              <a href="#" class="button" id="cfcdn_manual_upload" data-blogurl="<?= site_url();?>">Upload Now</a>
              <br />
              <span class="description">Click this button to manually upload attachments to CDN.</span>
              <br />
              <span id="cfcdn_info" class="description" style="display:none">
                <img class="cfcdn_loading" style="display:none" src="<?= CFCDN_LOADING_URL;?>" />
              </span>
            </p>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label>Purge Cache</label></th>
          <td>
            <input type="text" class="regular-text" readonly="readonly" value="<?= CFCDN_PURGE_CACHE_CURL;?>" />
            <a class="button" target="_blank" href="#" id="cfcdn_purge_cache" data-blogurl="<?= site_url();?>">Go</a>
            <p><span class="description">Click this button to purge the cached list of files already uploaded.</span></p>
            <p><span class="description">Optionally, hit this URL with a cron job to systematically purge the cache.</span></p>
            <div id="cfcdn_purge_info"></div>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label>Cron Upload</label></th>
          <td>
            <input type="text" class="regular-text" readonly="readonly" value="<?= CFCDN_UPLOAD_CURL;?>" />
            <a class="button" target="_blank" href="<?= CFCDN_UPLOAD_CURL;?>">Go</a>
            <p><span class="description">Optionally, hit this URL with a cron job to help keep files in sync.</span></p>
            <div id="cfcdn_move_files"></div>
          </td>
        </tr>

      </tbody>
    </table>



    <h3>Manage Files</h3>

    <table class="form-table">
      <tbody>

        <tr valign="top">
          <th scope="row"><label>Delete Local Files?</label></th>
          <td>
            <input type="hidden" name="cfcdn[delete_local_files]" value="false" />
            <input type="checkbox" name="cfcdn[delete_local_files]" value="true" <?= ($settings['delete_local_files'] == 'true') ? 'checked' : ''; ?> />
            <span class="description">Delete local files once they are uploaded to CDN.</span>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label>Cron delete</label></th>
          <td>
            <input type="text" class="regular-text" readonly="readonly" value="<?= CFCDN_DELETE_CURL;?>" />
            <a class="button" target="_blank" href="<?= CFCDN_DELETE_CURL;?>">Go</a>
            <p><span class="description">Ping this URL to delete local files automatically once they are on CDN.</span></p>
          </td>
        </tr>

      </tbody>
    </table>






    <br />


    <h3>Rackspace CDN Settings</h3>


    <table class="form-table">
      <tbody>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[username]">Username</label></th>
          <td>
            <input name="cfcdn[username]" type="text" value="<?= $settings['username'];?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[apiKey]">API Key</label></th>
          <td>
            <input name="cfcdn[apiKey]" type="text" value="<?= $settings['apiKey'];?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[container]">Container</label></th>
          <td>
            <input name="cfcdn[container]" type="text" value="<?= $settings['container'];?>" class="regular-text" required="required" />
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[public_url]">Public URL to Container</label></th>
          <td>
            <input name="cfcdn[public_url]" type="text" value="<?= $settings['public_url'];?>" class="regular-text" required="required" />
            <br />
            <span class="description">Get from Rackspace account dashboard, without trailing slash.</span>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[region]">Region</label></th>
          <td>
            <input name="cfcdn[region]" type="text" value="<?= $settings['region'];?>" class="regular-text" required="required" />
            <br />
            <span class="description">Rackspace filestore region, DFW (Dallas) or ORD (Chicago).</span>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><label for="cfcdn[url]">API Version URL</label></th>
          <td>
            <input name="cfcdn[url]" type="text" value="<?= $settings['url'];?>" class="regular-text" required="required" readonly="readonly" />
          </td>
        </tr>


        <tr valign="top">
          <th scope="row"><label for="cfcdn[serviceName]">Service Name</label></th>
          <td>
            <input name="cfcdn[serviceName]" type="text" value="<?= $settings['serviceName'];?>" class="regular-text" required="required" readonly="readonly" />
          </td>
        </tr>



        <tr valign="top">
          <th scope="row"><label for="cfcdn[urltype]">URL Type</label></th>
          <td>
            <input name="cfcdn[urltype]" type="text" value="<?= $settings['urltype'];?>" class="regular-text" required="required" readonly="readonly" />
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
