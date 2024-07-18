<?php
/**
 * WP Bakery legacy element for backwards compatibility
 *
 * Created Date: Thursday September 3rd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, July 18th 2024, 1:36:40 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2020 URSA6
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}
if ( 'v2' == $this->widgetsver ) {
	vc_map(
		array(
			'name'        => __( 'Commerce7', 'wp-commerce7' ),
			'description' => 'Add a Commerce7 widget. Legacy element for backwards compatibility.',
			'base'        => 'c7wp',
			'class'       => '',
			'icon'        => C7WP_URI . 'assets/c7.svg',
			'category'    => 'Content',
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => __( 'Content Type', 'wp-commerce7' ),
					'param_name'  => 'type',
					'admin_label' => true,
					'value' => array(
						__( 'Default Content', 'wp-commerce7' )       => 'default',
						__( 'Personalization Block', 'wp-commerce7' ) => 'personalization',
						__( 'Buy Button', 'wp-commerce7' )            => 'buyslug',
						__( 'Subscribe Form', 'wp-commerce7' )        => 'subscribe',
						__( 'Collection Grid', 'wp-commerce7' )       => 'collection',
						__( 'Login\Logout Link', 'wp-commerce7' )     => 'login',
						__( 'Cart Icon\Flyout', 'wp-commerce7' )      => 'cart',
						__( 'Reservation Widget', 'wp-commerce7' )    => 'reservation',
						__( 'General Form', 'wp-commerce7' )          => 'form',
						__( 'Club Magic Button', 'wp-commerce7' )     => 'joinnow',
					),
					'std'         => 'default',
					'description' => __( 'Choose the type of widget you would like to display.', 'wp-commerce7' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => __( 'Data/Slug', 'wp-commerce7' ),
					'param_name'  => 'data',
					'description' => __( 'Enter the data or slug for the widget type, if applicable.', 'wp-commerce7' ),
				),
			),
		)
	);
} else {
	vc_map(
		array(
			'name'        => __( 'Commerce7', 'wp-commerce7' ),
			'description' => 'Add a Commerce7 widget. Legacy element for backwards compatibility.',
			'base'        => 'c7wp',
			'class'       => '',
			'icon'        => C7WP_URI . 'assets/c7.svg',
			'category'    => 'Content',
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => __( 'Content Type', 'wp-commerce7' ),
					'param_name'  => 'type',
					'admin_label' => true,
					'value' => array(
						__( 'Default Content', 'wp-commerce7' )             => 'default',
						__( 'Personalization Block', 'wp-commerce7' )       => 'personalization',
						__( 'Buy Now (SKU)', 'wp-commerce7' )               => 'buy',
						__( 'Buy Now (Slug)', 'wp-commerce7' )              => 'buyslug',
						__( 'Subscribe Form', 'wp-commerce7' )              => 'subscribe',
						__( 'Collection Grid', 'wp-commerce7' )             => 'collection',
						__( 'Login/Logout Link', 'wp-commerce7' )           => 'login',
						__( 'Cart Data Link', 'wp-commerce7' )              => 'cart',
						__( 'Reservation Widget', 'wp-commerce7' )          => 'reservation',
						__( 'General Form', 'wp-commerce7' )                => 'form',
						__( 'Join\Edit Club Magic Button', 'wp-commerce7' ) => 'joinnow',
						__( 'Quick Shop Form', 'wp-commerce7' )             => 'quickshop',
						__( 'Login Form', 'wp-commerce7' )                  => 'loginform',
						__( 'Create Account Form', 'wp-commerce7' )         => 'creataccount',
					),
					'std'         => 'default',
					'description' => __( 'Choose the type of content you would like to display.', 'wp-commerce7' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => __( 'Data', 'wp-commerce7' ),
					'param_name'  => 'data',
					'description' => __( 'Enter the data for the content type, if applicable.', 'wp-commerce7' ),
				),
			),
		)
	);
}
