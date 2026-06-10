<?php
/**
 * Central Commerce7 widget manifest.
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Widget registry shared across page builders.
 */
class C7WP_Widgets {

	/**
	 * Widget definitions.
	 *
	 * @return array
	 */
	public static function get_manifest() {
		return array(
			'default'          => array(
				'c7_type'        => 'default',
				'title'          => __( 'Default Content', 'wp-commerce7' ),
				'description'    => __( 'Display the default Commerce7 content area.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_default',
				'fields'         => array(),
			),
			'personalization'  => array(
				'c7_type'        => 'personalization',
				'title'          => __( 'Personalization Block', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 personalization block to your layout.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_personalization',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Block Code', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the personalization block code.', 'wp-commerce7' ),
					),
				),
			),
			'buy'              => array(
				'c7_type'        => 'buy',
				'title'          => __( 'Buy Button (SKU)', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 buy button for a variant SKU.', 'wp-commerce7' ),
				'v2'             => false,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_buy',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Variant SKU', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the variant SKU.', 'wp-commerce7' ),
					),
				),
			),
			'buyslug'          => array(
				'c7_type'        => 'buyslug',
				'title'          => __( 'Buy Button', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 buy button for a product slug.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_buyslug',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Product Slug', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the product slug.', 'wp-commerce7' ),
					),
				),
			),
			'subscribe'        => array(
				'c7_type'        => 'subscribe',
				'title'          => __( 'Subscribe Form', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 email subscribe form.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_subscribe',
				'fields'         => array(
					'data' => array(
						'label'   => __( 'Show Name Fields?', 'wp-commerce7' ),
						'type'    => 'select',
						'options' => array(
							'false' => __( 'No', 'wp-commerce7' ),
							'true'  => __( 'Yes', 'wp-commerce7' ),
						),
						'default' => 'false',
					),
				),
			),
			'collection'       => array(
				'c7_type'        => 'collection',
				'title'          => __( 'Collection', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 collection grid to your layout.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_collection',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Collection Slug', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the collection slug.', 'wp-commerce7' ),
					),
				),
			),
			'login'            => array(
				'c7_type'        => 'login',
				'title'          => __( 'Login/Logout Link', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 login and logout link.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_login',
				'fields'         => array(),
			),
			'cart'             => array(
				'c7_type'        => 'cart',
				'title'          => __( 'Cart', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 cart icon or flyout.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_cart',
				'fields'         => array(),
			),
			'reservation'      => array(
				'c7_type'        => 'reservation',
				'title'          => __( 'Reservation Widget', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 reservation availability widget.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_reservation',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Experience Slug', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the experience slug.', 'wp-commerce7' ),
					),
				),
			),
			'form'             => array(
				'c7_type'        => 'form',
				'title'          => __( 'General Form', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 custom form.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_form',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Form Slug', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the form slug.', 'wp-commerce7' ),
					),
				),
			),
			'joinnow'          => array(
				'c7_type'        => 'joinnow',
				'title'          => __( 'Club Join Button', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 club join or edit membership button.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_joinnow',
				'fields'         => array(
					'data'      => array(
						'label'       => __( 'Club Slug', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the club slug.', 'wp-commerce7' ),
					),
					'join-text' => array(
						'label'       => __( 'Join Club Text', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Optional text for the join button.', 'wp-commerce7' ),
					),
					'edit-text' => array(
						'label'       => __( 'Edit Membership Text', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Optional text for the edit membership button.', 'wp-commerce7' ),
					),
				),
			),
			'collectionlist'   => array(
				'c7_type'        => 'collectionlist',
				'title'          => __( 'Collection List', 'wp-commerce7' ),
				'description'    => __( 'Display a Commerce7 collection list.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => false,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_collectionlist',
				'fields'         => array(),
			),
			'clubselector'     => array(
				'c7_type'        => null,
				'title'          => __( 'Club Selector', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 club selector with radio or select display.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => false,
				'custom_render'  => true,
				'shortcode_base' => 'c7wp_clubselector',
				'fields'         => array(),
			),
			'clubselector-v2'  => array(
				'c7_type'        => null,
				'title'          => __( 'Club Selector v2', 'wp-commerce7' ),
				'description'    => __( 'Club selector with Commerce7 join buttons (no redirect).', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => false,
				'custom_render'  => true,
				'shortcode_base' => 'c7wp_clubselector_v2',
				'builders'       => array( 'gutenberg' ),
				'fields'         => array(),
			),
			'loginform'        => array(
				'c7_type'        => 'loginform',
				'title'          => __( 'Login Form', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 login form.', 'wp-commerce7' ),
				'v2'             => true,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_loginform',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Redirect To Path', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Optional path to redirect after login.', 'wp-commerce7' ),
					),
				),
			),
			'quickshop'        => array(
				'c7_type'        => 'quickshop',
				'title'          => __( 'Quick Shop Form', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 quick shop form for a collection.', 'wp-commerce7' ),
				'v2'             => false,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_quickshop',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Collection Slug', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Enter the collection slug.', 'wp-commerce7' ),
					),
				),
			),
			'createaccount'    => array(
				'c7_type'        => 'createaccount',
				'title'          => __( 'Create Account Form', 'wp-commerce7' ),
				'description'    => __( 'Add a Commerce7 create account form.', 'wp-commerce7' ),
				'v2'             => false,
				'beta'           => true,
				'custom_render'  => false,
				'shortcode_base' => 'c7wp_createaccount',
				'fields'         => array(
					'data' => array(
						'label'       => __( 'Redirect To', 'wp-commerce7' ),
						'type'        => 'text',
						'description' => __( 'Optional path to redirect after account creation.', 'wp-commerce7' ),
					),
				),
			),
		);
	}

	/**
	 * Get widget slugs for the active widget version.
	 *
	 * @param string      $widgetsver Widget version setting.
	 * @param string|null $builder    Optional builder key (gutenberg, elementor, beaverbuilder, wpbakery, themeco).
	 * @return array
	 */
	public static function get_slugs_for_version( $widgetsver, $builder = null ) {
		$is_v2    = in_array( $widgetsver, array( 'v2', 'v2-compat' ), true );
		$slugs    = array();
		$manifest = self::get_manifest();

		foreach ( $manifest as $slug => $widget ) {
			if ( $builder && ! empty( $widget['builders'] ) && ! in_array( $builder, $widget['builders'], true ) ) {
				continue;
			}

			if ( $is_v2 && ! empty( $widget['v2'] ) ) {
				$slugs[] = $slug;
			} elseif ( ! $is_v2 && ! empty( $widget['beta'] ) ) {
				$slugs[] = $slug;
			}
		}

		return $slugs;
	}

	/**
	 * Get a single widget definition.
	 *
	 * @param string $slug Widget slug.
	 * @return array|null
	 */
	public static function get_widget( $slug ) {
		$manifest = self::get_manifest();
		return isset( $manifest[ $slug ] ) ? $manifest[ $slug ] : null;
	}

	/**
	 * Build a [c7wp] shortcode string from type and attributes.
	 *
	 * @param string $type Widget type.
	 * @param array  $atts Attributes.
	 * @return string
	 */
	public static function build_shortcode( $type, $atts = array() ) {
		$parts = array( 'type="' . esc_attr( $type ) . '"' );

		foreach ( array( 'data', 'join-text', 'edit-text' ) as $key ) {
			if ( ! empty( $atts[ $key ] ) ) {
				$parts[] = $key . '="' . esc_attr( $atts[ $key ] ) . '"';
			}
		}

		return '[c7wp ' . implode( ' ', $parts ) . ']';
	}

	/**
	 * All shortcode tag patterns used by Commerce7 widgets.
	 *
	 * @return array
	 */
	public static function get_shortcode_tags() {
		$tags = array( 'c7wp' );
		foreach ( self::get_manifest() as $widget ) {
			if ( ! empty( $widget['shortcode_base'] ) ) {
				$tags[] = $widget['shortcode_base'];
			}
		}
		return array_unique( $tags );
	}

	/**
	 * Detect Commerce7 widgets in post content.
	 *
	 * @param string $content Post content.
	 * @return bool
	 */
	public static function content_has_c7_widgets( $content ) {
		if ( empty( $content ) ) {
			return false;
		}

		foreach ( self::get_shortcode_tags() as $tag ) {
			if ( has_shortcode( $content, $tag ) ) {
				return true;
			}
		}

		if ( false !== strpos( $content, '<!-- wp:c7wp/' ) ) {
			return true;
		}

		if ( false !== strpos( $content, 'club-selector-wrapper' ) ) {
			return true;
		}

		if ( false !== strpos( $content, 'club-selector-v2-wrapper' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Detect which widget slugs appear in content.
	 *
	 * @param string $content Post content.
	 * @return array
	 */
	public static function get_slugs_in_content( $content ) {
		$found = array();

		if ( empty( $content ) ) {
			return $found;
		}

		$manifest = self::get_manifest();
		foreach ( $manifest as $slug => $widget ) {
			if ( ! empty( $widget['shortcode_base'] ) && has_shortcode( $content, $widget['shortcode_base'] ) ) {
				$found[] = $slug;
			}
			if ( has_shortcode( $content, 'c7wp' ) && 'default' !== $slug ) {
				// Legacy combined shortcode may contain any type.
				if ( ! in_array( 'legacy', $found, true ) ) {
					$found[] = 'legacy';
				}
			}
			if ( false !== strpos( $content, '<!-- wp:c7wp/' . $slug ) ) {
				$found[] = $slug;
			}
		}

		if ( false !== strpos( $content, 'club-selector-wrapper' ) ) {
			$found[] = 'clubselector';
		}

		if ( false !== strpos( $content, 'club-selector-v2-wrapper' ) || false !== strpos( $content, '<!-- wp:c7wp/clubselector-v2' ) ) {
			$found[] = 'clubselector-v2';
		}

		return array_unique( $found );
	}

	/**
	 * Register and enqueue club selector frontend assets.
	 *
	 * @param C7WP|null $instance Plugin instance for settings.
	 */
	public static function register_clubselector_assets( $instance = null ) {
		if ( null === $instance ) {
			$instance = C7WP::getInstance();
		}

		$frontend_js_path  = 'blocks-v2/clubselector/frontend.js';
		$frontend_css_path = 'blocks-v2/clubselector/frontend.css';
		$handle            = 'c7wp-clubselector-frontend';

		if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_js_path ) ) {
			wp_register_script(
				$handle,
				plugins_url( $frontend_js_path, C7WP_ROOT . '/includes/gutenberg/load.php' ),
				array(),
				C7WP_VERSION,
				true
			);
			wp_localize_script( $handle, 'c7wp_settings', $instance->get_public_js_settings() );
		}

		if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_css_path ) ) {
			wp_register_style(
				$handle,
				plugins_url( $frontend_css_path, C7WP_ROOT . '/includes/gutenberg/load.php' ),
				array(),
				C7WP_VERSION
			);
		}
	}

	/**
	 * Enqueue club selector frontend assets.
	 */
	public static function enqueue_clubselector_assets() {
		self::register_clubselector_assets();
		if ( wp_script_is( 'c7wp-clubselector-frontend', 'registered' ) ) {
			wp_enqueue_script( 'c7wp-clubselector-frontend' );
		}
		if ( wp_style_is( 'c7wp-clubselector-frontend', 'registered' ) ) {
			wp_enqueue_style( 'c7wp-clubselector-frontend' );
		}
	}
}
