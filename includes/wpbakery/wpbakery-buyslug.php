<?php
/**
 * WPBakery element: Buy Button (Slug)
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_buyslug',
		'name'        => __( 'Buy Button', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 buy button for a product slug.', 'wp-commerce7' ),
		'type'        => 'buyslug',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Product Slug', 'wp-commerce7' ),
				'data',
				__( 'Enter the product slug.', 'wp-commerce7' )
			),
		),
	)
);
