<?php
/**
 * WPBakery element: Club Join Button
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

C7WP_WPBakery::register(
	array(
		'base'        => 'c7wp_joinnow',
		'name'        => __( 'Club Join Button', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 club join or edit membership button.', 'wp-commerce7' ),
		'type'        => 'joinnow',
		'params'      => array(
			C7WP_WPBakery::text_param(
				__( 'Club Slug', 'wp-commerce7' ),
				'data',
				__( 'Enter the club slug.', 'wp-commerce7' )
			),
			C7WP_WPBakery::text_param(
				__( 'Join Club Text', 'wp-commerce7' ),
				'join-text',
				__( 'Optional text for the join button.', 'wp-commerce7' ),
				false
			),
			C7WP_WPBakery::text_param(
				__( 'Edit Membership Text', 'wp-commerce7' ),
				'edit-text',
				__( 'Optional text for the edit membership button.', 'wp-commerce7' ),
				false
			),
		),
	)
);
