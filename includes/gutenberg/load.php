<?php
/**
 * Gutenberg Blocks
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Tuesday, November 7th 2023, 2:45:47 pm
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

// Check if Gutenberg is active.
if ( ! function_exists( 'register_block_type' ) ) {
    return;
}

if ( 'v2' == $this->widgetsver ) {
    $elements = [
        'default',
        'personalization',
        'buyslug',
        'subscribe',
        'collection',
        'reservation',
        'form',
        'joinnow',
        'loginform',
    ];
    $dir = 'blocks-v2';
} else {
    $elements = [
        'default',
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
    $dir = 'blocks';
}

foreach ( $elements as $element ) {

    $block_slug = 'c7wp-' . $element;
    // Add block script.
    wp_register_script(
        $block_slug,
        plugins_url( $dir . '/' . $element . '/' . $block_slug . '.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor' ],
        C7WP_VERSION,
        1
    );

    // Add block style.
    wp_register_style(
        $block_slug,
        plugins_url( $dir . '/' . $element . '/' . $block_slug . '.css', __FILE__ ),
        [],
        C7WP_VERSION
    );

    // Register block script and style.
    register_block_type( 'c7wp/' . $element, [
        'editor_style'  => $block_slug, // Loads both on editor.
        'editor_script' => $block_slug, // Loads only on editor.
    ] );
}
