<?php
/**
 * Gutenberg Blocks for V2 Frontend
 *
 * Created Date: Monday, August 30th 2021, 2:42:38 pm
 * Author: Michael Bourne
 * -----
 * Last Modified: Monday, August 30th 2021, 2:42:45 pm
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

// Check if Gutenberg is active.
if ( ! function_exists( 'register_block_type' ) ) {
    return;
}

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

foreach ( $elements as $element ) {

    $block_slug = 'c7wp-' . $element;
    // Add block script.
    wp_register_script(
        $block_slug,
        plugins_url( 'blocks/' . $element . '/' . $block_slug . '.js', __FILE__ ),
        [ 'wp-blocks', 'wp-element', 'wp-editor' ],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/' . $element . '/' . $block_slug . '.js' ),
        1
    );

    // Add block style.
    wp_register_style(
        $block_slug,
        plugins_url( 'blocks/' . $element . '/' . $block_slug . '.css', __FILE__ ),
        [],
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/' . $element . '/' . $block_slug . '.css' )
    );

    // Register block script and style.
    register_block_type( 'c7wp/' . $element, [
        'editor_style'  => $block_slug, // Loads both on editor.
        'editor_script' => $block_slug, // Loads only on editor.
    ] );
}
