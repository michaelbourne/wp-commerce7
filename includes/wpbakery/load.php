<?php
/**
 * WP Bakery Integration
 *
 * @package   wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! function_exists( 'vc_map' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/wpbakery/class-c7wp-wpbakery.php';
C7WP_Widgets::register_clubselector_assets( C7WP::getInstance() );
C7WP_Widgets::register_clubselector_v2_assets( C7WP::getInstance() );

add_action( 'admin_enqueue_scripts', array( 'C7WP_WPBakery', 'enqueue_assets' ) );
add_action( 'vc_backend_editor_enqueue_js_css', array( 'C7WP_WPBakery', 'enqueue_assets' ) );
add_action( 'vc_frontend_editor_enqueue_js_css', array( 'C7WP_WPBakery', 'enqueue_assets' ) );

require_once C7WP_ROOT . '/includes/wpbakery/wpbakery-legacy.php';

$elements = C7WP_Widgets::get_slugs_for_version( $this->widgetsver, 'wpbakery' );

foreach ( $elements as $element ) {
	require_once C7WP_ROOT . '/includes/wpbakery/wpbakery-' . $element . '.php';
}
