<?php
/**
 * WPBakery element: General Form
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_form',
		'name'        => __( 'General Form', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 custom form.', 'wp-commerce7' ),
		'type'        => 'form',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Form Slug', 'wp-commerce7' ),
				'data',
				__( 'Enter the form slug.', 'wp-commerce7' )
			),
		),
	)
);
