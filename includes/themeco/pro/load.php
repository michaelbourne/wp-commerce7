<?php
/**
 * Themeco Pro element integration.
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/themeco/pro/class-c7wp-themeco-pro.php';

/**
 * Register Commerce7 Pro elements.
 */
function c7wp_themeco_pro_register_elements() {
	C7WP_Themeco_Pro::register_elements( C7WP::getInstance()->get_widgetsver() );
}
add_action( 'cs_register_elements', 'c7wp_themeco_pro_register_elements' );

/**
 * Register Commerce7 icon for Pro builder.
 *
 * @param array $icon_map Icon map.
 * @return array
 */
function c7wp_themeco_pro_icon_map( $icon_map ) {
	$icon_map['commerce7'] = C7WP_URI . 'assets/c7.svg';
	return $icon_map;
}
add_filter( 'cs_icon_map', 'c7wp_themeco_pro_icon_map' );
