<?php
/**
 * Register FL Module: Cart
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class C7WP_Cart extends FLBuilderModule { // phpcs:ignore
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Cart', 'wp-commerce7' ),
				'description'     => __( 'Add a Commerce7 cart icon or flyout.', 'wp-commerce7' ),
				'category'        => __( 'Commerce7', 'wp-commerce7' ),
				'dir'             => C7WP_ROOT . '/includes/beaverbuilder/cart/',
				'url'             => C7WP_URI . 'includes/beaverbuilder/cart/',
				'partial_refresh' => true,
			)
		);
	}
}

FLBuilder::register_module(
	'C7WP_Cart',
	array(
		'c7wp-tab' => array(
			'title' => __( 'Settings', 'wp-commerce7' ),
		),
	)
);
