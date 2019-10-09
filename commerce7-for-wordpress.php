<?php
/*
Plugin Name: Commerce7 for WordPress
Description: Integrate Commerce7 functionality into your WordPress site easily
Version:     1.0.5
Author:      Michael Bourne
Author URI:  https://ursa6.com
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
Text Domain: commerce7-for-wordpress
Domain Path: /languages
*/
/*
Commerce7 for WordPress is a plugin for WordPress that enables you to add Commerce7 ecommerce integration into your site.

Copyright (c) 2019 Michael Bourne. Plugin developed with the cooperation of the Commerce7 company. Commerce7 logo and name used with permission.

The Commerce7 for WordPress  Plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>

You can contact me at michael@ursa6.com
*/

if (! defined('ABSPATH')) {
    return;
}

defined('C7WP_ROOT') or define('C7WP_ROOT', dirname(__FILE__));
defined('C7WP_URI') or define('C7WP_URI', plugin_dir_url(__FILE__));
defined('C7WP_VERSION') or define('C7WP_VERSION', '1.0.5');


/**
 * On plugin activation
 * 1. Create the pages needed for integration to work
 * 2. Inject content into those pages
 * 3. Set privacy policy pag
 */
function c7wp_activate_plugin()
{
    add_option('c7wp_activation', true);

    $pages = array('profile', 'collection', 'product', 'club', 'checkout', 'cart', 'privacy', 'terms', 'reservation');
    $fail = array();

    foreach ($pages as $page) {
        if (get_page_by_path($page, 'ARRAY_N', 'page')) {
            $fail[] = $page;
            continue;
        }

        if ($page == 'terms') {
            $c7_post = array(
            'post_title'    => wp_strip_all_tags(ucfirst($page)),
            'post_content'  => 'Please enter your company\'s terms and conditions.',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            );
        } elseif ($page == 'privacy') {
            $c7_post = array(
            'post_title'    => wp_strip_all_tags(ucfirst($page)),
            'post_content'  => 'Please enter your company\'s privacy policy as per your local laws.',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            );
        } else {
            $c7_post = array(
            'post_title'    => wp_strip_all_tags(ucfirst($page)),
            'post_content'  => '<div id="c7-content"></div>',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            );
        }

        $pageid = wp_insert_post($c7_post);

        if ($page == 'privacy') {
            update_option('wp_page_for_privacy_policy', $pageid);
        }
    }

    if (!empty($fail)) {
        set_transient('c7wp-admin-notice-pages', $fail, 5);
    }

    $c7options = array(
                    'c7wp_tenant' => '',
                    'c7wp_display_cart' => 'yes',
                    'c7wp_display_cart_location' => 'tr',
                    'c7wp_display_cart_color' => 'light');

    update_option('c7wp_settings', $c7options);

    // set a default permalink structure if the installation has not yet done this
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    if ( function_exists( 'wp_install_maybe_enable_pretty_permalinks' ) ) wp_install_maybe_enable_pretty_permalinks();
}
register_activation_hook(__FILE__, 'c7wp_activate_plugin');

/**
 * On plugin upgrade
 */

add_action('upgrader_process_complete', 'c7wp_upgrade_function', 10, 2);

function c7wp_upgrade_function($upgrader_object, $options)
{
    $current_plugin_path_name = plugin_basename(__FILE__);

    if ($options['action'] == 'update' && $options['type'] == 'plugin') {
        foreach ($options['plugins'] as $each_plugin) {
            if ($each_plugin == $current_plugin_path_name) {
                $pages = array('profile', 'collection', 'product', 'club', 'checkout', 'cart', 'privacy', 'terms', 'reservation');
                $fail = array();
                foreach ($pages as $page) {
                    if (!get_page_by_path($page, 'ARRAY_N', 'page')) {
                        $fail[] = $page;

                        $c7_post = array(
                          'post_title'    => wp_strip_all_tags(ucfirst($page)),
                          'post_content'  => '<div id="c7-content"></div>',
                          'post_status'   => 'publish',
                          'post_author'   => 1,
                          'post_type'     => 'page',
                        );
                        $pageid = wp_insert_post($c7_post);
                        continue;
                    }
                }

                if (!empty($fail)) {
                    set_transient('c7wp-admin-notice-pages-missing', $fail, 0);
                }
            }
        }
    }
}


/**
 * Notices
 */

function c7wp_admin_notice_pages()
{

    if ($data = get_transient('c7wp-admin-notice-pages')) {
        $pages = implode(', ', $data);
        echo<<<EOF
   			<div class="notice notice-warning is-dismissible">
            	<p>Commerce7 for WordPress requires specific pages exist in order for integration to work properly. The following pages were not created as they already exist: <strong>$pages</strong>. Please edit the slugs of these pages to keep your existing content, and then create new pages with these slugs: <strong>$pages</strong>.</p>
        	</div>
EOF;
        /* Delete transient, only display this notice once. */
        delete_transient('c7wp-admin-notice-pages');
    }

    if ($data = get_transient('c7wp-admin-notice-pages-missing')) {
        $pages = implode(', ', $data);
        echo<<<EOF
        <div class="notice notice-warning is-dismissible">
              <p>Commerce7 for WordPress requires specific pages exist in order for integration to work properly. The following pages were missing: <strong>$pages</strong>. These pages have been recreated and populated with the proper HTML needed to render Commerce7 content.</p>
          </div>
EOF;
        /* Delete transient, only display this notice once. */
        delete_transient('c7wp-admin-notice-pages-missing');
    }
}
add_action('admin_notices', 'c7wp_admin_notice_pages');


/**
 * On plugin deactivation
 * 1. Flush rewrite rules to clear redirects
 */
function c7wp_deactivate_plugin()
{
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'c7wp_deactivate_plugin');


// load plugin
require_once('class-c7wp.php');
