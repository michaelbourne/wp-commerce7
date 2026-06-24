<?php
/**
 * WPBakery element: Club Selector v2
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/widgets/clubselector-v2-render.php';

C7WP_WPBakery::register_custom(
	array(
		'base'        => 'c7wp_clubselector_v2',
		'name'        => __( 'Club Selector v2', 'wp-commerce7' ),
		'description' => __( 'Club selector with Commerce7 join buttons (no redirect).', 'wp-commerce7' ),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Display Type', 'wp-commerce7' ),
				'param_name' => 'display_type',
				'value'      => array(
					__( 'Radio Buttons', 'wp-commerce7' )  => 'radio',
					__( 'Select Dropdown', 'wp-commerce7' ) => 'select',
				),
				'std'        => 'radio',
			),
			array(
				'type'       => 'textfield',
				'heading'    => __( 'Radio Group Name', 'wp-commerce7' ),
				'param_name' => 'radio_group_name',
				'value'      => 'club-selector-v2',
			),
			array(
				'type'       => 'param_group',
				'heading'    => __( 'Clubs', 'wp-commerce7' ),
				'param_name' => 'clubs',
				'params'     => array(
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Club Slug', 'wp-commerce7' ),
						'param_name' => 'club_slug',
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Club Name', 'wp-commerce7' ),
						'param_name' => 'club_name',
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Join Text', 'wp-commerce7' ),
						'param_name' => 'join_text',
						'value'      => __( 'Join Now', 'wp-commerce7' ),
					),
					array(
						'type'       => 'textfield',
						'heading'    => __( 'Edit Membership Text', 'wp-commerce7' ),
						'param_name' => 'edit_text',
						'value'      => __( 'Edit Membership', 'wp-commerce7' ),
					),
				),
			),
		),
	),
	static function ( $atts ) {
		$atts = shortcode_atts(
			array(
				'display_type'     => 'radio',
				'radio_group_name' => 'club-selector-v2',
				'clubs'            => '',
			),
			$atts,
			'c7wp_clubselector_v2'
		);

		$clubs = array();
		if ( function_exists( 'vc_param_group_parse_atts' ) && ! empty( $atts['clubs'] ) ) {
			$clubs = vc_param_group_parse_atts( $atts['clubs'] );
		}

		C7WP_Widgets::enqueue_clubselector_v2_assets();

		return c7wp_render_clubselector_v2(
			array(
				'clubs'            => c7wp_normalize_clubselector_v2_clubs( $clubs ),
				'display_type'     => $atts['display_type'],
				'radio_group_name' => $atts['radio_group_name'],
				'widget_id'        => 'vc-' . wp_unique_id(),
				'echo'             => false,
			)
		);
	}
);
