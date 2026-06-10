<?php
/**
 * WPBakery element: Club Selector
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/widgets/clubselector-render.php';

C7WP_WPBakery::register_custom(
	array(
		'base'        => 'c7wp_clubselector',
		'name'        => __( 'Club Selector', 'wp-commerce7' ),
		'description' => __( 'Add a Commerce7 club selector with radio or select display.', 'wp-commerce7' ),
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
				'value'      => 'club-selector',
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
						'heading'    => __( 'Button Text', 'wp-commerce7' ),
						'param_name' => 'button_text',
					),
				),
			),
		),
	),
	static function ( $atts ) {
		$atts = shortcode_atts(
			array(
				'display_type'     => 'radio',
				'radio_group_name' => 'club-selector',
				'clubs'            => '',
			),
			$atts,
			'c7wp_clubselector'
		);

		$clubs = array();
		if ( function_exists( 'vc_param_group_parse_atts' ) && ! empty( $atts['clubs'] ) ) {
			$clubs = vc_param_group_parse_atts( $atts['clubs'] );
		}

		return c7wp_render_clubselector(
			array(
				'clubs'             => c7wp_normalize_clubselector_clubs( $clubs ),
				'display_type'      => $atts['display_type'],
				'radio_group_name'  => $atts['radio_group_name'],
				'widget_id'         => 'vc-' . wp_unique_id(),
				'button_link_class' => 'club-selector-button elementor-button-link',
				'echo'              => false,
			)
		);
	}
);
