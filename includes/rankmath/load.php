<?php
/**
 * Rankmath Support
 *
 * Created Date: Wednesday October 12th 2022
 * Author: Michael Bourne
 * -----
 * Last Modified: Friday, October 17th 2025, 6:55:09 pm
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

add_action( 'rank_math/frontend/canonical', function( $canonical ) {

    $options = get_option( 'c7wp_settings' );

    // If the user has not set custom routes, use the defaults.
    if ( ! isset( $options['c7wp_frontend_routes'] ) || ! is_array( $options['c7wp_frontend_routes'] ) ) {
        $product_route    = 'product';
        $collection_route = 'collection';
    } else {
        $product_route    = $options['c7wp_frontend_routes']['product'];
        $collection_route = $options['c7wp_frontend_routes']['collection'];
    }

    // If the current page is a product or collection page, remove action to disable canonical URL.
	if ( is_page( [ $product_route, $collection_route ] ) ) {
		return false;
	}

}, 1 );

