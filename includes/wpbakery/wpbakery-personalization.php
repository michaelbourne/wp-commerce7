<?php
/**
 * WPBakery element: Personalization Block
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_personalization',
		'name'        => __( 'Personalization Block', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 personalization block to your layout.', 'wp-commerce7' ),
		'type'        => 'personalization',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Block Code', 'wp-commerce7' ),
				'data',
				__( 'Enter the personalization block code.', 'wp-commerce7' )
			),
		),
	)
);
