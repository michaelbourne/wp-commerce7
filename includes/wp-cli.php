<?php
/**
 * WP-CLI Integration for Commerce7 for WordPress
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

// Only load if WP-CLI is available
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Commerce7 WP-CLI Commands
 */
class C7WP_CLI_Command extends WP_CLI_Command {

	/**
	 * Check Commerce7 integration status
	 *
	 * ## EXAMPLES
	 *
	 *     wp c7wp status
	 *
	 * @when after_wp_load
	 */
	public function status( $args, $assoc_args ) {
		$c7wp = C7WP::getInstance();
		$settings = $c7wp->get_settings();

		WP_CLI::line( 'Commerce7 for WordPress Status:' );
		WP_CLI::line( '' );

		// Check tenant ID
		$tenant_id = isset( $settings['c7wp_tenant'] ) ? $settings['c7wp_tenant'] : '';
		if ( empty( $tenant_id ) ) {
			WP_CLI::error( 'Tenant ID is not configured' );
		} else {
			WP_CLI::success( 'Tenant ID: ' . $tenant_id );
		}

		// Check widget version
		$widget_version = isset( $settings['c7wp_widget_version'] ) ? $settings['c7wp_widget_version'] : 'v2';
		WP_CLI::line( 'Widget Version: ' . $widget_version );

		// Check required pages
		$pages_needing_content = $c7wp->get_pages_needing_c7_content();
		if ( empty( $pages_needing_content ) ) {
			WP_CLI::success( 'All required pages have proper Commerce7 content' );
		} else {
			WP_CLI::warning( 'Pages needing Commerce7 content:' );
			foreach ( $pages_needing_content as $page ) {
				WP_CLI::line( '  - ' . $page->post_title . ' (' . $page->post_name . ')' );
			}
		}

		// Check permalinks
		$permalink_structure = get_option( 'permalink_structure' );
		if ( empty( $permalink_structure ) ) {
			WP_CLI::error( 'Pretty permalinks are not enabled' );
		} else {
			WP_CLI::success( 'Pretty permalinks are enabled' );
		}
	}

	/**
	 * Setup Commerce7 integration
	 *
	 * ## EXAMPLES
	 *
	 *     wp c7wp setup --tenant-id=your-tenant-id
	 *
	 * @when after_wp_load
	 */
	public function setup( $args, $assoc_args ) {
		$tenant_id = isset( $assoc_args['tenant-id'] ) ? $assoc_args['tenant-id'] : '';

		if ( empty( $tenant_id ) ) {
			WP_CLI::error( 'Please provide a tenant ID with --tenant-id=your-tenant-id' );
		}

		$c7wp = C7WP::getInstance();
		$settings = $c7wp->get_settings();

		// Update tenant ID
		$settings['c7wp_tenant'] = sanitize_text_field( $tenant_id );
		update_option( 'c7wp_settings', $settings );
		$c7wp->refresh_settings();

		WP_CLI::success( 'Tenant ID updated to: ' . $tenant_id );

		// Check if pages exist
		$pages_needing_content = $c7wp->get_pages_needing_c7_content();
		if ( ! empty( $pages_needing_content ) ) {
			WP_CLI::warning( 'Some required pages may need Commerce7 content blocks' );
		}

		// Flush rewrite rules
		flush_rewrite_rules();
		WP_CLI::success( 'Rewrite rules flushed' );
	}

	/**
	 * Verify Commerce7 integration
	 *
	 * ## EXAMPLES
	 *
	 *     wp c7wp verify
	 *
	 * @when after_wp_load
	 */
	public function verify( $args, $assoc_args ) {
		$c7wp = C7WP::getInstance();
		$settings = $c7wp->get_settings();

		$issues = array();

		// Check tenant ID
		if ( empty( $settings['c7wp_tenant'] ) ) {
			$issues[] = 'Tenant ID is not configured';
		}

		// Check required pages
		$pages_needing_content = $c7wp->get_pages_needing_c7_content();
		foreach ( $pages_needing_content as $page ) {
			$issues[] = 'Page "' . $page->post_title . '" needs Commerce7 content';
		}

		// Check permalinks
		$permalink_structure = get_option( 'permalink_structure' );
		if ( empty( $permalink_structure ) ) {
			$issues[] = 'Pretty permalinks are not enabled';
		}

		if ( empty( $issues ) ) {
			WP_CLI::success( 'Commerce7 integration is properly configured' );
		} else {
			WP_CLI::error( 'Issues found:' );
			foreach ( $issues as $issue ) {
				WP_CLI::line( '  - ' . $issue );
			}
		}
	}

	/**
	 * Flush Commerce7 cache
	 *
	 * ## EXAMPLES
	 *
	 *     wp c7wp flush-cache
	 *
	 * @when after_wp_load
	 */
	public function flush_cache( $args, $assoc_args ) {
		// Clear remote notices cache
		delete_transient( 'c7wp_remote_notices' );

		// Clear GitHub Gist transients
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_c7wp_%'" );
		$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout_c7wp_%'" );

		// Flush rewrite rules
		flush_rewrite_rules();

		WP_CLI::success( 'Commerce7 cache flushed' );
	}

	/**
	 * Export Commerce7 settings
	 *
	 * ## EXAMPLES
	 *
	 *     wp c7wp export-settings
	 *     wp c7wp export-settings --file=settings.json
	 *
	 * @when after_wp_load
	 */
	public function export_settings( $args, $assoc_args ) {
		$c7wp = C7WP::getInstance();
		$settings = $c7wp->get_settings();

		// Remove sensitive data
		unset( $settings['c7wp_tenant'] );

		$json = wp_json_encode( $settings, JSON_PRETTY_PRINT );

		$filename = isset( $assoc_args['file'] ) ? $assoc_args['file'] : 'c7wp-settings-' . date( 'Y-m-d' ) . '.json';

		if ( file_put_contents( $filename, $json ) ) {
			WP_CLI::success( 'Settings exported to: ' . $filename );
		} else {
			WP_CLI::error( 'Failed to export settings' );
		}
	}

	/**
	 * Import Commerce7 settings
	 *
	 * ## EXAMPLES
	 *
	 *     wp c7wp import-settings --file=settings.json
	 *
	 * @when after_wp_load
	 */
	public function import_settings( $args, $assoc_args ) {
		$filename = isset( $assoc_args['file'] ) ? $assoc_args['file'] : '';

		if ( empty( $filename ) || ! file_exists( $filename ) ) {
			WP_CLI::error( 'Please provide a valid settings file with --file=filename.json' );
		}

		$json = file_get_contents( $filename );
		$settings = json_decode( $json, true );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			WP_CLI::error( 'Invalid JSON file: ' . json_last_error_msg() );
		}

		// Merge with existing settings to preserve tenant ID
		$c7wp = C7WP::getInstance();
		$existing_settings = $c7wp->get_settings();
		$settings = array_merge( $existing_settings, $settings );

		update_option( 'c7wp_settings', $settings );
		$c7wp->refresh_settings();

		WP_CLI::success( 'Settings imported from: ' . $filename );
	}
}

// Register the WP-CLI command
WP_CLI::add_command( 'c7wp', 'C7WP_CLI_Command' );
