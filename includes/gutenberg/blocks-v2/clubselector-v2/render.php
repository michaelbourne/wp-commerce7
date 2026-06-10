<?php
/**
 * Server-side render for Club Selector v2 block.
 *
 * @package wp-commerce7
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block content.
 * @var WP_Block $block      Block instance.
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/widgets/clubselector-v2-render.php';

$widget_id = wp_unique_id( 'c7v2-' );

echo c7wp_render_clubselector_v2( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'clubs'            => isset( $attributes['clubs'] ) ? $attributes['clubs'] : array(),
		'display_type'     => isset( $attributes['displayType'] ) ? $attributes['displayType'] : 'radio',
		'radio_group_name' => ! empty( $attributes['radioGroupName'] ) ? $attributes['radioGroupName'] : 'club-selector-v2',
		'widget_id'        => $widget_id,
		'echo'             => false,
	)
);
