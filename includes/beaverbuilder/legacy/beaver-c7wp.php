<?php
/**
 * Beaver Builder Integration
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

class C7WP_flModule extends FLBuilderModule { // phpcs:ignore
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Commerce7 (legacy)', 'wp-commerce7' ),
            'description'     => __( 'Add Commerce7 content to your layouts. Legacy element for backwards compatibility.', 'wp-commerce7' ),
            'category'        => __( 'Commerce7', 'wp-commerce7' ),
            'dir'             => C7WP_ROOT . '/includes/beaverbuilder/',
            'url'             => C7WP_URI . 'includes/beaverbuilder/',
            'icon'            => C7WP_URI . 'includes/beaverbuilder/c7.svg',
            'partial_refresh' => true,
        ));
    }
}

FLBuilder::register_module( 'C7WP_flModule', array(
	'c7wp-tab' => array(
		'title'    => __( 'Settings', 'wp-commerce7' ),
		'sections' => array(
			'c7wp-section' => array(
				'title'  => __( 'Commerce7 Content', 'wp-commerce7' ),
				'fields' => array(
					'ctype' => array(
						'type'          => 'select',
						'label'         => __( 'Content Type', 'wp-commerce7' ),
						'options'       => array(
							'default'  		  => __( 'Default Content', 'wp-commerce7' ),
							'personalization' => __( 'Personalization Block', 'wp-commerce7' ),
							'buy' 			  => __( 'Buy Now (SKU)', 'wp-commerce7' ),
							'buyslug'		  => __( 'Buy Now (Slug)', 'wp-commerce7' ),
							'subscribe' 	  => __( 'Subscribe Form', 'wp-commerce7' ),
							'collection' 	  => __( 'Collection Grid', 'wp-commerce7' ),
							'login' 		  => __( 'Login/Logout Link', 'wp-commerce7' ),
							'cart' 			  => __( 'Cart Data Link', 'wp-commerce7' ),
							'reservation' 	  => __( 'Reservation Widget', 'wp-commerce7' ),
							'form' 			  => __( 'General Form', 'wp-commerce7' ),
							'joinnow' 		  => __( 'Join/Edit Club Magic Button', 'wp-commerce7' ),
							'quickshop'		  => __( 'Quick Shop form', 'wp-commerce7' ),
							'loginform'		  => __( 'Login Form', 'wp-commerce7' ),
							'createaccount'	  => __( 'Create account form', 'wp-commerce7' ),
						),
					),
					'cdata'     => array(
						'type'  => 'text',
						'label' => __( 'Data', 'wp-commerce7' ),
					),
				),
			),
		),
	),
) );
