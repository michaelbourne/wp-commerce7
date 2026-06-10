<?php
/**
 * WPBakery element: Collection List
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_collectionlist',
		'name'        => __( 'Collection List', 'wp-commerce7' ),
		'description' => __( 'Display a Commerce7 collection list.', 'wp-commerce7' ),
		'type'        => 'collectionlist',
		'params'      => array(),
	)
);
