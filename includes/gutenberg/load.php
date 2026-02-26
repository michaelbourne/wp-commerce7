<?php
/**
 * Gutenberg Blocks
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, February 26th 2026, 2:21:24 pm
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if Gutenberg is active.
if ( ! function_exists( 'register_block_type' ) ) {
	return;
}

// Load validation helper
require_once C7WP_ROOT . '/includes/class-c7wp-validation.php';

if ( in_array( $this->widgetsver, array( 'v2', 'v2-compat' ), true ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
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
	$dir      = 'blocks-v2';
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
	$dir      = 'blocks';
}

$ct_builder    = filter_input( INPUT_GET, 'ct_builder', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$is_ct_builder = ! empty( $ct_builder );

foreach ( $elements as $element ) {
	$block_slug = 'c7wp-' . $element;
	$block_name = 'c7wp/' . $element;

	$frontend_js_path       = $dir . '/' . $element . '/frontend.js';
	$frontend_css_path      = $dir . '/' . $element . '/frontend.css';
	$frontend_script_handle = 'c7wp-' . $element . '-frontend';
	$frontend_style_handle  = 'c7wp-' . $element . '-frontend';
	$has_frontend_js        = file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_js_path );
	$has_frontend_css       = file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_css_path );

	// Check if block.json exists (new format)
	$block_json_path = C7WP_ROOT . '/includes/gutenberg/' . $dir . '/' . $element . '/block.json';
	if ( file_exists( $block_json_path ) ) {
		// Register editor script with dependencies before registering block
		$editor_script_path = C7WP_ROOT . '/includes/gutenberg/' . $dir . '/' . $element . '/' . $block_slug . '.js';
		if ( file_exists( $editor_script_path ) ) {
			wp_register_script(
				$block_slug,
				plugins_url( $dir . '/' . $element . '/' . $block_slug . '.js', __FILE__ ),
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
				C7WP_VERSION,
				true
			);
		}

		// Register editor style before registering block
		$editor_style_path = C7WP_ROOT . '/includes/gutenberg/' . $dir . '/' . $element . '/' . $block_slug . '.css';
		if ( file_exists( $editor_style_path ) ) {
			wp_register_style(
				$block_slug,
				plugins_url( $dir . '/' . $element . '/' . $block_slug . '.css', __FILE__ ),
				array(),
				C7WP_VERSION
			);
		}

		// Register optional frontend script for block render only.
		$block_args = array();
		if ( $has_frontend_js && ! $is_ct_builder ) {
			wp_register_script(
				$frontend_script_handle,
				plugins_url( $frontend_js_path, __FILE__ ),
				array(),
				C7WP_VERSION,
				true
			);

			if ( 'clubselector' === $element ) {
				$options = get_option( 'c7wp_settings' );
				wp_localize_script(
					$frontend_script_handle,
					'c7wp_settings',
					array(
						'c7wp_frontend_routes' => isset( $options['c7wp_frontend_routes'] ) ? $options['c7wp_frontend_routes'] : array( 'club' => 'club' ),
					)
				);
			}

			$block_args['view_script'] = $frontend_script_handle;
		}

		// Register block using metadata - it will reference our registered handles
		register_block_type_from_metadata( $block_json_path, $block_args );
	} else {
		// Fallback to old registration method
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

		if ( $has_frontend_js && ! $is_ct_builder ) {
			wp_register_script(
				$frontend_script_handle,
				plugins_url( $frontend_js_path, __FILE__ ),
				array(),
				C7WP_VERSION,
				true
			);

			if ( 'clubselector' === $element ) {
				$options = get_option( 'c7wp_settings' );
				wp_localize_script(
					$frontend_script_handle,
					'c7wp_settings',
					array(
						'c7wp_frontend_routes' => isset( $options['c7wp_frontend_routes'] ) ? $options['c7wp_frontend_routes'] : array( 'club' => 'club' ),
					)
				);
			}
		}

		// Register block script and style.
		$block_args = array(
			'editor_style'  => $block_slug, // Loads both on editor.
			'editor_script' => $block_slug, // Loads only on editor.
		);

		if ( $has_frontend_js && ! $is_ct_builder ) {
			$block_args['view_script'] = $frontend_script_handle;
		}

		register_block_type(
			$block_name,
			$block_args
		);
	}

	if ( $has_frontend_css ) {
		if ( function_exists( 'wp_enqueue_block_style' ) ) {
			wp_enqueue_block_style(
				$block_name,
				array(
					'handle' => $frontend_style_handle,
					'src'    => plugins_url( $frontend_css_path, __FILE__ ),
					'path'   => C7WP_ROOT . '/includes/gutenberg/' . $frontend_css_path,
					'ver'    => C7WP_VERSION,
				)
			);
		} else {
			wp_register_style(
				$frontend_style_handle,
				plugins_url( $frontend_css_path, __FILE__ ),
				array(),
				C7WP_VERSION
			);
		}
	}

	/**
	 * Club selector uses core buttons markup (.wp-block-buttons, .wp-block-button__link);
	 * ensure core buttons style loads when this block is present.
	 */
	if ( 'clubselector' === $element ) {
		wp_enqueue_block_style( 'c7wp/clubselector', array( 'handle' => 'wp-block-buttons' ) );
	}
}
