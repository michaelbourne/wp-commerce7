<?php
/**
 * Themeco Pro / Cornerstone modern element API.
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Registers Commerce7 elements via cs_register_element().
 */
class C7WP_Themeco_Pro {

	/**
	 * Register all Commerce7 elements.
	 *
	 * @param string $widgetsver Active widget version.
	 */
	public static function register_elements( $widgetsver ) {
		if ( ! function_exists( 'cs_register_element' ) ) {
			return;
		}

		require_once C7WP_ROOT . '/includes/widgets/clubselector-render.php';

		$slugs = C7WP_Widgets::get_slugs_for_version( $widgetsver );

		foreach ( $slugs as $slug ) {
			if ( 'clubselector' === $slug ) {
				self::register_clubselector_element();
				continue;
			}

			$widget = C7WP_Widgets::get_widget( $slug );
			if ( empty( $widget ) || empty( $widget['c7_type'] ) ) {
				continue;
			}

			self::register_shortcode_element( $slug, $widget );
		}

		self::register_legacy_element();
	}

	/**
	 * Register a shortcode-based element.
	 *
	 * @param string $slug   Widget slug.
	 * @param array  $widget Widget manifest entry.
	 */
	private static function register_shortcode_element( $slug, $widget ) {
		$element_id = 'c7wp-' . $slug;
		$values     = cs_compose_values(
			array(
				'data'      => cs_value( '', 'markup', true ),
				'join_text' => cs_value( '', 'markup', false ),
				'edit_text' => cs_value( '', 'markup', false ),
			)
		);

		$builder = static function () use ( $widget ) {
			$controls = array(
				array(
					'key'   => 'data',
					'type'  => 'text',
					'label' => __( 'Data/Slug', 'wp-commerce7' ),
					'group' => 'c7wp:setup',
				),
			);

			if ( isset( $widget['fields']['join-text'] ) ) {
				$controls[] = array(
					'key'   => 'join_text',
					'type'  => 'text',
					'label' => __( 'Join Club Text', 'wp-commerce7' ),
					'group' => 'c7wp:setup',
				);
				$controls[] = array(
					'key'   => 'edit_text',
					'type'  => 'text',
					'label' => __( 'Edit Membership Text', 'wp-commerce7' ),
					'group' => 'c7wp:setup',
				);
			}

			return cs_compose_controls(
				array(
					'control_nav' => array(
						'c7wp'       => $widget['title'],
						'c7wp:setup' => __( 'Setup', 'wp-commerce7' ),
					),
					'controls'    => array(
						array(
							'type'     => 'group',
							'label'    => __( 'Setup', 'wp-commerce7' ),
							'group'    => 'c7wp:setup',
							'controls' => $controls,
						),
					),
				)
			);
		};

		$render = static function ( $data ) use ( $widget ) {
			$atts = array( 'data' => isset( $data['data'] ) ? $data['data'] : '' );
			if ( ! empty( $data['join_text'] ) ) {
				$atts['join-text'] = $data['join_text'];
			}
			if ( ! empty( $data['edit_text'] ) ) {
				$atts['edit-text'] = $data['edit_text'];
			}
			return do_shortcode( C7WP_Widgets::build_shortcode( $widget['c7_type'], $atts ) );
		};

		cs_register_element(
			$element_id,
			array(
				'title'   => $widget['title'],
				'values'  => $values,
				'builder' => $builder,
				'render'  => $render,
			)
		);
	}

	/**
	 * Register club selector element.
	 */
	private static function register_clubselector_element() {
		$values = cs_compose_values(
			array(
				'display_type'     => cs_value( 'radio', 'markup', true ),
				'radio_group_name' => cs_value( 'club-selector', 'markup', false ),
				'clubs_json'       => cs_value( '', 'markup', true ),
			)
		);

		$builder = static function () {
			return cs_compose_controls(
				array(
					'control_nav' => array(
						'c7wp-clubselector'       => __( 'Club Selector', 'wp-commerce7' ),
						'c7wp-clubselector:setup' => __( 'Setup', 'wp-commerce7' ),
					),
					'controls'    => array(
						array(
							'type'     => 'group',
							'label'    => __( 'Setup', 'wp-commerce7' ),
							'group'    => 'c7wp-clubselector:setup',
							'controls' => array(
								array(
									'key'     => 'display_type',
									'type'    => 'choose',
									'label'   => __( 'Display Type', 'wp-commerce7' ),
									'options' => array(
										'choices' => array(
											array( 'value' => 'radio', 'label' => __( 'Radio', 'wp-commerce7' ) ),
											array( 'value' => 'select', 'label' => __( 'Select', 'wp-commerce7' ) ),
										),
									),
								),
								array(
									'key'   => 'radio_group_name',
									'type'  => 'text',
									'label' => __( 'Radio Group Name', 'wp-commerce7' ),
								),
								array(
									'key'   => 'clubs_json',
									'type'  => 'textarea',
									'label' => __( 'Clubs JSON', 'wp-commerce7' ),
								),
							),
						),
					),
				)
			);
		};

		$render = static function ( $data ) {
			$clubs = array();
			if ( ! empty( $data['clubs_json'] ) ) {
				$decoded = json_decode( $data['clubs_json'], true );
				if ( is_array( $decoded ) ) {
					$clubs = c7wp_normalize_clubselector_clubs( $decoded );
				}
			}

			return c7wp_render_clubselector(
				array(
					'clubs'             => $clubs,
					'display_type'      => ! empty( $data['display_type'] ) ? $data['display_type'] : 'radio',
					'radio_group_name'  => ! empty( $data['radio_group_name'] ) ? $data['radio_group_name'] : 'club-selector',
					'widget_id'         => 'cs-' . wp_unique_id(),
					'button_link_class' => 'club-selector-button elementor-button-link',
					'echo'              => false,
				)
			);
		};

		cs_register_element(
			'c7wp-clubselector',
			array(
				'title'   => __( 'Club Selector', 'wp-commerce7' ),
				'values'  => $values,
				'builder' => $builder,
				'render'  => $render,
			)
		);
	}

	/**
	 * Register deprecated combined legacy element.
	 */
	private static function register_legacy_element() {
		$values = cs_compose_values(
			array(
				'type' => cs_value( 'default', 'markup', true ),
				'data' => cs_value( '', 'markup', false ),
			)
		);

		$builder = static function () {
			return cs_compose_controls(
				array(
					'control_nav' => array(
						'c7wp-legacy'       => __( 'Commerce7 (Legacy)', 'wp-commerce7' ),
						'c7wp-legacy:setup' => __( 'Setup', 'wp-commerce7' ),
					),
					'controls'    => array(
						array(
							'type'     => 'group',
							'label'    => __( 'Setup', 'wp-commerce7' ),
							'group'    => 'c7wp-legacy:setup',
							'controls' => array(
								array(
									'key'   => 'type',
									'type'  => 'text',
									'label' => __( 'Content Type', 'wp-commerce7' ),
								),
								array(
									'key'   => 'data',
									'type'  => 'text',
									'label' => __( 'Data/Slug', 'wp-commerce7' ),
								),
							),
						),
					),
				)
			);
		};

		$render = static function ( $data ) {
			$type = ! empty( $data['type'] ) ? $data['type'] : 'default';
			$slug = ! empty( $data['data'] ) ? $data['data'] : '';
			return do_shortcode( C7WP_Widgets::build_shortcode( $type, array( 'data' => $slug ) ) );
		};

		cs_register_element(
			'c7wp-legacy',
			array(
				'title'   => __( 'Commerce7 (Legacy)', 'wp-commerce7' ),
				'values'  => $values,
				'builder' => $builder,
				'render'  => $render,
			)
		);
	}
}
