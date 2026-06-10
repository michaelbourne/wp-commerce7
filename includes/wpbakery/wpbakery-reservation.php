<?php
/**
 * WPBakery element: Reservation Widget
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_reservation',
		'name'        => __( 'Reservation Widget', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 reservation availability widget.', 'wp-commerce7' ),
		'type'        => 'reservation',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Experience Slug', 'wp-commerce7' ),
				'data',
				__( 'Enter the experience slug.', 'wp-commerce7' )
			),
		),
	)
);
