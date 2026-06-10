<?php
/**
 * WPBakery element: Login/Logout Link
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_login',
		'name'        => __( 'Login/Logout Link', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 login and logout link.', 'wp-commerce7' ),
		'type'        => 'login',
		'params'      => array(),
	)
);
