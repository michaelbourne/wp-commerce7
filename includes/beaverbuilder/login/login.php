<?php
/**
 * Register FL Module: Login
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class C7WP_Login extends FLBuilderModule { // phpcs:ignore
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Login/Logout Link', 'wp-commerce7' ),
				'description'     => __( 'Add a Commerce7 login and logout link.', 'wp-commerce7' ),
				'category'        => __( 'Commerce7', 'wp-commerce7' ),
				'dir'             => C7WP_ROOT . '/includes/beaverbuilder/login/',
				'url'             => C7WP_URI . 'includes/beaverbuilder/login/',
				'partial_refresh' => true,
			)
		);
	}
}

FLBuilder::register_module(
	'C7WP_Login',
	array(
		'c7wp-tab' => array(
			'title' => __( 'Settings', 'wp-commerce7' ),
		),
	)
);
