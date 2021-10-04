<?php
/**
 * Register FL Module
 *
 * Created Date: Thursday September 3rd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Monday, October 4th 2021, 12:08:57 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2020 URSA6
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class C7WP_Buyslug extends FLBuilderModule { // phpcs:ignore
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Buy Button (slug)', 'wp-commerce7' ),
            'description'     => __( 'Add a Commerce7 Buy Button (for Single, Variable, Bundle) to your layouts.', 'wp-commerce7' ),
            'category'        => __( 'Commerce7', 'wp-commerce7' ),
            'dir'             => C7WP_ROOT . '/includes/beaverbuilder/buyslug/',
            'url'             => C7WP_URI . 'includes/beaverbuilder/buyslug/',
            'partial_refresh' => true,
        ));
    }
}

FLBuilder::register_module( 'C7WP_Buyslug', array(
	'c7wp-tab' => array(
		'title'    => __( 'Settings', 'wp-commerce7' ),
		'sections' => array(
			'c7wp-section' => array(
				'title'  => __( 'Commerce7 Content', 'wp-commerce7' ),
				'fields' => array(
					'cdata'     => array(
						'type'  => 'text',
						'label' => __( 'Product Slug', 'wp-commerce7' ),
					),
				),
			),
		),
	),
) );