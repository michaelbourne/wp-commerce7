<?php
/**
 * Uninstall script for Commerce7 for WordPress
 *
 * This file is executed when the plugin is uninstalled (deleted).
 * It removes all plugin data from the database.
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.5.5
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Check user permissions
if ( ! current_user_can( 'activate_plugins' ) ) {
	return;
}

// Remove plugin options
delete_option( 'c7wp_settings' );
delete_option( 'c7wp_activation' );

// Remove transients
delete_transient( 'c7wp_remote_notices' );
delete_transient( 'c7wp-admin-notice-pages' );
delete_transient( 'c7wp-admin-notice-pages-missing' );

// Remove GitHub Gist transients (these have dynamic names)
global $wpdb;
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_c7wp_%'" );
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_c7wp_%'" );

// Remove user meta for dismissed notices
$wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE 'c7wp_notice_dismissed_%'" );

// Clear scheduled cron jobs
wp_clear_scheduled_hook( 'c7wp_fetch_remote_notices' );

// Optionally remove created pages (with user confirmation via filter)
if ( apply_filters( 'c7wp_uninstall_remove_pages', false ) ) {
	$pages_to_remove = array( 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' );

	foreach ( $pages_to_remove as $page_slug ) {
		$page_obj = get_page_by_path( $page_slug, OBJECT, 'page' );
		if ( $page_obj ) {
			wp_delete_post( $page_obj->ID, true ); // true = force delete (bypass trash)
		}
	}
}

// Flush rewrite rules to clean up custom routes
flush_rewrite_rules();
