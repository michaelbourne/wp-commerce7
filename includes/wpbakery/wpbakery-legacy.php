<?php
/**
 * WP Bakery legacy element for backwards compatibility
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

$legacy_params = array(
	array(
		'type'        => 'dropdown',
		'heading'     => __( 'Content Type', 'wp-commerce7' ),
		'param_name'  => 'type',
		'admin_label' => true,
		'value'       => in_array( $this->widgetsver, array( 'v2', 'v2-compat' ), true )
			? array(
				__( 'Default Content', 'wp-commerce7' )       => 'default',
				__( 'Personalization Block', 'wp-commerce7' ) => 'personalization',
				__( 'Buy Button', 'wp-commerce7' )            => 'buyslug',
				__( 'Subscribe Form', 'wp-commerce7' )        => 'subscribe',
				__( 'Collection Grid', 'wp-commerce7' )       => 'collection',
				__( 'Login/Logout Link', 'wp-commerce7' )     => 'login',
				__( 'Cart Icon/Flyout', 'wp-commerce7' )      => 'cart',
				__( 'Reservation Widget', 'wp-commerce7' )    => 'reservation',
				__( 'General Form', 'wp-commerce7' )          => 'form',
				__( 'Club Magic Button', 'wp-commerce7' )     => 'joinnow',
			)
			: array(
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
				__( 'Join/Edit Club Magic Button', 'wp-commerce7' ) => 'joinnow',
				__( 'Quick Shop Form', 'wp-commerce7' )             => 'quickshop',
				__( 'Login Form', 'wp-commerce7' )                  => 'loginform',
				__( 'Create Account Form', 'wp-commerce7' )         => 'createaccount',
				__( 'Collection List', 'wp-commerce7' )             => 'collectionlist',
			),
		'std'         => 'default',
		'description' => __( 'Choose the type of widget you would like to display.', 'wp-commerce7' ),
	),
	array(
		'type'        => 'textfield',
		'heading'     => in_array( $this->widgetsver, array( 'v2', 'v2-compat' ), true )
			? __( 'Data/Slug', 'wp-commerce7' )
			: __( 'Data', 'wp-commerce7' ),
		'param_name'  => 'data',
		'description' => __( 'Enter the data or slug for the widget type, if applicable.', 'wp-commerce7' ),
	),
);

vc_map(
	array(
		'name'              => __( 'Commerce7 (Legacy)', 'wp-commerce7' ),
		'description'       => __( 'Legacy combined Commerce7 element. Use the individual Commerce7 elements instead.', 'wp-commerce7' ),
		'base'              => 'c7wp',
		'class'             => '',
		'icon'              => C7WP_WPBakery::icon(),
		'category'          => C7WP_WPBakery::CATEGORY,
		'deprecated'        => '1.7.2',
		'params'            => $legacy_params,
		'admin_enqueue_css' => array(
			C7WP_URI . 'assets/admin/css/c7wpicons.css',
			C7WP_URI . 'assets/admin/css/wpbakery-icons.css',
		),
	)
);
