<?php
/**
 * WPBakery element: Cart
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_cart',
		'name'        => __( 'Cart', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 cart icon or flyout.', 'wp-commerce7' ),
		'type'        => 'cart',
		'params'      => array(),
	)
);
