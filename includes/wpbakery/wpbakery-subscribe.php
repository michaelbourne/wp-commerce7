<?php
/**
 * WPBakery element: Subscribe Form
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_subscribe',
		'name'        => __( 'Subscribe Form', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 email subscribe form.', 'wp-commerce7' ),
		'type'        => 'subscribe',
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Show Name Fields?', 'wp-commerce7' ),
				'param_name' => 'data',
				'value'      => array(
					__( 'No', 'wp-commerce7' )  => 'false',
					__( 'Yes', 'wp-commerce7' ) => 'true',
				),
				'std'        => 'false',
			),
		),
	)
);
