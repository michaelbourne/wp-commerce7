<?php
/**
 * Club selector v2 module frontend output.
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/widgets/clubselector-v2-render.php';

$clubs = isset( $settings->clubs ) ? c7wp_normalize_clubselector_v2_clubs( (array) $settings->clubs ) : array();

C7WP_Widgets::enqueue_clubselector_v2_assets();

c7wp_render_clubselector_v2(
	array(
		'clubs'            => $clubs,
		'display_type'     => ! empty( $settings->display_type ) ? $settings->display_type : 'radio',
		'radio_group_name' => ! empty( $settings->radio_group_name ) ? $settings->radio_group_name : 'club-selector-v2',
		'widget_id'        => 'bb-' . $module->node,
	)
);
