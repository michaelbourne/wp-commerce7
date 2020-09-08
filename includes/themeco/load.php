<?php
/**
 * Cornerstone / Pro Theme Integration
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}


/**
 * Register our element
 */
function c7wp_element_register_elements() {
	cornerstone_register_element( 'C7WP_csElement', 'commerce7', C7WP_ROOT . '/includes/themeco/cornerstone' );
}
add_action( 'cornerstone_register_elements', 'c7wp_element_register_elements' );

/**
 * Add icon to element
 *
 * @param array $icon_map Array of icons.
 * @return array $icon_map
 */
function c7wp_element_icon_map( $icon_map ) {
	$icon_map['commerce7'] = C7WP_URI . 'assets/c7sm.svg';
	return $icon_map;
}
add_filter( 'cornerstone_icon_map', 'c7wp_element_icon_map' );