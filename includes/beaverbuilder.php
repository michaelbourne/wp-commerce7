<?php
/**
 * Beaver Builder Integration
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( class_exists( 'FLBuilder' ) ) {
    require C7WP_ROOT . '/includes/beaver-c7wp/beaver-c7wp.php';
}