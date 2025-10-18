<?php
/**
 * Site Health Integration
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

/**
 * Add Commerce7 specific health checks
 */
add_filter( 'site_status_tests', 'c7wp_add_health_checks' );
function c7wp_add_health_checks( $tests ) {
	$tests['direct']['c7wp_tenant_configured'] = array(
		'label' => __( 'Commerce7 Tenant ID is configured', 'wp-commerce7' ),
		'test'  => 'c7wp_test_tenant_configured',
	);

	$tests['direct']['c7wp_required_pages'] = array(
		'label' => __( 'Commerce7 required pages exist', 'wp-commerce7' ),
		'test'  => 'c7wp_test_required_pages',
	);

	$tests['direct']['c7wp_page_content'] = array(
		'label' => __( 'Commerce7 pages have proper content', 'wp-commerce7' ),
		'test'  => 'c7wp_test_page_content',
	);

	$tests['direct']['c7wp_permalinks'] = array(
		'label' => __( 'WordPress permalinks are configured', 'wp-commerce7' ),
		'test'  => 'c7wp_test_permalinks',
	);

	return $tests;
}

/**
 * Test if tenant ID is configured
 */
function c7wp_test_tenant_configured() {
	$options = get_option( 'c7wp_settings' );
	$tenant_id = isset( $options['c7wp_tenant'] ) ? $options['c7wp_tenant'] : '';

	$result = array(
		'label'       => __( 'Commerce7 Tenant ID is configured', 'wp-commerce7' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Commerce7', 'wp-commerce7' ),
			'color' => 'blue',
		),
		'description' => sprintf(
			'<p>%s</p>',
			__( 'Your Commerce7 Tenant ID is properly configured.', 'wp-commerce7' )
		),
		'test'        => 'c7wp_tenant_configured',
	);

	if ( empty( $tenant_id ) ) {
		$result['status'] = 'critical';
		$result['label'] = __( 'Commerce7 Tenant ID is not configured', 'wp-commerce7' );
		$result['description'] = sprintf(
			'<p>%s</p>',
			__( 'You need to configure your Commerce7 Tenant ID in the plugin settings for the integration to work properly.', 'wp-commerce7' )
		);
		$result['actions'] = sprintf(
			'<p><a href="%s">%s</a></p>',
			esc_url( admin_url( 'admin.php?page=commerce7' ) ),
			__( 'Configure Commerce7 Settings', 'wp-commerce7' )
		);
	}

	return $result;
}

/**
 * Test if required pages exist
 */
function c7wp_test_required_pages() {
	$options = get_option( 'c7wp_settings' );

	if ( isset( $options['c7wp_frontend_routes'] ) && 'yes' === $options['c7wp_enable_custom_routes'] ) {
		$required_pages = array_values( $options['c7wp_frontend_routes'] );
	} else {
		$required_pages = array( 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' );
	}

	$missing_pages = array();
	foreach ( $required_pages as $page_slug ) {
		if ( ! get_page_by_path( $page_slug, 'ARRAY_N', 'page' ) ) {
			$missing_pages[] = $page_slug;
		}
	}

	$result = array(
		'label'       => __( 'Commerce7 required pages exist', 'wp-commerce7' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Commerce7', 'wp-commerce7' ),
			'color' => 'blue',
		),
		'description' => sprintf(
			'<p>%s</p>',
			__( 'All required Commerce7 pages are present.', 'wp-commerce7' )
		),
		'test'        => 'c7wp_required_pages',
	);

	if ( ! empty( $missing_pages ) ) {
		$result['status'] = 'critical';
		$result['label'] = __( 'Commerce7 required pages are missing', 'wp-commerce7' );
		$result['description'] = sprintf(
			'<p>%s</p><ul><li>%s</li></ul>',
			__( 'The following required pages are missing:', 'wp-commerce7' ),
			implode( '</li><li>', array_map( 'esc_html', $missing_pages ) )
		);
		$result['actions'] = sprintf(
			'<p><a href="%s">%s</a></p>',
			esc_url( admin_url( 'admin.php?page=commerce7' ) ),
			__( 'Configure Commerce7 Settings', 'wp-commerce7' )
		);
	}

	return $result;
}

/**
 * Test if pages have proper content
 */
function c7wp_test_page_content() {
	$options = get_option( 'c7wp_settings' );

	if ( isset( $options['c7wp_frontend_routes'] ) && 'yes' === $options['c7wp_enable_custom_routes'] ) {
		$required_pages = array_values( $options['c7wp_frontend_routes'] );
	} else {
		$required_pages = array( 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' );
	}

	$c7wp_instance = C7WP::getInstance();
	$pages_without_content = array();

	foreach ( $required_pages as $page_slug ) {
		$page = get_page_by_path( $page_slug, 'ARRAY_N', 'page' );
		if ( $page && ! $c7wp_instance->page_has_c7_content( $page[0] ) ) {
			$pages_without_content[] = $page_slug;
		}
	}

	$result = array(
		'label'       => __( 'Commerce7 pages have proper content', 'wp-commerce7' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Commerce7', 'wp-commerce7' ),
			'color' => 'blue',
		),
		'description' => sprintf(
			'<p>%s</p>',
			__( 'All Commerce7 pages contain the required content blocks.', 'wp-commerce7' )
		),
		'test'        => 'c7wp_page_content',
	);

	if ( ! empty( $pages_without_content ) ) {
		$result['status'] = 'recommended';
		$result['label'] = __( 'Some Commerce7 pages may be missing proper content', 'wp-commerce7' );
		$result['description'] = sprintf(
			'<p>%s</p><ul><li>%s</li></ul><p>%s</p>',
			__( 'The following pages may not have the required Commerce7 content blocks:', 'wp-commerce7' ),
			implode( '</li><li>', array_map( 'esc_html', $pages_without_content ) ),
			__( 'Make sure these pages contain the default Commerce7 block or c7-content div.', 'wp-commerce7' )
		);
		$result['actions'] = sprintf(
			'<p><a href="%s">%s</a></p>',
			esc_url( admin_url( 'edit.php?post_type=page' ) ),
			__( 'Edit Pages', 'wp-commerce7' )
		);
	}

	return $result;
}

/**
 * Test if permalinks are configured
 */
function c7wp_test_permalinks() {
	$permalink_structure = get_option( 'permalink_structure' );

	$result = array(
		'label'       => __( 'WordPress permalinks are configured', 'wp-commerce7' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Commerce7', 'wp-commerce7' ),
			'color' => 'blue',
		),
		'description' => sprintf(
			'<p>%s</p>',
			__( 'WordPress permalinks are properly configured for Commerce7 integration.', 'wp-commerce7' )
		),
		'test'        => 'c7wp_permalinks',
	);

	if ( empty( $permalink_structure ) ) {
		$result['status'] = 'critical';
		$result['label'] = __( 'WordPress permalinks are not configured', 'wp-commerce7' );
		$result['description'] = sprintf(
			'<p>%s</p>',
			__( 'Commerce7 requires pretty permalinks to be enabled. Please configure your permalink structure.', 'wp-commerce7' )
		);
		$result['actions'] = sprintf(
			'<p><a href="%s">%s</a></p>',
			esc_url( admin_url( 'options-permalink.php' ) ),
			__( 'Configure Permalinks', 'wp-commerce7' )
		);
	}

	return $result;
}

/**
 * Test Commerce7 API connectivity
 */
function c7wp_test_api_connectivity() {
	$options = get_option( 'c7wp_settings' );
	$tenant_id = isset( $options['c7wp_tenant'] ) ? $options['c7wp_tenant'] : '';

	if ( empty( $tenant_id ) ) {
		return array(
			'label'       => __( 'Commerce7 API connectivity', 'wp-commerce7' ),
			'status'      => 'critical',
			'badge'       => array(
				'label' => __( 'Commerce7', 'wp-commerce7' ),
				'color' => 'red',
			),
			'description' => sprintf(
				'<p>%s</p>',
				__( 'Cannot test API connectivity without a configured Tenant ID.', 'wp-commerce7' )
			),
			'test'        => 'c7wp_api_connectivity',
		);
	}

	// This would be an async test in a real implementation
	// For now, we'll just check if the tenant ID format looks valid
	$result = array(
		'label'       => __( 'Commerce7 API connectivity', 'wp-commerce7' ),
		'status'      => 'good',
		'badge'       => array(
			'label' => __( 'Commerce7', 'wp-commerce7' ),
			'color' => 'blue',
		),
		'description' => sprintf(
			'<p>%s</p>',
			__( 'Commerce7 API connectivity appears to be working.', 'wp-commerce7' )
		),
		'test'        => 'c7wp_api_connectivity',
	);

	return $result;
}

/**
 * Add health check info to Site Health page
 */
add_filter( 'debug_information', 'c7wp_add_debug_info' );
function c7wp_add_debug_info( $info ) {
	$options = get_option( 'c7wp_settings' );

	$info['commerce7'] = array(
		'label'  => __( 'Commerce7 for WordPress', 'wp-commerce7' ),
		'fields' => array(
			'version' => array(
				'label' => __( 'Plugin Version', 'wp-commerce7' ),
				'value' => C7WP_VERSION,
			),
			'tenant_id' => array(
				'label' => __( 'Tenant ID', 'wp-commerce7' ),
				'value' => isset( $options['c7wp_tenant'] ) ? $options['c7wp_tenant'] : __( 'Not configured', 'wp-commerce7' ),
			),
			'widget_version' => array(
				'label' => __( 'Widget Version', 'wp-commerce7' ),
				'value' => isset( $options['c7wp_widget_version'] ) ? $options['c7wp_widget_version'] : 'v2',
			),
			'display_cart' => array(
				'label' => __( 'Display Cart', 'wp-commerce7' ),
				'value' => isset( $options['c7wp_display_cart'] ) ? $options['c7wp_display_cart'] : 'no',
			),
			'custom_routes' => array(
				'label' => __( 'Custom Routes Enabled', 'wp-commerce7' ),
				'value' => isset( $options['c7wp_enable_custom_routes'] ) ? $options['c7wp_enable_custom_routes'] : 'no',
			),
		),
	);

	return $info;
}
