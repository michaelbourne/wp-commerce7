<?php
/**
 * WPBakery element: Quick Shop Form
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_quickshop',
		'name'        => __( 'Quick Shop Form', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 quick shop form for a collection.', 'wp-commerce7' ),
		'type'        => 'quickshop',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Collection Slug', 'wp-commerce7' ),
				'data',
				__( 'Enter the collection slug.', 'wp-commerce7' )
			),
		),
	)
);
