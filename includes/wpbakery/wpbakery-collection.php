<?php
/**
 * WPBakery element: Collection Grid
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_collection',
		'name'        => __( 'Collection', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 collection grid to your layout.', 'wp-commerce7' ),
		'type'        => 'collection',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Collection Slug', 'wp-commerce7' ),
				'data',
				__( 'Enter the collection slug.', 'wp-commerce7' )
			),
		),
	)
);
