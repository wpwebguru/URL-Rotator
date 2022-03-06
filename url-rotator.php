<?php

/*
  Plugin Name: URL Rotator
  Plugin URI: https://github.com/wpwebguru/URL-Rotator
  Description: URL Rotator Manager
  Version: 1.0
  Author: Sunny
  Author URI:  https://github.com/wpwebguru
  License: GPL2
 * 
 */

if (!class_exists('URL_Rotator_mgs')) {

   class URL_Rotator_mgs {

      /**
       * Construct the plugin object
       */
      public function __construct() {
         // register actions
         add_action('admin_menu', array(&$this, 'add_menu'));
         add_action('admin_init', array(&$this, 'admin_init'));

         add_action('init', array(&$this, 'url_rotator_mgs_init'));
      }

      /**
       * Activate the plugin
       */
      public static function activate() {
         add_option('url_rotator_mgs_map', array());
      }

      /**
       * Deactivate the plugin
       */
      public static function deactivate() {
         // Do nothing
      }

      /**
       * hook into WP's admin_init action hook
       */
      public function admin_init() {
         // Set up the settings for this plugin
         // register the settings for this plugin
         register_setting('url_rotator_mgs_option', 'url_rotator_mgs_map');

         /*
          * DELETE
          */
         if (isset($_POST['url_rotator_mgs_delete'])) {
            $map = get_option('url_rotator_mgs_map', array());

            foreach ($map as $key => $value) {
               if ($value['name'] == $_POST['url_rotator_mgs_delete']) {
                  unset($map[$key]);
               }
            }

            update_option('url_rotator_mgs_map', $map);
         }

         /*
          * DELETE URL
          */
         if (isset($_POST['url_rotator_mgs_delete_url'])) {
            $map = get_option('url_rotator_mgs_map', array());

            foreach ($map as $key => $value) {
               if ($value['name'] == $_POST['url_rotator_mgs_name']) {
                  $url_key = $_POST['url_rotator_mgs_key'];
                  unset($map[$key]['link'][$url_key]);

                  foreach ($map[$key]['link'] as $url_key => $link) {
                     $map[$key]['link'][$url_key]['click'] = 0;
                     $map[$key]['link'][$url_key]['next'] = 0;
                  }
                  
                  sort($map[$key]['link']);

               }
            }
            update_option('url_rotator_mgs_map', $map);
         }

         /*
          * RESET
          */
         if (isset($_POST['url_rotator_mgs_reset_submit'])) {
            $map = get_option('url_rotator_mgs_map', array());

            foreach ($map as $key => $value) {
               if ($value['name'] == $_POST['url_rotator_mgs_name']) {
                  foreach ($value['link'] as $url_key => $link) {
                     $link['click'] = 0;

                     $map[$key]['link'][$url_key] = $link;
                  }
               }
            }

            update_option('url_rotator_mgs_map', $map);
         }

         /*
          * NEW INBOUND
          */
         if (isset($_POST['url_rotator_mgs_name']) and $_POST['url_rotator_mgs_name'] != '') {

            $name = sanitize_title($_POST['url_rotator_mgs_name']);
            $save = TRUE;

            $map = get_option('url_rotator_mgs_map', array());

            foreach ($map as $key => $value) {
               if ($value['name'] == $name) {
                  $save = FALSE;
               }
            }

            if ($save) {
               $map = array_reverse($map);
               
               array_push($map, array(
                   'name' => $name,
                   'link' => array()
               ));
               
               $map = array_reverse($map);
            }

            update_option('url_rotator_mgs_map', $map);
         }

         /*
          * NEW OR UPDATE URL
          */
         if (isset($_POST['url_rotator_mgs_new_url_submit']) and $_POST['url_rotator_mgs_new_url_submit'] != '') {

            $name = sanitize_title($_POST['url_rotator_mgs_name']);
            $url = esc_url($_POST['url_rotator_mgs_url'], 'http');
            $save = TRUE;

            $map = get_option('url_rotator_mgs_map', array());

            foreach ($map as $key => $value) {
               if ($value['name'] == $name) {
                  if ($_POST['url_rotator_mgs_key'] != '') {
                     $url_key = $_POST['url_rotator_mgs_key'];
                     $map[$key]['link'][$url_key] = array(
                         'url' => $url,
                         'click' => 0,
                         'next' => false
                     );
                  } else {
                     $map[$key]['link'][] = array(
                         'url' => $url,
                         'click' => 0,
                         'next' => 0
                     );

                     foreach ($map[$key]['link'] as $url_key => $link) {
                        $map[$key]['link'][$url_key]['click'] = 0;
                        $map[$key]['link'][$url_key]['next'] = 0;
                     }
                  }
               }
            }
            update_option('url_rotator_mgs_map', $map);
         }
      }

      /**
       * add a menu
       */
      public function add_menu() {
         add_management_page("URL Rotator", "URL Rotator", "manage_categories", 'wp_url_rotator_mgs', array(&$this, 'url_rotator_mgs_settings_page'));
      }

      public function url_rotator_mgs_settings_page() {
         if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
         }

         $map = get_option('url_rotator_mgs_map', array());

         wp_enqueue_script('', plugins_url('js/admin.js', __FILE__), array('jquery', 'jquery-ui-core', 'wp-color-picker'), time(), true);

         // Render the settings template
         include(sprintf("%s/template.php", dirname(__FILE__)));
      }

      function url_rotator_mgs_init() {
         $name = substr($_SERVER["REQUEST_URI"], 1);

         $map = get_option('url_rotator_mgs_map', array());

         foreach ($map as $key => $value) {

            if ($value['name'] == $name) {
               $id_link = NULL;

               foreach ($value['link'] as $url_key => $link) {
                  if ($link['next']) {
                     $id_link = $url_key;
                  }
               }

               if (is_null($id_link)) {
                  $id_link = 0;
               }

               $value['link'][$id_link]['click'] ++;
               $url = $value['link'][$id_link]['url'];
               $value['link'][$id_link]['next'] = 0;

               if ((count($value['link']) - 1) > $id_link) {
                  $value['link'][++$id_link]['next'] = 1;
               } else {
                  $value['link'][0]['next'] = 1;
               }

               $map[$key] = $value;

               update_option('url_rotator_mgs_map', $map);

               wp_redirect($url);
               exit;
            }
         }
      }

   }

}

if (class_exists('URL_Rotator_mgs')) {
   // Installation and uninstallation hooks
   register_activation_hook(__FILE__, array('URL_Rotator_mgs', 'activate'));
   register_deactivation_hook(__FILE__, array('URL_Rotator_mgs', 'deactivate'));

   // instantiate the plugin class
   $wp_url_rotator_mgs = new URL_Rotator_mgs();

   if (isset($wp_url_rotator_mgs)) {

      // Add the settings link to the plugins page
      function url_rotator_mgs_settings_link($links) {
         $settings_link = '<a href="tools.php?page=wp_url_rotator_mgs">Settings</a>';
         array_unshift($links, $settings_link);
         return $links;
      }

      $plugin = plugin_basename(__FILE__);
      add_filter("plugin_action_links_$plugin", 'url_rotator_mgs_settings_link');
   }
}   