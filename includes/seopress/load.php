<?php
/**
 * Rankmath Support
 *
 * Created Date: Wednesday October 12th 2022
 * Author: Michael Bourne
 * -----
 * Last Modified: Wednesday, February 11th 2026, 8:27:21 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2022 URSA6
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter(
	'seopress_titles_canonical',
	function ( $html ) {

		$options          = c7wp_get_settings();
		$product_route    = $options['c7wp_frontend_routes']['product'];
		$collection_route = $options['c7wp_frontend_routes']['collection'];

		// If the current page is a product or collection page, return false to disable canonical URL.
		if ( is_page( array( $product_route, $collection_route ) ) ) {
			return false;
		}

		return $html;
	},
	20
);
