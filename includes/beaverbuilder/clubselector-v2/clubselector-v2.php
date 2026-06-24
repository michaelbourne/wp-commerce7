<?php
/**
 * Register FL Module: Club Selector v2
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class C7WP_Clubselector_V2 extends FLBuilderModule { // phpcs:ignore
	public function __construct() {
		parent::__construct(
			array(
				'name'            => __( 'Club Selector v2', 'wp-commerce7' ),
				'description'     => __( 'Improved Club selector with Commerce7 join buttons (no redirect).', 'wp-commerce7' ),
				'category'        => __( 'Commerce7', 'wp-commerce7' ),
				'dir'             => C7WP_ROOT . '/includes/beaverbuilder/clubselector-v2/',
				'url'             => C7WP_URI . 'includes/beaverbuilder/clubselector-v2/',
				'partial_refresh' => true,
			)
		);
	}
}

FLBuilder::register_module(
	'C7WP_Clubselector_V2',
	array(
		'c7wp-tab' => array(
			'title'    => __( 'Settings', 'wp-commerce7' ),
			'sections' => array(
				'c7wp-section' => array(
					'title'  => __( 'Commerce7 Content', 'wp-commerce7' ),
					'fields' => array(
						'display_type'     => array(
							'type'    => 'select',
							'label'   => __( 'Display Type', 'wp-commerce7' ),
							'default' => 'radio',
							'options' => array(
								'radio'  => __( 'Radio Buttons', 'wp-commerce7' ),
								'select' => __( 'Select Dropdown', 'wp-commerce7' ),
							),
						),
						'radio_group_name' => array(
							'type'    => 'text',
							'label'   => __( 'Radio Group Name', 'wp-commerce7' ),
							'default' => 'club-selector-v2',
						),
						'clubs'            => array(
							'type'         => 'form',
							'label'        => __( 'Clubs', 'wp-commerce7' ),
							'form'         => 'c7wp_clubselector_v2_club',
							'preview_text' => 'club_name',
							'multiple'     => true,
						),
					),
				),
			),
		),
	),
	array(
		'c7wp_clubselector_v2_club' => array(
			'title' => __( 'Club', 'wp-commerce7' ),
			'tabs'  => array(
				'general' => array(
					'title' => __( 'General', 'wp-commerce7' ),
				),
			),
		),
	)
);

FLBuilder::register_settings_form(
	'c7wp_clubselector_v2_club',
	array(
		'title' => __( 'Club', 'wp-commerce7' ),
		'tabs'  => array(
			'general' => array(
				'title'    => __( 'General', 'wp-commerce7' ),
				'sections' => array(
					'general' => array(
						'title'  => '',
						'fields' => array(
							'club_slug' => array(
								'type'  => 'text',
								'label' => __( 'Club Slug', 'wp-commerce7' ),
							),
							'club_name' => array(
								'type'  => 'text',
								'label' => __( 'Club Name', 'wp-commerce7' ),
							),
							'join_text' => array(
								'type'    => 'text',
								'label'   => __( 'Join Text', 'wp-commerce7' ),
								'default' => __( 'Join Now', 'wp-commerce7' ),
							),
							'edit_text' => array(
								'type'    => 'text',
								'label'   => __( 'Edit Membership Text', 'wp-commerce7' ),
								'default' => __( 'Edit Membership', 'wp-commerce7' ),
							),
						),
					),
				),
			),
		),
	)
);
