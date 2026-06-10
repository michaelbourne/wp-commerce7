<?php
/**
 * WPBakery helper for Commerce7 elements.
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.7.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Registers Commerce7 WPBakery elements.
 */
class C7WP_WPBakery {

	/**
	 * WPBakery element category.
	 */
	const CATEGORY = 'Commerce7';

	/**
	 * Element icon class (icon font used by Elementor/Gutenberg).
	 *
	 * WPBakery treats the icon value as a CSS class, not a URL.
	 *
	 * @return string
	 */
	public static function icon() {
		return 'c7icon-c7sm';
	}

	/**
	 * Enqueue icon font styles for WPBakery editors.
	 */
	public static function enqueue_assets() {
		wp_enqueue_style(
			'wp-commerce7-icons',
			C7WP_URI . 'assets/admin/css/c7wpicons.css',
			array(),
			C7WP_VERSION
		);
		wp_enqueue_style(
			'wp-commerce7-wpbakery-icons',
			C7WP_URI . 'assets/admin/css/wpbakery-icons.css',
			array( 'wp-commerce7-icons' ),
			C7WP_VERSION
		);
	}

	/**
	 * Register a Commerce7 WPBakery element and its shortcode.
	 *
	 * @param array $config Element configuration.
	 */
	public static function register( $config ) {
		$base        = $config['base'];
		$type        = $config['type'];
		$description = isset( $config['description'] ) ? $config['description'] : '';
		$params      = isset( $config['params'] ) ? $config['params'] : array();
		$deprecated  = isset( $config['deprecated'] ) ? $config['deprecated'] : '';

		add_shortcode(
			$base,
			function ( $atts ) use ( $type, $base ) {
				return self::render_shortcode( $type, $atts, $base );
			}
		);

		$map = array(
			'name'              => $config['name'],
			'description'       => $description,
			'base'              => $base,
			'class'             => '',
			'icon'              => self::icon(),
			'category'          => self::CATEGORY,
			'params'            => $params,
			'admin_enqueue_css' => array(
				C7WP_URI . 'assets/admin/css/c7wpicons.css',
				C7WP_URI . 'assets/admin/css/wpbakery-icons.css',
			),
		);

		if ( ! empty( $deprecated ) ) {
			$map['deprecated'] = $deprecated;
		}

		vc_map( $map );
	}

	/**
	 * Register a custom-render WPBakery element with its own shortcode callback.
	 *
	 * @param array    $config Element configuration.
	 * @param callable $callback Shortcode render callback.
	 */
	public static function register_custom( $config, $callback ) {
		$base        = $config['base'];
		$description = isset( $config['description'] ) ? $config['description'] : '';
		$params      = isset( $config['params'] ) ? $config['params'] : array();

		add_shortcode( $base, $callback );

		vc_map(
			array(
				'name'              => $config['name'],
				'description'       => $description,
				'base'              => $base,
				'class'             => '',
				'icon'              => self::icon(),
				'category'          => self::CATEGORY,
				'params'            => $params,
				'admin_enqueue_css' => array(
					C7WP_URI . 'assets/admin/css/c7wpicons.css',
					C7WP_URI . 'assets/admin/css/wpbakery-icons.css',
				),
			)
		);
	}

	/**
	 * Build a textfield param definition.
	 *
	 * @param string $heading     Field label.
	 * @param string $param_name  Attribute name.
	 * @param string $description Field description.
	 * @param bool   $admin_label Show in admin list.
	 * @return array
	 */
	public static function text_param( $heading, $param_name = 'data', $description = '', $admin_label = true ) {
		return array(
			'type'        => 'textfield',
			'heading'     => $heading,
			'param_name'  => $param_name,
			'admin_label' => $admin_label,
			'description' => $description,
		);
	}

	/**
	 * Render output via the core [c7wp] shortcode.
	 *
	 * @param string $type Widget type.
	 * @param array  $atts Shortcode attributes.
	 * @param string $tag  Shortcode tag.
	 * @return string
	 */
	public static function render_shortcode( $type, $atts, $tag ) {
		$atts = shortcode_atts(
			array(
				'data'      => '',
				'join-text' => '',
				'edit-text' => '',
			),
			$atts,
			$tag
		);

		$parts = array( 'type="' . esc_attr( $type ) . '"' );

		if ( '' !== $atts['data'] ) {
			$parts[] = 'data="' . esc_attr( $atts['data'] ) . '"';
		}

		if ( '' !== $atts['join-text'] ) {
			$parts[] = 'join-text="' . esc_attr( $atts['join-text'] ) . '"';
		}

		if ( '' !== $atts['edit-text'] ) {
			$parts[] = 'edit-text="' . esc_attr( $atts['edit-text'] ) . '"';
		}

		return do_shortcode( '[c7wp ' . implode( ' ', $parts ) . ']' );
	}
}
