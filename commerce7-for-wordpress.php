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
 * Version: 1.5.2
 * Author: URSA6 & 5forests
 * Author URI: https://5forests.com
 * Plugin URI: https://c7wp.com
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Stable tag: 1.5.2
 * Requires PHP: 7.4
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: wp-commerce7
 * Domain Path: /languages
 *
 * Created Date: Friday September 27th 2019
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, June 5th 2025, 5:16:01 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2019-2025 URSA6
 *
 * Commerce7 for WordPress is a plugin for WordPress that enables you to add Commerce7 ecommerce integration into your site.
 * Plugin developed with permission of the Commerce7 company. Commerce7 logo and name used with permission.
 * The Commerce7 for WordPress  Plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License or (at your option) any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>
 * You can contact me at michael@ursa6.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}


defined( 'C7WP_ROOT' ) || define( 'C7WP_ROOT', __DIR__ );
defined( 'C7WP_URI' ) || define( 'C7WP_URI', plugin_dir_url( __FILE__ ) );
defined( 'C7WP_VERSION' ) || define( 'C7WP_VERSION', '1.5.2' );
if ( ! defined( 'C7WP_NOTICES_URL' ) || C7WP_NOTICES_URL !== 'https://c7wp.com/notices.json' ) {
    define( 'C7WP_NOTICES_URL', 'https://c7wp.com/notices.json' );
}


/**
 * On plugin activation
 * 1. Create the pages needed for integration to work
 * 2. Inject content into those pages
 * 3. Set privacy policy page
 */
function c7wp_activate_plugin() {
    add_option( 'c7wp_activation', true );

    $pages = array( 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' );
    $fail  = array();

    foreach ( $pages as $page ) {
        if ( get_page_by_path( $page, 'ARRAY_N', 'page' ) ) {
            $fail[] = $page;
            continue;
        }

        $c7_post = array(
        'post_title'   => wp_strip_all_tags( ucfirst( $page ) ),
        'post_content' => '<!-- wp:c7wp/default --><div class="wp-block-c7wp-default"><div id="c7-content"></div></div><!-- /wp:c7wp/default -->',
        'post_status'  => 'publish',
        'post_author'  => 1,
        'post_type'    => 'page',
        );

        $pageid = wp_insert_post( $c7_post );
    }

    if ( ! empty( $fail ) ) {
        set_transient( 'c7wp-admin-notice-pages', $fail, 5 );
    }

    $c7options = array(
                    'c7wp_tenant'                => '',
                    'c7wp_display_cart'          => 'no',
                    'c7wp_display_cart_location' => 'tr',
                    'c7wp_display_cart_color'    => 'light',
                    'c7wp_widget_version'        => 'v2',
                    'c7wp_enable_custom_routes'  => 'no',
                    'c7wp_frontend_routes'       => array(
                        'profile'     => 'profile',
                        'collection'  => 'collection',
                        'product'     => 'product',
                        'club'        => 'club',
                        'checkout'    => 'checkout',
                        'cart'        => 'cart',
                        'reservation' => 'reservation',
                    ),
                );

    update_option( 'c7wp_settings', $c7options, true );

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
    if ( 'update' === $options['action'] && 'plugin' === $options['type'] && isset( $options['plugins'] ) ) {
        foreach ( $options['plugins'] as $each_plugin ) {
            // If the plugin being updated is this plugin.
            if ( $each_plugin == $current_plugin_path_name ) { // phpcs:ignore

                $options = get_option( 'c7wp_settings' );

                if ( isset( $options['c7wp_widget_version'] ) && 'v2' === $options['c7wp_widget_version']
                  && isset( $options['c7wp_enable_custom_routes'] ) && 'yes' === $options['c7wp_enable_custom_routes']
                  && isset( $options['c7wp_frontend_routes'] ) && is_array( $options['c7wp_frontend_routes'] ) ) {
                    $pages = $options['c7wp_frontend_routes'];
                } else {
                    $pages = array(
                        'profile'     => 'profile',
                        'collection'  => 'collection',
                        'product'     => 'product',
                        'club'        => 'club',
                        'checkout'    => 'checkout',
                        'cart'        => 'cart',
                        'reservation' => 'reservation',
                    );
                }

                $fail = array();
                // Loop through required paged for C7.
                foreach ( $pages as $page => $slug ) {
                    // if the page is missing, add it to the notice
                    if ( ! get_page_by_path( $slug, 'ARRAY_N', 'page' ) ) {
                        $fail[] = wp_strip_all_tags( ucfirst( $page ) );
                        continue;
                    }
                }

                // If we have missing pages, let's set a transient to display a notice.
                if ( ! empty( $fail ) ) {
                    set_transient( 'c7wp-admin-notice-pages-missing', $fail, 0 );
                }

                $c7options = array(
                    'c7wp_tenant'                => '',
                    'c7wp_display_cart'          => 'no',
                    'c7wp_display_cart_location' => 'tr',
                    'c7wp_display_cart_color'    => 'light',
                    'c7wp_widget_version'        => 'v2',
                    'c7wp_enable_custom_routes'  => 'no',
                    'c7wp_frontend_routes'       => array(
                        'profile'     => 'profile',
                        'collection'  => 'collection',
                        'product'     => 'product',
                        'club'        => 'club',
                        'checkout'    => 'checkout',
                        'cart'        => 'cart',
                        'reservation' => 'reservation',
                    ),
                );

                // Merge client set options with default options to fix any unset array keys.
                $normalized_options = array_merge( $c7options, $options );
                update_option( 'c7wp_settings', $normalized_options, true );

                // flush rewrite rules.
                if ( function_exists( 'flush_rewrite_rules' ) ) {
                    flush_rewrite_rules();
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
            esc_html__( 'Commerce7 requires specific pages exist in order for integration to work properly. The following pages were missing: %s.  
            These pages were not recreated in case you have removed them on purpose. Please review and crate these pages if needed.', 'wp-commerce7' ),
            '<strong>' . esc_html( $pages ) . '</strong>'
        );
        echo '</p></div>';

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

function commerce7_wp_manager() {
	return C7WP::getInstance();
}

commerce7_wp_manager();

/**
 * Fetch and display remote admin notices
 */
function c7wp_remote_notices() {
    $transient_key = 'c7wp_remote_notices';
    $notices = get_transient( $transient_key );

    if ( false === $notices ) {
        $response = wp_remote_get( C7WP_NOTICES_URL );

        if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
            $notices = json_decode( wp_remote_retrieve_body( $response ), true );
            set_transient( $transient_key, $notices, 12 * HOUR_IN_SECONDS );
        }
    }

    if ( ! empty( $notices ) && is_array( $notices ) ) {
        foreach ( $notices as $notice ) {
            if ( ! empty( $notice['message'] ) && ! get_user_meta( get_current_user_id(), 'c7wp_notice_dismissed_' . md5( $notice['message'] ), true ) ) {
                add_action('admin_notices', function() use ( $notice ) {
                    $dismiss_url = add_query_arg(array(
                        'c7wp_dismiss_notice' => md5( $notice['message'] ),
                        '_wpnonce' => wp_create_nonce( 'c7wp_dismiss_notice' ),
                    ));
                    ?>
                    <div class="notice notice-<?php echo esc_attr( $notice['type'] ?? 'info' ); ?> is-dismissible">
                        <?php if ( ! empty( $notice['format'] ) && 'html' === $notice['format'] ) : ?>
                            <?php echo wp_kses_post( $notice['message'] ); ?>
                        <?php else : ?>
                            <p><?php echo wp_kses_post( $notice['message'] ); ?></p>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( $dismiss_url ); ?>" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'wp-commerce7' ); ?></span></a>
                    </div>
                    <?php
                });
            }
        }
    }
}
add_action( 'admin_init', 'c7wp_remote_notices' );

/**
 * Handle notice dismissal
 */
function c7wp_handle_notice_dismissal() {
    if ( isset( $_GET['c7wp_dismiss_notice'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( wp_unslash( $_GET['_wpnonce'] ), 'c7wp_dismiss_notice' ) ) {
        $notice_id = sanitize_text_field( wp_unslash( $_GET['c7wp_dismiss_notice'] ) );
        update_user_meta( get_current_user_id(), 'c7wp_notice_dismissed_' . $notice_id, true );
        wp_safe_redirect( remove_query_arg( array( 'c7wp_dismiss_notice', '_wpnonce' ) ) );
        exit;
    }
}
add_action( 'admin_init', 'c7wp_handle_notice_dismissal' );
