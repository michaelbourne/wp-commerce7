<?php
/**
* WP Bakery Integration
*
* @package   Commerce7 for WordPress
* @author    Michael Bourne
* @license   GPL3
* @link      https://ursa6.com
* @since     1.0.0
*/

if( ! defined( 'ABSPATH' ) ) {
	return;
}

vc_map( 

	array(
		"name" => __( "Commerce7", "commerce7-for-wordpress" ),
		"description" => "Add a Commerce7 widget",
		"base" => "c7wp",
		"class" => "",
		"icon" => C7WP_URI . 'assets/c7sm.svg',
		"category" => "Content",
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Content Type", "commerce7-for-wordpress" ),
				"param_name" => "type",
				"admin_label" => true,
				"value" => array(
					__( 'Default Content', 'commerce7-for-wordpress' ) => 'default',
					__( 'Personalization Block', 'commerce7-for-wordpress' ) => 'personalization',
					__( 'Buy Now Button', 'commerce7-for-wordpress' ) => 'buy',
					__( 'Subscribe Form', 'commerce7-for-wordpress' ) => 'subscribe',
					__( 'Collection Grid', 'commerce7-for-wordpress' ) => 'collection',
					__( 'Login/Logout Link', 'commerce7-for-wordpress' ) => 'login',
					__( 'Cart Data Link', 'commerce7-for-wordpress' ) => 'cart',
					__( 'Reservation Widget', 'commerce7-for-wordpress' ) => 'reservation',
					__( 'General Form', 'commerce7-for-wordpress' ) => 'form',
				),
				"std" => "default",
				"description" => __( "Choose the type of content you would like to display.", "commerce7-for-wordpress" )
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Data", "commerce7-for-wordpress" ),
				"param_name" => "data",
				"description" => __( "Enter the data for the content type, if applicable.", "commerce7-for-wordpress" )
			)
		)
	) 
);