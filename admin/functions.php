<?php

/**
 *  Create admin pages for plugin management.
 */
function cfcdn_manage(){require_once(CFCDN_PATH . "admin/manage.php");}
function cfcdn_admin_pages() {
  if (current_user_can('manage_options')) {
    add_menu_page("Rackspace CloudFiles CDN", "Cloufiles CDN", "publish_posts", "cfcdn-manage", "cfcdn_manage");
  }
}add_action('admin_menu', 'cfcdn_admin_pages');

?>
