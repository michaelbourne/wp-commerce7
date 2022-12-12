<?php
/**
 * Rankmath Support
 *
 * Created Date: Wednesday October 12th 2022
 * Author: Michael Bourne
 * -----
 * Last Modified: Monday, December 12th 2022, 10:18:40 am
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

add_filter( 'seopress_titles_canonical', function ( $html ) {

    $options = get_option( 'c7wp_settings' );

    // If the user has not set custom routes, use the defaults.
    if ( ! isset( $options['c7wp_frontend_routes'] ) || ! is_array( $options['c7wp_frontend_routes'] ) ) {
        $product_route    = 'product';
        $collection_route = 'collection';
    } else {
        $product_route    = $options['c7wp_frontend_routes']['product'];
        $collection_route = $options['c7wp_frontend_routes']['collection'];
    }

    // If the current page is a product or collection page, return false to disable canonical URL.
    if ( is_page( [ $product_route, $collection_route ] ) ) {
		return false;
	}

	return $html;
}, 20 );
