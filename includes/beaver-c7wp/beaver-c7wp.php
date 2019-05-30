<?php
/**
* Beaver Builder Integration
*
* @package   Commerce7 for WordPress
* @author    Michael Bourne
* @license   GPL3
* @link      https://ursa6.com
* @since     1.0.0
*/

class C7WP_flModule extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Commerce7', 'commerce7-for-wordpress' ),
            'description'     => __( 'Add Commerce7 content to your layouts.', 'commerce7-for-wordpress' ),
            'category'        => __( 'Commerce7', 'commerce7-for-wordpress' ),
            'dir'             => C7WP_ROOT . '/includes/beaver-c7wp/',
            'url'             => C7WP_URI . 'includes/beaver-c7wp/',
            'icon'            => C7WP_URI . 'includes/beaver-c7wp/c7.svg',
            'partial_refresh' => true
        ));
    }
}

FLBuilder::register_module( 'C7WP_flModule', array(
	'c7wp-tab'      => array(
		'title'         => __( 'Settings', 'commerce7-for-wordpress' ),
		'sections'      => array(
			'c7wp-section'  => array(
				'title'         => __( 'Commerce7 Content', 'commerce7-for-wordpress' ),
				'fields'        => array(
					'ctype' => array(
						'type'          => 'select',
						'label'         => __( 'Content Type', 'commerce7-for-wordpress' ),
						'options'       => array(
							'default'  			=> __( 'Default Content', 'commerce7-for-wordpress' ),
							'personalization' 	=> __( 'Personalization Block', 'commerce7-for-wordpress' ),
							'buy' 				=> __( 'Buy Now Button', 'commerce7-for-wordpress' ),
							'subscribe' 		=> __( 'Subscribe Form', 'commerce7-for-wordpress' ),
							'collection' 		=> __( 'Collection Grid', 'commerce7-for-wordpress' ),
							'login' 			=> __( 'Login/Logout Link', 'commerce7-for-wordpress' ),
							'cart' 				=> __( 'Cart Data Link', 'commerce7-for-wordpress' ),
							'reservation' 		=> __( 'Reservation Widget', 'commerce7-for-wordpress' ),
							'form' 				=> __( 'General Form', 'commerce7-for-wordpress' ),
						)
					),
					'cdata'     => array(
						'type'          => 'text',
						'label'         => __( 'Data', 'commerce7-for-wordpress' ),
					)
				)
			)
		)
	)
) );