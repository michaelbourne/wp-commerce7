<?php
/**
 * WPBakery element: Create Account Form
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_createaccount',
		'name'        => __( 'Create Account Form', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 create account form.', 'wp-commerce7' ),
		'type'        => 'createaccount',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Redirect To', 'wp-commerce7' ),
				'data',
				__( 'Optional path to redirect after account creation.', 'wp-commerce7' )
			),
		),
	)
);
