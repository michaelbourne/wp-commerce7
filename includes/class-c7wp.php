<?php
/**
 * C7WP Class
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Main plugin class
 */
class C7WP {

	/**
	 * Core singleton class
	 *
	 * @var self - pattern realization
	 */
	private static $_instance; // phpcs:ignore

	/**
	 * Prefix for plugin
	 *
	 * @var $prefix
	 */
	private $prefix;

	/**
	 * C7 widgets version
	 *
	 * @var $widgetsver
	 */
	private $widgetsver;

	/**
	 * SEO plugin detected
	 *
	 * @var $seoplugin
	 */
	private $seoplugin;

	/**
	 * Cached plugin settings
	 *
	 * @var array
	 */
	private $settings;


	/**
	 * Constructor.
	 */
	private function __construct() {

		// add menu item
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 99 );

		// Admin Init
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		// WP Init
		add_action( 'init', array( $this, 'public_init' ) );

		// query vars
		add_filter( 'query_vars', array( $this, 'register_query_vars' ) );

		// Pagebuilder support
		add_action( 'init', array( $this, 'load_elements' ) );
		add_action( 'after_setup_theme', array( $this, 'load_cs_elements' ) );
		add_action( 'elementor/widgets/register', array( $this, 'c7wp_elementor_registered' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'c7wp_add_elementor_widget_categories' ) );
		add_filter( 'block_categories_all', array( $this, 'c7wp_block_categories' ), 10, 2 );

		// add admin styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'elementor_editor_enqueue_scripts' ) );
		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'elementor_frontend_assets_fallback' ) );
		add_action( 'after_setup_theme', array( $this, 'load_c7_css' ), 9 );
		add_filter( 'body_class', array( $this, 'add_body_class' ) );

		// for front end
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );
		add_action( 'wp_enqueue_scripts_clean', array( $this, 'enqueue_scripts' ), 10 );
		add_filter( 'script_loader_tag', array( $this, 'add_data_to_c7_script' ), 10, 3 );
		add_action( 'wp_footer', array( $this, 'footer_inject' ) );

		// Backend
		add_filter( 'display_post_states', array( $this, 'add_display_post_states' ), 10, 2 );

		// Import/Export handlers
		add_action( 'admin_init', array( $this, 'handle_import_export' ) );

		// main variables
		$this->prefix    = 'c7wp_';
		$this->seoplugin = false;

		// Cache settings to avoid multiple database calls
		$this->settings = get_option( 'c7wp_settings', array() );
		if ( isset( $this->settings['c7wp_widget_version'] ) && ! empty( $this->settings['c7wp_widget_version'] ) ) {
			$this->widgetsver = esc_attr( $this->settings['c7wp_widget_version'] );
		} else {
			$this->widgetsver = 'v2';
		}

		// load translations
		add_action( 'plugins_loaded', array( $this, 'c7wp_load_textdomain' ) );

		// load health check integration
		require_once C7WP_ROOT . '/includes/health-check.php';

		// Block Patterns
		require_once C7WP_ROOT . '/includes/block-patterns.php';

		// load WP-CLI integration
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			require_once C7WP_ROOT . '/includes/wp-cli.php';
		}

		// c7 div output for certain pagebuilders
		add_shortcode( 'c7wp', array( $this, 'c7wp_shortcode' ) );
	}

	/**
	 * Get the instance of C7WP Plugins
	 *
	 * @return self
	 */
	public static function getInstance() { // phpcs:ignore
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Get plugin settings with caching
	 *
	 * @return array Plugin settings
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Refresh cached settings
	 */
	public function refresh_settings() {
		$this->settings = get_option( 'c7wp_settings', array() );
	}

	/**
	 * @param mixed $instance Singleton instance.
	 */
	public static function setInstance( $instance ) { // phpcs:ignore
		self::$_instance = $instance;
	}

	/**
	 * Init main functions (for hook admin_init)
	 */
	public function admin_init() {

		if ( ! isset( $this->settings['c7wp_frontend_routes'] ) || ! is_array( $this->settings['c7wp_frontend_routes'] ) ) {
			$this->settings['c7wp_frontend_routes'] = array(
				'profile'     => 'profile',
				'collection'  => 'collection',
				'product'     => 'product',
				'club'        => 'club',
				'checkout'    => 'checkout',
				'cart'        => 'cart',
				'privacy'     => 'privacy',
				'terms'       => 'terms',
				'reservation' => 'reservation',
			);
			update_option( 'c7wp_settings', $this->settings, true );
			$this->refresh_settings();
		}

		$this->settings_init();
	}

	/**
	 * Load Commerce7 CSS in the editor at a low priority so themes can override it.
	 *
	 * @return void
	 */
	public function load_c7_css() {
		/**
		 * Filter: `c7wp_enqueue_c7_css_admin`
		 *
		 * Filter for enqueueing the Commerce7 provided CSS file on the backend.
		 * Useful for Gutenberg rendered blocks, but it can override theme styles in the editor.
		 *
		 * @param bool Should the CSS file be enqueued? Default: true
		 */
		if ( apply_filters( 'c7wp_enqueue_c7_css_admin', true ) ) {
			switch ( $this->widgetsver ) {
				case 'v2':
					add_editor_style( 'https://cdn.commerce7.com/v2/commerce7.css' );
					break;
				case 'v2-compat':
					add_editor_style( 'https://cdn.commerce7.com/v2/commerce7.css' );
					break;
				case 'beta':
					add_editor_style( 'https://cdn.commerce7.com/beta/commerce7.css' );
					break;
			}
		}
	}

	/**
	 * Public Init main functions
	 */
	public function public_init() {

		$this->add_c7_rewrites();

		if ( get_option( 'c7wp_activation' ) === true ) {
			delete_option( 'c7wp_activation' );
			flush_rewrite_rules();
		}
	}

	/**
	 * Register custom query var for later use
	 */
	public function register_query_vars( $vars ) {
		$vars[] = 'c7slug';
		return $vars;
	}

	/**
	 * Load elements after plugins loaded
	 */
	public function load_elements() {

		// WP Bakery Support
		if ( defined( 'WPB_VC_VERSION' ) ) {
			require_once C7WP_ROOT . '/includes/wpbakery/load.php';
		}

		// Beaver Builder Support
		if ( defined( 'FL_BUILDER_VERSION' ) ) {
			require_once C7WP_ROOT . '/includes/beaverbuilder/load.php';
		}

		// Gutenberg support
		$minimum_wp_version = '5.4';
		if ( version_compare( $GLOBALS['wp_version'], $minimum_wp_version, '>' ) ) {
			require_once C7WP_ROOT . '/includes/gutenberg/load.php';
			// Canonical fix
			require_once C7WP_ROOT . '/includes/wordpress/load.php';
		}

		// Yoast Support
		if ( defined( 'WPSEO_VERSION' ) ) {
			require_once C7WP_ROOT . '/includes/yoast/load.php';
			$this->seoplugin = true;
		}

		// RankMath support
		if ( defined( 'RANK_MATH_VERSION' ) ) {
			require_once C7WP_ROOT . '/includes/rankmath/load.php';
			$this->seoplugin = true;
		}

		// All In One SEO
		if ( defined( 'AIOSEO_VERSION' ) ) {
			require_once C7WP_ROOT . '/includes/aioseo/load.php';
			$this->seoplugin = true;
		}

		// SEOpress
		if ( defined( 'SEOPRESS_VERSION' ) ) {
			require_once C7WP_ROOT . '/includes/seopress/load.php';
			$this->seoplugin = true;
		}
	}

	/**
	 * Add custom Gutenberg Block Category
	 *
	 * @param array  $categories Gutenberg categories.
	 * @param object $post WP_Post object.
	 * @return array $categories
	 */
	public function c7wp_block_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'commerce7',
					'title' => __( 'Commerce7', 'wp-commerce7' ),
					'icon'  => 'dashicons-cart',
				),
			)
		);
	}

	/**
	 * Cornerstone element
	 */
	public function load_cs_elements() {
		// Cornerstone Support for older versions
		if ( class_exists( 'Cornerstone_Plugin' ) || function_exists( 'cornerstone_boot' ) ) {
			require_once C7WP_ROOT . '/includes/themeco/legacy/load.php';
		}
	}

	/**
	 * Elementor Category
	 */
	public function c7wp_add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'commerce7',
			array(
				'title' => __( 'Commerce7', 'wp-commerce7' ),
				'icon'  => 'fa fa-shopping-cart',
			),
		);
	}

	/**
	 * Elementor element
	 */
	public function c7wp_elementor_registered() {
		if ( class_exists( '\Elementor\Plugin' ) ) {
			require_once C7WP_ROOT . '/includes/elementor/load.php';
			\Elementor\Plugin::instance()->widgets_manager->register( new \C7WP_Elementor() );
		}
	}

	/**
	 * Internationalization
	 */
	public function c7wp_load_textdomain() {
		load_plugin_textdomain( 'wp-commerce7', false, C7WP_ROOT . '/languages/' );
	}

	/**
	 * Add new pages to admin
	 */
	public function add_admin_menu() {

		add_menu_page(
			__( 'Commerce7 for WordPress', 'wp-commerce7' ),
			'Commerce7',
			'manage_options',
			'commerce7',
			array(
				$this,
				'options_page',
			),
			C7WP_URI . 'assets/c7sm.svg',
			79
		);
	}

	/**
	 * Render all options
	 */
	public function options_page() {

		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && empty( get_settings_errors( 'c7wp_settings' ) ) ) { // phpcs:ignore
			add_settings_error( 'c7wp_settings', 'c7wp_settings_saved', __( 'Settings Saved', 'wp-commerce7' ), 'updated' );
		}

		settings_errors( 'c7wp_settings' );

		include_once C7WP_ROOT . '/admin/template.options.page.php';
	}


	/**
	 * C7WP settings init
	 */
	protected function settings_init() {

		register_setting( 'commerce7', 'c7wp_settings', 'c7wp_settings_callback' );

		add_settings_section(
			'c7wp_commerce7_section',
			false,
			false,
			'commerce7'
		);

		add_settings_field(
			'c7wp_tenant',
			__( 'Tenant ID', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_tenant_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);

		add_settings_field(
			'c7wp_display_cart',
			__( 'Display Cart Box Automatically?', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_display_cart_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);

		add_settings_field(
			'c7wp_display_cart_location',
			__( 'Cart Box Location', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_display_cart_location_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);

		add_settings_field(
			'c7wp_display_cart_color',
			__( 'Cart Box Theme', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_display_cart_color_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);

		add_settings_field(
			'c7wp_widget_version',
			__( 'Front-end Widgets Version', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_widget_version_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);

		add_settings_field(
			'c7wp_enable_custom_routes',
			__( 'Override front end routes?', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_enable_custom_routes_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);

		add_settings_field(
			'c7wp_frontend_routes',
			__( 'Custom Front-end Routes', 'wp-commerce7' ),
			array(
				$this,
				'c7wp_frontend_routes_render',
			),
			'commerce7',
			'c7wp_commerce7_section'
		);
	}

	public function c7wp_settings_callback( $input ) {

		$output = array();

		foreach ( $input as $key => $value ) {
			if ( isset( $input[ $key ] ) && ! empty( $value ) ) {
				if ( is_array( $value ) ) {
					foreach ( $value as $subkey => $subvalue ) {
						$output[ $key ][ $subkey ] = $this->sanitize_setting_field( $key, $subkey, $subvalue );
					}
				} else {
					$output[ $key ] = $this->sanitize_setting_field( $key, null, $value );
				}
			}
		}

		return apply_filters( 'c7wp_settings_post_validation', $output, $input );
	}

	/**
	 * Sanitize individual setting fields based on field type
	 *
	 * @param string $key The setting key.
	 * @param string|null $subkey The subkey for array values.
	 * @param mixed $value The value to sanitize.
	 * @return mixed The sanitized value.
	 */
	private function sanitize_setting_field( $key, $subkey, $value ) {
		// Handle tenant ID specifically
		if ( 'c7wp_tenant' === $key ) {
			// Tenant ID should be alphanumeric with possible hyphens/underscores
			return sanitize_text_field( $value );
		}

		// Handle frontend routes (page slugs)
		if ( 'c7wp_frontend_routes' === $key && ! is_null( $subkey ) ) {
			// Page slugs should be valid WordPress slugs
			$sanitized = sanitize_title( $value );
			// Ensure it's not empty and doesn't conflict with WordPress reserved terms
			$reserved_terms = array( 'admin', 'api', 'wp-admin', 'wp-content', 'wp-includes' );
			if ( empty( $sanitized ) || in_array( $sanitized, $reserved_terms, true ) ) {
				// Return default value if invalid
				$defaults = array(
					'profile'     => 'profile',
					'collection'  => 'collection',
					'product'     => 'product',
					'club'        => 'club',
					'checkout'    => 'checkout',
					'cart'        => 'cart',
					'reservation' => 'reservation',
				);
				return isset( $defaults[ $subkey ] ) ? $defaults[ $subkey ] : sanitize_title( $value );
			}
			return $sanitized;
		}

		// Handle select fields (these should be from predefined options)
		$select_fields = array(
			'c7wp_display_cart'          => array( 'yes', 'no' ),
			'c7wp_display_cart_location' => array( 'tl', 'tr', 'br', 'bl' ),
			'c7wp_display_cart_color'    => array( 'light', 'dark' ),
			'c7wp_widget_version'        => array( 'v2', 'v2-compat', 'beta' ),
			'c7wp_enable_custom_routes'  => array( 'yes', 'no' ),
		);

		if ( isset( $select_fields[ $key ] ) ) {
			$allowed_values = $select_fields[ $key ];
			if ( in_array( $value, $allowed_values, true ) ) {
				return $value;
			}
			// Return default value if invalid
			$defaults = array(
				'c7wp_display_cart'          => 'no',
				'c7wp_display_cart_location' => 'tr',
				'c7wp_display_cart_color'    => 'light',
				'c7wp_widget_version'        => 'v2',
				'c7wp_enable_custom_routes'  => 'no',
			);
			return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
		}

		// Default sanitization for other fields
		return sanitize_text_field( $value );
	}

	public function c7wp_tenant_render() {

		$options = $this->settings;
		?>
		<input type='text' name='c7wp_settings[c7wp_tenant]' value='<?php echo esc_attr( $options['c7wp_tenant'] ); ?>'>
		<?php
	}

	public function c7wp_display_cart_render() {

		$options = $this->settings;
		?>
		<select name='c7wp_settings[c7wp_display_cart]' class='c7displaycart'>
			<option value='no' <?php selected( $options['c7wp_display_cart'], 'no' ); ?>><?php esc_html_e( 'No', 'wp-commerce7' ); ?></option>
			<option value='yes' <?php selected( $options['c7wp_display_cart'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'wp-commerce7' ); ?></option>
		</select>
		<p><small>
			<?php
				echo wp_kses( __( 'If set to <strong>yes</strong>, this plugin will add a floating login  cart box to the front end of your website. If set to <strong>no</strong>, you will need to add the <code>[c7wp type=\'login\']</code> and <code>[c7wp type=\'cart\']</code> shortcodes (or Commerce7\'s HTML) to your header manually. We recommend setting this to no and placing your cart manually.', 'wp-commerce7' ),
				array( 'strong' => array(), 'code' => array() ) );
		 ?>
		 </small></p>
		<?php
	}

	public function c7wp_display_cart_location_render() {

		$options  = $this->settings;
		$disabled = ( 'no' === $options['c7wp_display_cart'] ) ? 'disabled' : '';
		if ( ! isset( $options['c7wp_display_cart_location'] ) ) {
			$options['c7wp_display_cart_location'] = 'tr';
		}
		?>
		<select name='c7wp_settings[c7wp_display_cart_location]' class='c7cartloc' <?php echo esc_attr( $disabled ); ?> >
			<option value='tl' <?php selected( $options['c7wp_display_cart_location'], 'tl' ); ?>><?php esc_html_e( 'Top left', 'wp-commerce7' ); ?></option>
			<option value='tr' <?php selected( $options['c7wp_display_cart_location'], 'tr' ); ?>><?php esc_html_e( 'Top right', 'wp-commerce7' ); ?></option>
			<option value='br' <?php selected( $options['c7wp_display_cart_location'], 'br' ); ?>><?php esc_html_e( 'Bottom right', 'wp-commerce7' ); ?></option>
			<option value='bl' <?php selected( $options['c7wp_display_cart_location'], 'bl' ); ?>><?php esc_html_e( 'Bottom left', 'wp-commerce7' ); ?></option>
		</select>

		<?php
	}

	public function c7wp_display_cart_color_render() {

		$options  = $this->settings;
		$disabled = ( 'no' === $options['c7wp_display_cart'] ) ? 'disabled' : '';
		if ( ! isset( $options['c7wp_display_cart_color'] ) ) {
			$options['c7wp_display_cart_color'] = 'light';
		}
		?>
		<select name='c7wp_settings[c7wp_display_cart_color]' class='c7cartcolor' <?php echo esc_attr( $disabled ); ?> >
			<option value='light' <?php selected( $options['c7wp_display_cart_color'], 'light' ); ?>><?php esc_html_e( 'Light website', 'wp-commerce7' ); ?></option>
			<option value='dark' <?php selected( $options['c7wp_display_cart_color'], 'dark' ); ?>><?php esc_html_e( 'Dark website', 'wp-commerce7' ); ?></option>
		</select>
		<p><small>
			<?php
				esc_html_e( 'Please select the color theme for the Cart Box. "Light website" is for light colored or white background site, "Dark website" is for dark colored or black background sites.', 'wp-commerce7' );
			?>
		</small></p>
		<?php
	}

	public function c7wp_widget_version_render() {

		$options = $this->settings;
		?>
		<select name='c7wp_settings[c7wp_widget_version]' class='c7widgetversion'>
			<option value='v2' <?php selected( $options['c7wp_widget_version'], 'v2' ); ?>><?php esc_html_e( 'V2', 'wp-commerce7' ); ?></option>
			<option value='v2-compat' <?php selected( $options['c7wp_widget_version'], 'v2-compat' ); ?>><?php esc_html_e( 'V2 (Compatibility Mode)', 'wp-commerce7' ); ?></option>
			<option value='beta' <?php selected( $options['c7wp_widget_version'], 'beta' ); ?>><?php esc_html_e( 'V1', 'wp-commerce7' ); ?></option>
		</select>
		<p><small>
			<?php
				echo wp_kses( '<strong>V2:</strong> The standard front-end widgets version used by most wineries. Most users should select this option.
				<br>
				<strong>V2 (Compatibility Mode):</strong> Use this if you are having issues with the standard V2 widgets, such as widgets not displaying correctly or displaying multiple times. This will load the V2 widgets in a way that is compatible with more themes.
				<br>
				<strong>V1:</strong> Only a select few legacy sites are still using the old beta/V1 widgets.', array( 'strong' => array(), 'br' => array() ) );
			?>
		</small></p>
		</small></p>
		<?php
	}

	public function c7wp_enable_custom_routes_render() {

		$options  = $this->settings;
		$disabled = ( 'beta' === $options['c7wp_widget_version'] ) ? 'disabled' : '';
		?>
		<select name='c7wp_settings[c7wp_enable_custom_routes]' <?php echo esc_attr( $disabled ); ?> >
			<option value='no' 
				<?php if ( isset( $options['c7wp_enable_custom_routes'] ) ) { selected( $options['c7wp_enable_custom_routes'], 'no' ); } ?>
				><?php esc_html_e( 'No', 'wp-commerce7' ); ?></option>
			<option value='yes' 
				<?php if ( isset( $options['c7wp_enable_custom_routes'] ) ) { selected( $options['c7wp_enable_custom_routes'], 'yes' ); } ?>
				><?php esc_html_e( 'Yes', 'wp-commerce7' ); ?></option>
		</select>
		<p><small>
			<?php
				echo wp_kses( __( 'For V2 frontend only. If set to <strong>yes</strong>, this plugin will allow you to set custom routing options (page slugs) below. Enable this option and save changes to edit routes below.', 'wp-commerce7' ), array( 'strong' => array() ) );
			?>
		</small></p>
		<?php
	}

	public function c7wp_frontend_routes_render() {

		$options  = $this->settings;
		$disabled = ( 'yes' === $options['c7wp_enable_custom_routes'] ) ? '' : 'disabled';
		?>
		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][cart]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['cart'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][cart]"><?php esc_html_e( 'Cart Page', 'wp-commerce7' ); ?></label></div>

		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][checkout]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['checkout'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][checkout]"><?php esc_html_e( 'Checkout Page', 'wp-commerce7' ); ?></label></div>

		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][club]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['club'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][club]"><?php esc_html_e( 'Club Pages', 'wp-commerce7' ); ?></label></div>

		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][collection]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['collection'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][collection]"><?php esc_html_e( 'Collection Pages', 'wp-commerce7' ); ?></label></div>

		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][product]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['product'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][product]"><?php esc_html_e( 'Product Pages', 'wp-commerce7' ); ?></label></div>

		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][profile]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['profile'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][profile]"><?php esc_html_e( 'Profile Page', 'wp-commerce7' ); ?></label></div>

		<div class="routing-row"><input type='text' name='c7wp_settings[c7wp_frontend_routes][reservation]' 
		value='<?php echo esc_attr( $options['c7wp_frontend_routes']['reservation'] ); ?>' class="routing-field" <?php echo esc_attr( $disabled ); ?>>
		<span>&#47;</span>
		<label for="c7wp_settings[c7wp_frontend_routes][reservation]"><?php esc_html_e( 'Reservation Page', 'wp-commerce7' ); ?></label></div>

		<p><small>
		<?php
			// Define the allowed HTML tags and attributes
			$allowed_html = array(
					'a' => array(
							'href' => array(),
							'target' => array(),
					),
					'strong' => array(),
					'br' => array(),
			);

			// Define the URLs
			$c7_url = 'https://admin.platform.commerce7.com/developer/frontend-v2';
			$permalinks_url = esc_url( admin_url( 'options-permalink.php', 'https' ) );

			/* translators: %1$s: URL to the routing settings in Commerce7 %2$s: URL to the permalinks settings in WordPress */
			$string = __(
					'These routes <strong>must</strong> match your <a href="%1$s" target="_blank">routing settings in Commerce7</a>.
					<br>
					Make sure you edit the slugs of any existing pages if you are changing these values.
					<br>
					You <strong>must</strong> <a href="%2$s">resave your permalinks in WordPress</a> after changing these settings.',
					'wp-commerce7',
			);

			// Replace the placeholders with actual URLs
			$formatted_string = sprintf( $string, esc_url( $c7_url ), esc_url( $permalinks_url ) );

			// Use wp_kses to allow specific HTML tags in the translated string
			echo wp_kses( $formatted_string, $allowed_html );
		?>
		</small></p>
		<?php
	}


	/**
	 * Enqueue admin scripts
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'wp-commerce7-admin', C7WP_URI . 'assets/admin/css/commerce7-for-wordpress-admin.css', array(), C7WP_VERSION );
	}

	/**
	 * Enqueue public scripts
	 */
	public function enqueue_scripts() {

		$options = $this->settings;

		/**
		 * Load the magic cart box CSS if enabled
		 */
		if ( 'yes' === $options['c7wp_display_cart'] ) {
			wp_enqueue_style( 'wp-commerce7', C7WP_URI . 'assets/public/css/commerce7-for-wordpress.css', array(), C7WP_VERSION );
		}

		/**
		 * Load mandatory Commerce7 JS file.
		 */
		switch ( $this->widgetsver ) {
			case 'v2':
				wp_register_script( 'c7js', 'https://cdn.commerce7.com/v2/commerce7.js', array(), null, true ); // phpcs:ignore
				break;
			case 'v2-compat':
				wp_register_script( 'c7js', 'https://cdn.commerce7.com/v2/commerce7-eventload.js', array(), null, true ); // phpcs:ignore
				break;
			case 'beta':
				wp_register_script( 'c7js', 'https://cdn.commerce7.com/beta/commerce7.js', array(), null, true ); // phpcs:ignore
				break;
			default:
				wp_register_script( 'c7js', 'https://cdn.commerce7.com/v2/commerce7.js', array(), null, true ); // phpcs:ignore
				break;
		}
		/**
		 * Enqueues the 'c7js' script if the following conditions are met:
		 * - The current request is not an admin request.
		 * - The 'ct_builder' query parameter is not present in the URL.
		 *
		 * This ensures that the C7 script is only enqueued on the front-end and not when
		 * using certain page builders like Oxygen.
		 */
		if ( ! is_admin() && empty( $_GET['ct_builder'] ) ) {
			wp_enqueue_script( 'c7js' );
		}

		// Enqueue block-specific assets only when needed
		$this->enqueue_block_assets();

		/**
		 * Filter: `c7wp_enqueue_c7_css`
		 *
		 * Filter for enqueueing the Commerce7 provided CSS file.
		 *
		 * @param bool Should the CSS file be enqueued? Default: true
		 */
		if ( apply_filters( 'c7wp_enqueue_c7_css', true ) ) {
			switch ( $this->widgetsver ) {
				case 'v2':
					wp_register_style( 'c7css', 'https://cdn.commerce7.com/v2/commerce7.css', false, null ); // phpcs:ignore
					break;
				case 'v2-compat':
					wp_register_style( 'c7css', 'https://cdn.commerce7.com/v2/commerce7.css', false, null ); // phpcs:ignore
					break;
				case 'beta':
					wp_register_style( 'c7css', 'https://cdn.commerce7.com/beta/commerce7.css', false, null ); // phpcs:ignore
					break;
				default:
					wp_register_style( 'c7css', 'https://cdn.commerce7.com/v2/commerce7.css', false, null ); // phpcs:ignore
					break;
			}
			wp_enqueue_style( 'c7css' );
		}

		/**
		 * Add editor styles for custom blocks
		 */
		if ( is_user_logged_in() && current_user_can( 'edit_pages' ) ) {
			wp_enqueue_style( 'wp-commerce7-pagebuilders', C7WP_URI . 'assets/public/css/commerce7-for-wordpress-editors.css', array(), C7WP_VERSION );
		}

		/**
		 * Add canonical fix if SEO plugins present
		 */
		if ( $this->seoplugin ) {

			if ( ! isset( $options['c7wp_frontend_routes'] ) || ! is_array( $options['c7wp_frontend_routes'] ) ) {
				$product_route    = 'product';
				$collection_route = 'collection';
			} else {
				$product_route    = $options['c7wp_frontend_routes']['product'];
				$collection_route = $options['c7wp_frontend_routes']['collection'];
			}

			if ( is_page( array( $product_route, $collection_route ) ) ) {
				wp_register_script( 'c7wp-seo', C7WP_URI .  'assets/public/js/c7wp-seo.js', array(), C7WP_VERSION, true ); // phpcs:ignore
				wp_enqueue_script( 'c7wp-seo' );
			}
		}
	}

	/**
	 * Enqueue block-specific assets only when blocks are present
	 */
	private function enqueue_block_assets() {
		global $post;

		if ( ! $post ) {
			return;
		}

		$post_content = $post->post_content;

		// Check for Gutenberg blocks
		if ( has_blocks( $post_content ) ) {
			$blocks = parse_blocks( $post_content );
			$this->enqueue_blocks_assets( $blocks );
		}

		// Check for shortcodes
		if ( has_shortcode( $post_content, 'c7wp' ) ) {
			$this->enqueue_shortcode_assets();
		}
	}

	/**
	 * Recursively enqueue assets for blocks
	 *
	 * @param array $blocks Array of blocks to check.
	 */
	private function enqueue_blocks_assets( $blocks ) {
		foreach ( $blocks as $block ) {
			// Check if this is a Commerce7 block
			if ( isset( $block['blockName'] ) && strpos( $block['blockName'], 'c7wp/' ) === 0 ) {
				$block_type = str_replace( 'c7wp/', '', $block['blockName'] );
				$this->enqueue_specific_block_assets( $block_type );
			}

			// Check inner blocks
			if ( isset( $block['innerBlocks'] ) && ! empty( $block['innerBlocks'] ) ) {
				$this->enqueue_blocks_assets( $block['innerBlocks'] );
			}
		}
	}

	/**
	 * Enqueue assets for a specific block type
	 *
	 * @param string $block_type The block type to enqueue assets for.
	 */
	private function enqueue_specific_block_assets( $block_type ) {
		$widgetsver = $this->get_widgets_version();

		// Determine the correct directory
		$dir = in_array( $widgetsver, array( 'v2', 'v2-compat' ), true ) ? 'blocks-v2' : 'blocks';

		// Enqueue frontend styles
		$frontend_css_path = $dir . '/' . $block_type . '/frontend.css';
		if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_css_path ) ) {
			wp_enqueue_style(
				'c7wp-' . $block_type . '-frontend',
				C7WP_URI . 'includes/gutenberg/' . $frontend_css_path,
				array(),
				C7WP_VERSION
			);
		}

		// Enqueue frontend scripts
		$frontend_js_path = $dir . '/' . $block_type . '/frontend.js';
		if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_js_path ) ) {
			wp_enqueue_script(
				'c7wp-' . $block_type . '-frontend',
				C7WP_URI . 'includes/gutenberg/' . $frontend_js_path,
				array(),
				C7WP_VERSION,
				true
			);

			// Localize settings for specific blocks
			if ( 'clubselector' === $block_type ) {
				$options = $this->settings;
				wp_localize_script( 'c7wp-' . $block_type . '-frontend', 'c7wp_settings', array(
					'c7wp_frontend_routes' => isset( $options['c7wp_frontend_routes'] ) ? $options['c7wp_frontend_routes'] : array( 'club' => 'club' ),
				) );
			}
		}
	}

	/**
	 * Enqueue assets for shortcode usage
	 */
	private function enqueue_shortcode_assets() {
		// Enqueue general Commerce7 styles
		wp_enqueue_style(
			'c7wp-shortcode',
			C7WP_URI . 'assets/public/css/commerce7-for-wordpress.css',
			array(),
			C7WP_VERSION
		);
	}

	/**
	 * Elementor specific styles
	 *
	 * @return void
	 */
	public function elementor_editor_enqueue_scripts() {
		wp_enqueue_style( 'wp-commerce7-icons', C7WP_URI . 'assets/admin/css/c7wpicons.css', array(), C7WP_VERSION );
	}

	/**
	 * Ensure clubselector frontend assets are loaded for Elementor when Gutenberg is disabled
	 *
	 * @return void
	 */
	public function elementor_frontend_assets_fallback() {
		// Only run if Gutenberg is not available (Classic Editor scenario)
		if ( ! function_exists( 'register_block_type' ) ) {
			// Check if we're on v2 widgets and clubselector frontend assets exist
			if ( in_array( $this->widgetsver, array( 'v2', 'v2-compat' ), true ) ) {
				$frontend_js_path  = 'blocks-v2/clubselector/frontend.js';
				$frontend_css_path = 'blocks-v2/clubselector/frontend.css';

				// Register and enqueue frontend script if it exists
				if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_js_path ) && empty( $_GET['ct_builder'] ) ) {
					$frontend_script_handle = 'c7wp-clubselector-frontend';
					wp_register_script(
						$frontend_script_handle,
						plugins_url( $frontend_js_path, C7WP_ROOT . '/includes/gutenberg/load.php' ),
						array(),
						C7WP_VERSION,
						true
					);

					// Localize settings
					$options = get_option( 'c7wp_settings' );
					wp_localize_script( $frontend_script_handle, 'c7wp_settings', array(
						'c7wp_frontend_routes' => isset( $options['c7wp_frontend_routes'] ) ? $options['c7wp_frontend_routes'] : array( 'club' => 'club' ),
					) );

					wp_enqueue_script( $frontend_script_handle );
				}

				// Register and enqueue frontend styles if they exist
				if ( file_exists( C7WP_ROOT . '/includes/gutenberg/' . $frontend_css_path ) ) {
					wp_register_style(
						'c7wp-clubselector-frontend',
						plugins_url( $frontend_css_path, C7WP_ROOT . '/includes/gutenberg/load.php' ),
						array(),
						C7WP_VERSION
					);
					wp_enqueue_style( 'c7wp-clubselector-frontend' );
				}
			}
		}
	}



	/**
	 * Add custom attributes to enqueued C7 script. Add RocketLoader false sync flag in case customer uses CloudFlare.
	 *
	 * @param string $tag HTML script tage for output in head or footer.
	 * @param string $handle Name registered to the script.
	 * @param string $src Script source URL.
	 *
	 * @return string $tag
	 */
	public function add_data_to_c7_script( $tag, $handle, $src ) {
		if ( 'c7js' === $handle ) {
			$options = $this->settings;
			$tag     = '<script data-cfasync="false" type="text/javascript" src="' . esc_url( $src ) . '" id="c7-javascript" data-tenant="' . esc_attr( $options['c7wp_tenant'] ) . '"></script>'; // phpcs:ignore
		}

		return $tag;
	}



	/**
	 * Add rewrite rules to WordPress for Commerce7 static routes.
	 * This works so well that it's been copied line for line by other C7 partners.
	 * I don't blame them, but really, just use this plugin for your clients. It works.
	 * If you're copying my code, please respect the law and give me credit for it.
	 */
	public function add_c7_rewrites() {

		if ( in_array( $this->widgetsver, array( 'v2', 'v2-compat' ), true ) ) {

			$options = $this->settings;

			if ( isset( $options['c7wp_frontend_routes'] ) && 'yes' === $options['c7wp_enable_custom_routes'] ) {
				$routes = implode( '|', array_values( $options['c7wp_frontend_routes'] ) );

				add_rewrite_rule(
					'^(' . $routes . ')/(.+)/?$',
					'index.php?pagename=$matches[1]&c7slug=$matches[2]',
					'top'
				);
			} else {
				add_rewrite_rule(
					'^(profile|collection|product|club|checkout|reservation)/(.+)/?$',
					'index.php?pagename=$matches[1]&c7slug=$matches[2]',
					'top'
				);
			}
		} else {
			add_rewrite_rule(
				'^(profile|collection|product|club|checkout|reservation)/(.+)/?$',
				'index.php?pagename=$matches[1]&c7slug=$matches[2]',
				'top'
			);
		}
	}



	/**
	 * Add Cart Box to body
	 */
	public function footer_inject() {

		$options = $this->settings;
		if ( 'yes' === $options['c7wp_display_cart'] ) {

			$color = ( 'dark' === $options['c7wp_display_cart_color'] ) ? 'c7dark' : 'c7light';

			switch ( $options['c7wp_display_cart_location'] ) {
				case 'tl':
					$class = 'top-left ';
					break;

				case 'tr':
					$class = 'top-right ';
					break;

				case 'br':
					$class = 'bottom-right ';
					break;

				case 'bl':
					$class = 'bottom-left ';
					break;

				default:
					$class = 'top-left ';
					break;
			}

			$login = ( in_array( $this->widgetsver, [ 'v2', 'v2-compat' ] ) ) ? 'c7-account' : 'c7-login';

			echo '<div id="c7wp-cart-box" class="' . esc_attr( $class ) . esc_attr( $color ) . '"><div id="' . esc_attr( $login ) . '"></div><div id="c7-cart"></div></div>';

		}
	}



	/**
	 * [c7wp] Shortcode for div output (used by pagebuilder elements, or in the editor)
	 *
	 * @param array $atts Attributes used on the shortcode.
	 *
	 * @return string
	 */
	public function c7wp_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'type'      => 'default',
				'data'      => '',
				'join-text' => __( 'Join Club', 'wp-commerce7' ),
				'edit-text' => __( 'Edit Membership', 'wp-commerce7' ),
			),
			$atts,
			'c7wp'
		);

		$allowed_types = array(
			'default',
			'personalization',
			'buy',
			'buyslug',
			'subscribe',
			'collection',
			'login',
			'cart',
			'reservation',
			'form',
			'joinnow',
			'quickshop',
			'createaccount',
			'loginform',
			'collectionlist',
		);

		if ( ! in_array( $atts['type'], $allowed_types, true ) ) {
			$atts['type'] = 'default';
		}

		$output = '<div class="c7wp-wrap" data-c7-type="' . $atts['type'] . '">';

		if ( in_array( $this->widgetsver, array( 'v2', 'v2-compat' ), true ) ) {
			$output .= $this->render_v2_widget( $atts );
		} else {
			$output .= $this->render_v1_widget( $atts );
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Render V2 widget output
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Widget HTML.
	 */
	private function render_v2_widget( $atts ) {
		switch ( $atts['type'] ) {
			case 'default':
				return '<div id="c7-content"></div>';

			case 'personalization':
				return '<div class="c7-personalization" data-block-code="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'subscribe':
				return ( 'true' === $atts['data'] ) ? '<div class="c7-subscribe" data-has-name-field="true"></div>' : '<div class="c7-subscribe"></div>';

			case 'collection':
				return '<div class="c7-product-collection" data-collection-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'login':
				return '<div id="c7-account"></div>';

			case 'cart':
				return '<div id="c7-cart"></div>';

			case 'reservation':
				return '<div class="c7-reservation-availability" data-reservation-type-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'form':
				return '<div class="c7-custom-form" data-form-code="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'joinnow':
				return '<div class="c7-club-join-button" 
					data-club-slug="' . esc_attr( $atts['data'] ) . '"
					data-join-text="' . esc_attr( $atts['join-text'] ) . '"
					data-edit-text="' . esc_attr( $atts['edit-text'] ) . '"
					></div>';

			case 'buyslug':
				return '<div class="c7-buy-product" data-product-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'loginform':
				return '<div id="c7-login-form" data-redirect-to="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'collectionlist':
				return '<div id="c7-collection-list"></div>';

			default:
				return '<div id="c7-content"></div>';
		}
	}

	/**
	 * Render V1 widget output
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Widget HTML.
	 */
	private function render_v1_widget( $atts ) {
		switch ( $atts['type'] ) {
			case 'default':
				return '<div id="c7-content"></div>';

			case 'personalization':
				return '<div class="c7-personalization" data-block-code="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'buy':
				return '<div class="c7-buy-variant" data-sku="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'buyslug':
				return '<div class="c7-buy-variant" data-product-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'subscribe':
				return ( 'true' === $atts['data'] ) ? '<div class="c7-subscribe" data-has-name-fields="true"></div>' : '<div class="c7-subscribe"></div>';

			case 'collection':
				return '<div class="c7-product-collection" data-collection-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'login':
				return '<div id="c7-login"></div>';

			case 'cart':
				return '<div id="c7-cart"></div>';

			case 'reservation':
				return '<div class="c7-reservation-availability" data-reservation-type-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'form':
				return '<div class="c7-form-wrapper" data-form-code="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'joinnow':
				return '<div class="c7-club-join-button" data-club-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'quickshop':
				return '<div id="c7-quick-shop" data-collection-slug="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'loginform':
				return '<div id="c7-login-form" data-redirect-to="' . esc_attr( $atts['data'] ) . '"></div>';

			case 'createaccount':
				return '<div id="c7-create-account" data-redirect-to="' . esc_attr( $atts['data'] ) . '"></div>';

			default:
				return '<div id="c7-content"></div>';
		}
	}

	/**
	 * Add post state text to clarify C7 pages for admins
	 *
	 * @param array  $post_states Array of post state messages.
	 * @param object $post WP Post object.
	 * @return array $post_states
	 */
	public function add_display_post_states( $post_states, $post ) {

		$options = $this->settings;
		if ( isset( $options['c7wp_widget_version'] ) && 'v2' === $options['c7wp_widget_version']
		&& isset( $options['c7wp_frontend_routes'] ) && 'yes' === $options['c7wp_enable_custom_routes'] ) {
			$pages = array_values( $options['c7wp_frontend_routes'] );
		} else {
			$pages = array(
				'profile',
				'collection',
				'product',
				'club',
				'checkout',
				'cart',
				'privacy',
				'terms',
				'reservation',
			);
		}

		if ( in_array( $post->post_name, $pages, true ) ) {
			$post_states['c7wp'] = esc_html__( 'Commerce7 Required Page', 'wp-commerce7' );
		}

		return $post_states;
	}


	/**
	 * Add body class for styles specificity and scope
	 */
	public function add_body_class( $classes ) {
		$classes[] = 'c7wp';
		return $classes;
	}

	/**
	 * Check if a page has proper Commerce7 content
	 *
	 * @param int|WP_Post $page Page ID or WP_Post object.
	 * @return bool True if page has proper C7 content.
	 */
	public function page_has_c7_content( $page ) {
		if ( is_numeric( $page ) ) {
			$page = get_post( $page );
		}

		if ( ! $page || 'page' !== $page->post_type ) {
			return false;
		}

		$content = $page->post_content;

		// Check for various C7 content patterns
		$patterns = array(
			'/c7-content/',                    // Basic C7 div
			'/wp:c7wp/',                       // Gutenberg blocks
			'/<!-- wp:c7wp/',                  // Gutenberg block comments
			'/\[c7wp/',                        // Shortcodes
			'/class="c7wp-/',                  // C7WP wrapper classes
		);

		foreach ( $patterns as $pattern ) {
			if ( preg_match( $pattern, $content ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get pages that need Commerce7 content
	 *
	 * @return array Array of page objects that need C7 content.
	 */
	public function get_pages_needing_c7_content() {
		$options = $this->settings;
		
		if ( isset( $options['c7wp_frontend_routes'] ) && 'yes' === $options['c7wp_enable_custom_routes'] ) {
			$required_pages = array_values( $options['c7wp_frontend_routes'] );
		} else {
			$required_pages = array( 'profile', 'collection', 'product', 'club', 'checkout', 'cart', 'reservation' );
		}

		$pages_needing_content = array();

		foreach ( $required_pages as $page_slug ) {
			$page = get_page_by_path( $page_slug, 'ARRAY_N', 'page' );
			if ( $page && ! $this->page_has_c7_content( $page[0] ) ) {
				$pages_needing_content[] = get_post( $page[0] );
			}
		}

		return $pages_needing_content;
	}

	/**
	 * Handle import/export actions
	 */
	public function handle_import_export() {
		// Check if we're on the Commerce7 settings page
		if ( ! isset( $_GET['page'] ) || 'commerce7' !== $_GET['page'] ) {
			return;
		}

		// Handle export
		if ( isset( $_POST['action'] ) && 'c7wp_export_settings' === $_POST['action'] ) {
			if ( ! isset( $_POST['c7wp_export_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['c7wp_export_nonce'] ) ), 'c7wp_export_settings' ) ) {
				wp_die( esc_html__( 'Security check failed', 'wp-commerce7' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have permission to export settings', 'wp-commerce7' ) );
			}

			$this->export_settings();
		}

		// Handle import
		if ( isset( $_POST['action'] ) && 'c7wp_import_settings' === $_POST['action'] ) {
			if ( ! isset( $_POST['c7wp_import_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['c7wp_import_nonce'] ) ), 'c7wp_import_settings' ) ) {
				wp_die( esc_html__( 'Security check failed', 'wp-commerce7' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have permission to import settings', 'wp-commerce7' ) );
			}

			$this->import_settings();
		}
	}

	/**
	 * Export settings to JSON file
	 */
	private function export_settings() {
		$settings = $this->settings;

		// Remove sensitive data
		unset( $settings['c7wp_tenant'] );

		$json = wp_json_encode( $settings, JSON_PRETTY_PRINT );
		$filename = 'c7wp-settings-' . gmdate( 'Y-m-d-H-i-s' ) . '.json';

		header( 'Content-Type: application/json' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		header( 'Content-Length: ' . strlen( $json ) );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON output for download
		echo $json;
		exit;
	}

	/**
	 * Import settings from uploaded file
	 */
	private function import_settings() {
		if ( ! isset( $_FILES['settings_file'] ) || ! isset( $_FILES['settings_file']['error'] ) || UPLOAD_ERR_OK !== $_FILES['settings_file']['error'] ) {
			add_action( 'admin_notices', function() {
				echo '<div class="notice notice-error"><p>' . esc_html__( 'Error uploading settings file.', 'wp-commerce7' ) . '</p></div>';
			});
			return;
		}

		$file = $_FILES['settings_file'];
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file upload
		$json = file_get_contents( $file['tmp_name'] );
		$settings = json_decode( $json, true );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			add_action( 'admin_notices', function() {
				echo '<div class="notice notice-error"><p>' . esc_html__( 'Invalid JSON file.', 'wp-commerce7' ) . '</p></div>';
			});
			return;
		}

		// Merge with existing settings to preserve tenant ID
		$existing_settings = $this->settings;
		$settings = array_merge( $existing_settings, $settings );

		update_option( 'c7wp_settings', $settings );
		$this->refresh_settings();

		add_action( 'admin_notices', function() {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Settings imported successfully.', 'wp-commerce7' ) . '</p></div>';
		});
	}
}
