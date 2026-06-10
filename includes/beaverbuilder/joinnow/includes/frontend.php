<?php
/**
 * Element rendering on front end
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$atts = array(
	'type' => 'joinnow',
	'data' => isset( $settings->cdata ) ? $settings->cdata : '',
);

if ( ! empty( $settings->join_text ) ) {
	$atts['join-text'] = $settings->join_text;
}

if ( ! empty( $settings->edit_text ) ) {
	$atts['edit-text'] = $settings->edit_text;
}

echo do_shortcode( C7WP_Widgets::build_shortcode( $atts['type'], $atts ) );
