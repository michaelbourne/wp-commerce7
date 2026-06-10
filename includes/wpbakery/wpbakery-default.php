<?php
/**
 * WPBakery element: Default Content
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_default',
		'name'        => __( 'Default Content', 'wp-commerce7' ),
		'description' => __( 'Display the default Commerce7 content area.', 'wp-commerce7' ),
		'type'        => 'default',
		'params'      => array(),
	)
);
