<?php
/**
 * Club selector module frontend output.
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/widgets/clubselector-render.php';

$clubs = isset( $settings->clubs ) ? c7wp_normalize_clubselector_clubs( (array) $settings->clubs ) : array();

c7wp_render_clubselector(
	array(
		'clubs'             => $clubs,
		'display_type'      => ! empty( $settings->display_type ) ? $settings->display_type : 'radio',
		'radio_group_name'  => ! empty( $settings->radio_group_name ) ? $settings->radio_group_name : 'club-selector',
		'widget_id'         => 'bb-' . $module->node,
		'button_link_class' => 'club-selector-button elementor-button-link',
	)
);
