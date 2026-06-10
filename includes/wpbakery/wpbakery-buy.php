<?php
/**
 * WPBakery element: Buy Button (SKU)
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_buy',
		'name'        => __( 'Buy Button (SKU)', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 buy button for a variant SKU.', 'wp-commerce7' ),
		'type'        => 'buy',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Variant SKU', 'wp-commerce7' ),
				'data',
				__( 'Enter the variant SKU.', 'wp-commerce7' )
			),
		),
	)
);
