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

// Legacy Support
if ( class_exists( 'FLBuilder' ) ) {
    require_once C7WP_ROOT . '/includes/beaverbuilder/legacy/beaver-c7wp.php';
}

if ( in_array( $this->widgetsver, [ 'v2', 'v2-compat' ] ) ) {
    // V2 Frontend
    $elements = [
        'personalization',
        'subscribe',
        'collection',
        'reservation',
        'form',
        'joinnow',
        'buyslug',
        'default',
        'collectionlist',
    ];
} else {
    // Beta Frontend
    $elements = [
        'personalization',
        'buy',
        'buyslug',
        'subscribe',
        'collection',
        'reservation',
        'form',
        'joinnow',
        'quickshop',
        'loginform',
        'createaccount',
    ];
}

foreach ( $elements as $element ) {
    require_once C7WP_ROOT . '/includes/beaverbuilder/' . $element . '/' . $element . '.php';
}
