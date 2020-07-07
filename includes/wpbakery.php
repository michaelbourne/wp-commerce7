<?php
/**
 * WP Bakery Integration
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

vc_map(
	array(
		'name'        => __( 'Commerce7', 'wp-commerce7' ),
		'description' => 'Add a Commerce7 widget',
		'base'        => 'c7wp',
		'class'       => '',
		'icon'        => C7WP_URI . 'assets/c7sm.svg',
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
	),
);