<?php
/**
 * Rankmath Support
 *
 * Created Date: Wednesday October 12th 2022
 * Author: Michael Bourne
 * -----
 * Last Modified: Wednesday, October 12th 2022, 3:43:52 pm
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

add_action( 'wp_head', function( $canonical_url ) {

    $options = get_option( 'c7wp_settings' );
    if ( ! isset( $options['c7wp_frontend_routes'] ) || ! is_array( $options['c7wp_frontend_routes'] ) ) {
        $product_route    = 'product';
        $collection_route = 'collection';
    } else {
        $product_route    = $options['c7wp_frontend_routes']['product'];
        $collection_route = $options['c7wp_frontend_routes']['collection'];
    }

	if ( is_page( [ $product_route, $collection_route ] ) ) {
		remove_all_actions( 'rank_math/head' );
	}

}, 1 );
