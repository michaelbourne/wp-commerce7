<?php
/**
 * Register FL Module
 *
 * Created Date: Thursday September 3rd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Sunday, May 11th 2025, 1:37:12 pm
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

class C7WP_Default extends FLBuilderModule { // phpcs:ignore
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Default Content', 'wp-commerce7' ),
            'description'     => __( 'Add dynamic content to default route pages for Commerce7.', 'wp-commerce7' ),
            'category'        => __( 'Commerce7', 'wp-commerce7' ),
            'dir'             => C7WP_ROOT . '/includes/beaverbuilder/default/',
            'url'             => C7WP_URI . 'includes/beaverbuilder/default/',
            'partial_refresh' => true,
        ));
    }
}

FLBuilder::register_module( 'C7WP_Default', array(
	'c7wp-tab' => array(
		'title'    => __( 'Settings', 'wp-commerce7' ),
	),
) );