<?php
/**
 * Integrate Commerce7 functionality into your WordPress site easily
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Commerce7 for WordPress
 * Description: Integrate Commerce7 functionality into your WordPress site easily
 * Version: 1.1.3
 * Author: Michael Bourne
 * Author URI: https://ursa6.com
 * Requires at least: 5.3
 * Tested up to: 5.7.1
 * Stable tag: 1.1.23
 * Requires PHP: 7.2
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: wp-commerce7
 * Domain Path: /languages
 *
 * Created Date: Friday September 27th 2019
 * Author: Michael Bourne
 * -----
 * Last Modified: Tuesday, April 13th 2021, 1:17:42 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2019 URSA6
 *
 * Commerce7 for WordPress is a plugin for WordPress that enables you to add Commerce7 ecommerce integration into your site.
 * Plugin developed with the cooperation of the Commerce7 company. Commerce7 logo and name used with permission.
 * The Commerce7 for WordPress  Plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>
 * You can contact me at michael@ursa6.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}


defined( 'C7WP_ROOT' ) || define( 'C7WP_ROOT', dirname( __FILE__ ) );
defined( 'C7WP_URI' ) || define( 'C7WP_URI', plugin_dir_url( __FILE__ ) );
defined( 'C7WP_VERSION' ) || define( 'C7WP_VERSION', '1.1.2' );


/**
 * On plugin activation
 * 1. Create the pages needed for integration to work
 * 2. Inject content into those pages
 * 3. Set privacy policy pag
 */
function c7wp_activate_plugin() {
    add_option( 'c7wp_activation', true );

    $pages = [ 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'privacy', 'terms', 'reservation' ];
    $fail  = [];

    foreach ( $pages as $page ) {
        if ( get_page_by_path( $page, 'ARRAY_N', 'page' ) ) {
            $fail[] = $page;
            continue;
        }

        if ( 'terms' === $page ) {
            $c7_post = array(
            'post_title'   => wp_strip_all_tags( ucfirst( $page ) ),
            /* translators: Dummy content for a missing terms page */
            'post_content' => __( '<!-- wp:paragraph --><p>Please enter your terms and conditions.</p><!-- /wp:paragraph -->', 'wp-commerce7' ),
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
            );
        } elseif ( 'privacy' === $page ) {
            $c7_post = array(
            'post_title'   => wp_strip_all_tags( ucfirst( $page ) ),
            /* translators: Dummy content for a missing privacy page */
            'post_content' => __( '<!-- wp:paragraph --><p>Please enter your privacy policy as per your local laws.</p><!-- /wp:paragraph -->', 'wp-commerce7' ),
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
            );
        } else {
            $c7_post = array(
            'post_title'   => wp_strip_all_tags( ucfirst( $page ) ),
            'post_content' => '<!-- wp:c7wp/default --><div class="wp-block-c7wp-default"><div id="c7-content"></div></div><!-- /wp:c7wp/default -->',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
            );
        }

        $pageid = wp_insert_post( $c7_post );

        if ( 'privacy' === $page ) {
            update_option( 'wp_page_for_privacy_policy', $pageid );
        }
    }

    if ( ! empty( $fail ) ) {
        set_transient( 'c7wp-admin-notice-pages', $fail, 5 );
    }

    $c7options = array(
                    'c7wp_tenant'                => '',
                    'c7wp_display_cart'          => 'yes',
                    'c7wp_display_cart_location' => 'tr',
                    'c7wp_display_cart_color'    => 'light',
                    'c7wp_widget_version'        => 'v1',
                );

    update_option( 'c7wp_settings', $c7options );

    // set a default permalink structure if the installation has not yet done this
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    if ( function_exists( 'wp_install_maybe_enable_pretty_permalinks' ) ) {
        wp_install_maybe_enable_pretty_permalinks();
    }
}
register_activation_hook( __FILE__, 'c7wp_activate_plugin' );

/**
 * On plugin upgrade
 */

add_action( 'upgrader_process_complete', 'c7wp_upgrade_function', 10, 2 );
/**
 * Upgrade function
 *
 * @see https://developer.wordpress.org/reference/hooks/upgrader_process_complete/
 *
 * @param object $upgrader_object WP_Upgrader instance.
 * @param array  $options Array of bulk item update data.
 * @return void
 */
function c7wp_upgrade_function( $upgrader_object, $options ) {
    $current_plugin_path_name = plugin_basename( __FILE__ );

    // If a plugin is being updated.
    if ( 'update' === $options['action'] && 'plugin' === $options['type'] ) {
        foreach ( $options['plugins'] as $each_plugin ) {
            // If the plugin being updated is this plugin.
            if ( $each_plugin == $current_plugin_path_name ) { // phpcs:ignore
                $pages = [ 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' ];
                $fail  = [];
                // Loop through required paged for C7.
                foreach ( $pages as $page ) {
                    // if the page is missing, let's just make it.
                    if ( ! get_page_by_path( $page, 'ARRAY_N', 'page' ) ) {
                        $fail[] = $page;

                        $c7_post = array(
                          'post_title'   => wp_strip_all_tags( ucfirst( $page ) ),
                          'post_content' => '<div id="c7-content"></div>',
                          'post_status'  => 'publish',
                          'post_author'  => 1,
                          'post_type'    => 'page',
                        );
                        $pageid  = wp_insert_post( $c7_post );
                        continue;
                    }
                }

                if ( ! empty( $fail ) ) {
                    set_transient( 'c7wp-admin-notice-pages-missing', $fail, 0 );
                }
            }
        }
    }
}


/**
 * Notices
 */
function c7wp_admin_notice_pages() {

    if ( $data = get_transient( 'c7wp-admin-notice-pages' ) ) { // phpcs:ignore
        $pages = implode( ', ', $data );
        echo '<div class="notice notice-warning is-dismissible"><p>';
        printf(
            /* translators: 1: List of missing pages 2: List of missing pages */
            esc_html__( 'Commerce7 requires specific pages exist in order for integration to work properly. The following pages are needed but were not created, as they already exist: %1$s. 
            Please ensure these pages contain the proper content.', 'wp-commerce7' ),
            '<strong>' . esc_html( $pages ) . '</strong>'
        );
        echo '</p></div>';

        /* Delete transient, only display this notice once. */
        delete_transient( 'c7wp-admin-notice-pages' );
    }

    if ( $data = get_transient( 'c7wp-admin-notice-pages-missing' ) ) { // phpcs:ignore
        $pages = implode( ', ', $data );
        echo '<div class="notice notice-warning is-dismissible"><p>';
        printf(
            /* translators: %s: List of missing pages */
            esc_html__( 'Commerce7 for WordPress requires specific pages exist in order for integration to work properly. The following pages were missing: %s.  
            These pages have been recreated and populated with the proper HTML needed to render Commerce7 content.', 'wp-commerce7' ),
            '<strong>' . esc_html( $pages ) . '</strong>'
        );
        echo '</p></div>';
EOF;
        /* Delete transient, only display this notice once. */
        delete_transient( 'c7wp-admin-notice-pages-missing' );
    }
}
add_action( 'admin_notices', 'c7wp_admin_notice_pages' );


/**
 * On plugin deactivation
 * 1. Flush rewrite rules to clear redirects
 */
function c7wp_deactivate_plugin() {
    flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'c7wp_deactivate_plugin' );


// load plugin
require_once 'includes/class-c7wp.php';
