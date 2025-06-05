<?php
/**
 * Load all Elementor widgets
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, June 5th 2025, 5:11:55 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2020 URSA6
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.8
 */

// Legacy Element - will be removed in future release
require_once C7WP_ROOT . '/includes/elementor/elementor-legacy.php';
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \C7WP_Elementor() );

if ( in_array( $this->widgetsver, [ 'v2', 'v2-compat' ] ) ) {
    $elements = [
        'personalization',
        'buyslug',
        'subscribe',
        'collection',
        'login',
        'cart',
        'reservation',
        'form',
        'joinnow',
        'default',
        'collectionlist',
    ];
} else {
    $elements = [
        'personalization',
        'buy',
        'buyslug',
        'subscribe',
        'collection',
        'login',
        'cart',
        'reservation',
        'form',
        'joinnow',
        'quickshop',
        'loginform',
        'createaccount',
    ];
}

foreach ( $elements as $element ) {
    require_once C7WP_ROOT . '/includes/elementor/elementor-' . $element . '.php';
    $class = '\C7WP_Elementor_' . ucfirst( $element );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class() );
}
