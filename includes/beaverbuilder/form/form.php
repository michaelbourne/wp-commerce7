<?php
/**
 * Register FL Module
 *
 * Created Date: Thursday September 3rd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, September 3rd 2020, 7:37:40 pm
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

class C7WP_Form extends FLBuilderModule { // phpcs:ignore
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Custom Form', 'wp-commerce7' ),
            'description'     => __( 'Add a Commerce7 Custom Form to your layouts.', 'wp-commerce7' ),
            'category'        => __( 'Commerce7', 'wp-commerce7' ),
            'dir'             => C7WP_ROOT . '/includes/beaverbuilder/form/',
            'url'             => C7WP_URI . 'includes/beaverbuilder/form/',
            'partial_refresh' => true,
        ));
    }
}

FLBuilder::register_module( 'C7WP_Form', array(
	'c7wp-tab' => array(
		'title'    => __( 'Settings', 'wp-commerce7' ),
		'sections' => array(
			'c7wp-section' => array(
				'title'  => __( 'Commerce7 Content', 'wp-commerce7' ),
				'fields' => array(
					'cdata'     => array(
						'type'  => 'text',
						'label' => __( 'Form Slug', 'wp-commerce7' ),
					),
				),
			),
		),
	),
) );