<?php
/**
 * WPBakery element: Login Form
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_loginform',
		'name'        => __( 'Login Form', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 login form.', 'wp-commerce7' ),
		'type'        => 'loginform',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Redirect To Path', 'wp-commerce7' ),
				'data',
				__( 'Optional path to redirect after login.', 'wp-commerce7' )
			),
		),
	)
);
