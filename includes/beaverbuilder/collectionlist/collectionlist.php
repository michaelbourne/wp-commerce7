<?php
/**
 * Register FL Module
 *
 * Created Date: Thursday September 3rd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Wednesday, February 11th 2026, 8:42:00 pm
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

class C7WP_CollectionList extends FLBuilderModule { // phpcs:ignore
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Collection List', 'wp-commerce7' ),
				'description'     => __( 'Add a list of web available Collections', 'wp-commerce7' ),
				'category'        => __( 'Commerce7', 'wp-commerce7' ),
				'dir'             => C7WP_ROOT . '/includes/beaverbuilder/default/',
				'url'             => C7WP_URI . 'includes/beaverbuilder/default/',
				'partial_refresh' => true,
			)
		);
	}
}

FLBuilder::register_module(
	'C7WP_CollectionList',
	array(
		'c7wp-tab' => array(
			'title' => __( 'Settings', 'wp-commerce7' ),
		),
	)
);
