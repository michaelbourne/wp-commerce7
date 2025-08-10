<?php
/**
 * Gutenberg Blocks
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, August 7th 2025, 9:42:01 pm
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

if ( in_array( $this->widgetsver, array( 'v2', 'v2-compat' ) ) ) {
    $elements = array(
        'default',
        'personalization',
        'buyslug',
        'subscribe',
        'collection',
        'reservation',
        'form',
        'joinnow',
        'loginform',
        'clubselector',
        'collectionlist',
    );
    $dir = 'blocks-v2';
} else {
    $elements = array(
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
    );
    $dir = 'blocks';
}

foreach ( $elements as $element ) {

    $block_slug = 'c7wp-' . $element;
    // Add block script.
    wp_register_script(
        $block_slug,
        plugins_url( $dir . '/' . $element . '/' . $block_slug . '.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element' ),
        C7WP_VERSION,
        1
    );

    // Add block style.
    wp_register_style(
        $block_slug,
        plugins_url( $dir . '/' . $element . '/' . $block_slug . '.css', __FILE__ ),
        array(),
        C7WP_VERSION
    );

    // Register block script and style.
    register_block_type( 'c7wp/' . $element, array(
        'editor_style'  => $block_slug, // Loads both on editor.
        'editor_script' => $block_slug, // Loads only on editor.
    ) );

    // Check for and load frontend assets
    $frontend_js_path = $dir . '/' . $element . '/frontend.js';
    $frontend_css_path = $dir . '/' . $element . '/frontend.css';

    // Register and enqueue frontend script if it exists
    if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_js_path ) && empty( $_GET['ct_builder'] ) ) {
        $frontend_script_handle = 'c7wp-' . $element . '-frontend';
        wp_register_script(
            $frontend_script_handle,
            plugins_url( $frontend_js_path, __FILE__ ),
            array(),
            C7WP_VERSION,
            true
        );

        // Localize settings for clubselector
        if ( 'clubselector' === $element ) {
            $options = get_option( 'c7wp_settings' );
            wp_localize_script( $frontend_script_handle, 'c7wp_settings', array(
                'c7wp_frontend_routes' => isset( $options['c7wp_frontend_routes'] ) ? $options['c7wp_frontend_routes'] : array( 'club' => 'club' ),
            ) );
        }

        wp_enqueue_script( $frontend_script_handle );
    }

    // Register and enqueue frontend styles if they exist
    if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_css_path ) ) {
        wp_register_style(
            'c7wp-' . $element . '-frontend',
            plugins_url( $frontend_css_path, __FILE__ ),
            array(),
            C7WP_VERSION
        );
        wp_enqueue_style( 'c7wp-' . $element . '-frontend' );
    }
}
