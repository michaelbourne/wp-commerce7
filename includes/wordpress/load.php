<?php
/**
 * WordPress Canonical Support
 *
 * Created Date: Wednesday October 12th 2022
 * Author: Michael Bourne
 * -----
 * Last Modified: Wednesday, February 11th 2026, 8:28:13 pm
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

/**
 * Get Commerce7 front-end route slugs.
 *
 * @return string[]
 */
function c7wp_get_frontend_route_slugs() {
	$options = get_option( 'c7wp_settings' );
	if ( ! isset( $options['c7wp_frontend_routes'] ) || ! is_array( $options['c7wp_frontend_routes'] ) ) {
		return array( 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' );
	}

	return array_values( $options['c7wp_frontend_routes'] );
}

/**
 * Whether the current request targets a Commerce7 front-end route.
 *
 * Commerce7 uses ?page=N for collection pagination. WordPress reserves `page`
 * for multi-page content, which triggers redirect_canonical and strips sub-routes.
 *
 * @param string $requested_url Optional URL passed to redirect_canonical.
 * @return bool
 */
function c7wp_is_frontend_route_request( $requested_url = '' ) {
	$routes = c7wp_get_frontend_route_slugs();

	if ( get_query_var( 'c7slug' ) ) {
		return true;
	}

	$pagename = get_query_var( 'pagename' );
	if ( $pagename && in_array( $pagename, $routes, true ) ) {
		return true;
	}

	if ( $requested_url ) {
		$parsed_url = wp_parse_url( $requested_url );
		$path       = trim( (string) ( $parsed_url['path'] ?? '' ), '/' );
		if ( '' !== $path ) {
			$first_segment = strtok( $path, '/' );
			if ( $first_segment && in_array( $first_segment, $routes, true ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Whether the request includes Commerce7 pagination via ?page=N.
 *
 * @return bool
 */
function c7wp_has_commerce7_pagination_query() {
	return isset( $_GET['page'] ) && is_numeric( $_GET['page'] ) && (int) $_GET['page'] > 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

/**
 * Prevent WordPress from treating Commerce7 ?page=N as WP page pagination.
 *
 * @param array<string, mixed> $query_vars Parsed query variables.
 * @return array<string, mixed>
 */
add_filter(
	'request',
	function ( $query_vars ) {
		if ( ! c7wp_has_commerce7_pagination_query() ) {
			return $query_vars;
		}

		$routes      = c7wp_get_frontend_route_slugs();
		$is_c7_route = false;

		if ( ! empty( $query_vars['c7slug'] ) ) {
			$is_c7_route = true;
		} elseif ( ! empty( $query_vars['pagename'] ) && in_array( $query_vars['pagename'], $routes, true ) ) {
			$is_c7_route = true;
		}

		if ( $is_c7_route && isset( $query_vars['page'] ) ) {
			unset( $query_vars['page'] );
		}

		return $query_vars;
	}
);

/**
 * Disable canonical redirects on Commerce7 routes that use ?page=N pagination.
 *
 * @param string|false $redirect_url  Canonical redirect URL.
 * @param string       $requested_url Requested URL.
 * @return string|false
 */
add_filter(
	'redirect_canonical',
	function ( $redirect_url, $requested_url ) {
		if ( ! c7wp_has_commerce7_pagination_query() ) {
			return $redirect_url;
		}

		if ( c7wp_is_frontend_route_request( $requested_url ) ) {
			return false;
		}

		return $redirect_url;
	},
	10,
	2
);

add_filter(
	'get_canonical_url',
	function ( $canonical_url ) {

		$options = get_option( 'c7wp_settings' );
		if ( ! isset( $options['c7wp_frontend_routes'] ) || ! is_array( $options['c7wp_frontend_routes'] ) ) {
			$product_route    = 'product';
			$collection_route = 'collection';
		} else {
			$product_route    = $options['c7wp_frontend_routes']['product'];
			$collection_route = $options['c7wp_frontend_routes']['collection'];
		}

		if ( is_page( array( $product_route, $collection_route ) ) ) {
			return '';
		}

		return $canonical_url;
	}
);
