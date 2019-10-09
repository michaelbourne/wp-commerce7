<?php
/**
* C7WP Class
*
* @package   Commerce7 for WordPress
* @author    Michael Bourne
* @license   GPL3
* @link      https://ursa6.com
* @since     1.0.0
*/

if( ! defined( 'ABSPATH' ) ) {
	return;
}

class C7WP {

		/**
		 * Core singleton class
		 *
		 * @var self - pattern realization
		 */
		private static $_instance;

		/**
		 * Prefix for plugin
		 *
		 * @var $prefix
		 */
		private $prefix;


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
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'c7wp_elementor_registered' ) );

			// add admin styles and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			// for front end
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts_clean', array( $this, 'enqueue_scripts' ), 10 );
			add_filter( 'script_loader_tag', array( $this, 'add_data_to_c7_script'), 10, 3  );
			add_action( 'wp_footer', array( $this, 'footer_inject') );


			// main variables
			$this->prefix = 'c7wp_';

			// load translations
			add_action( 'plugins_loaded', array( $this, 'c7wp_load_textdomain' ) );

			// c7 div output for certain pagebuilders
			add_shortcode('c7wp', array($this, 'c7wp_shortcode'));
		
		}

		/**
		 * Get the instance of C7WP Plugins
		 *
		 * @return self
		 */
		public static function getInstance() {

			if ( ! ( self::$_instance instanceof self ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}

		/**
		 * @param mixed $instance
		 */
		public static function setInstance( $instance ) {

			self::$_instance = $instance;

		}

		/**
		 * Init main functions (for hook admin_init)
		 */
		public function admin_init() {

			$this->settings_init();

		}

		/**
		 * Public Init main functions
		 */
		public function public_init() {

			$this->add_c7_rewrites();

			if ( get_option( 'c7wp_activation' ) == true ) {
				delete_option('c7wp_activation');
				flush_rewrite_rules();
			}

		}

		/**
		 * Register custom query var for later use
		 */
		public function register_query_vars($vars) {

			$vars[] = 'c7slug';
			return $vars;

		}

		/**
		 * Load elements after plugins loaded
		 */
		public function load_elements() {

			// WP Bakery Support
			if( defined( 'WPB_VC_VERSION' ) ) require_once(C7WP_ROOT . '/includes/wpbakery.php');

			// Coming Soon: Divi Support
			//if( defined( 'ET_BUILDER_VERSION' ) ) include 'includes/divi.php';

			// Beaver Builder Support
			if( defined( 'FL_BUILDER_VERSION' ) ) require_once(C7WP_ROOT . '/includes/beaverbuilder.php');

		}

		/**
		 * Cornerstone element
		 */
		public function load_cs_elements() {

			// Cornerstone Support
			if( class_exists( 'Cornerstone_Plugin' ) || function_exists('cornerstone_boot') ) require_once(C7WP_ROOT . '/includes/cornerstone.php');

		}

		/**
		 * Elementor element
		 */
		public function c7wp_elementor_registered() {

			require_once 'includes/elementor.php';
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \C7WP_Elementor() );

		}

		/**
		 * Internationalization
		 */
		public function c7wp_load_textdomain() {
			load_plugin_textdomain( 'commerce7-for-wordpress', false, C7WP_ROOT . '/languages/' );
		}

		/**
		 * Add new pages to admin
		 */
		public function add_admin_menu() {

			add_menu_page( 
				__( 'Commerce7 for Wordpress', 'commerce7-for-wordpress' ), 
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

			include_once 'includes/template.options.page.php';

		}


		/**
		 * C7WP settings init
		 */
		protected function settings_init() {

			register_setting( 'commerce7', 'c7wp_settings' );

			add_settings_section(
				'c7wp_commerce7_section', 
				false, 
				false, 
				'commerce7'
			);

			add_settings_field( 
				'c7wp_tenant', 
				__( 'Tenant ID', 'commerce7-for-wordpress' ), 
				array(
					$this,
					'c7wp_tenant_render',
				),
				'commerce7', 
				'c7wp_commerce7_section' 
			);

			add_settings_field( 
				'c7wp_display_cart', 
				__( 'Display Cart Box?', 'commerce7-for-wordpress' ), 
				array(
					$this,
					'c7wp_display_cart_render',
				), 
				'commerce7', 
				'c7wp_commerce7_section' 
			);

			add_settings_field( 
				'c7wp_display_cart_location', 
				__( 'Cart Box Location', 'commerce7-for-wordpress' ), 
				array(
					$this,
					'c7wp_display_cart_location_render',
				), 
				'commerce7', 
				'c7wp_commerce7_section' 
			);

			add_settings_field( 
				'c7wp_display_cart_color', 
				__( 'Cart Box Theme', 'commerce7-for-wordpress' ), 
				array(
					$this,
					'c7wp_display_cart_color_render',
				), 
				'commerce7', 
				'c7wp_commerce7_section' 
			);

		}

		public function c7wp_tenant_render(  ) { 

			$options = get_option( 'c7wp_settings' );
			?>
			<input type='text' name='c7wp_settings[c7wp_tenant]' value='<?php echo $options['c7wp_tenant']; ?>'>
			<?php

		}

		public function c7wp_display_cart_render(  ) { 

			$options = get_option( 'c7wp_settings' );
			?>
			<select name='c7wp_settings[c7wp_display_cart]' class='c7displaycart'>
				<option value='yes' <?php selected( $options['c7wp_display_cart'], 'yes' ); ?>>Yes</option>
				<option value='no' <?php selected( $options['c7wp_display_cart'], 'no' ); ?>>No</option>
			</select>

			<?php

		}

		public function c7wp_display_cart_location_render(  ) { 

			$options = get_option( 'c7wp_settings' );
			$disabled = ($options['c7wp_display_cart'] == 'no') ? 'disabled' : '';
			?>
			<select name='c7wp_settings[c7wp_display_cart_location]' class='c7cartloc' <?php echo $disabled; ?>>
				<option value='tl' <?php selected( $options['c7wp_display_cart_location'], 'tl' ); ?>>Top left</option>
				<option value='tr' <?php selected( $options['c7wp_display_cart_location'], 'tr' ); ?>>Top right</option>
				<option value='br' <?php selected( $options['c7wp_display_cart_location'], 'br' ); ?>>Bottom right</option>
				<option value='bl' <?php selected( $options['c7wp_display_cart_location'], 'bl' ); ?>>Bottom left</option>
			</select>

			<?php

		}

		public function c7wp_display_cart_color_render(  ) { 

			$options = get_option( 'c7wp_settings' );
			$disabled = ($options['c7wp_display_cart'] == 'no') ? 'disabled' : '';
			?>
			<select name='c7wp_settings[c7wp_display_cart_color]' class='c7cartcolor' <?php echo $disabled; ?>>
				<option value='light' <?php selected( $options['c7wp_display_cart_color'], 'light' ); ?>>Light website</option>
				<option value='dark' <?php selected( $options['c7wp_display_cart_color'], 'dark' ); ?>>Dark website</option>
			</select>
			<p><small>Please select the color theme for the Cart Box. "Light website" is for light colored or white background site, "Dark website" is for dark colored or black background sites.</small></p>

			<?php

		}



		/**
		 * Enqueue admin scripts
		 */
		public function admin_enqueue_scripts() {

			wp_enqueue_style( 'commerce7-for-wordpress-admin', C7WP_URI . 'assets/css/commerce7-for-wordpress-admin.css', array(), C7WP_VERSION );

		}

		/**
		 * Enqueue public scripts
		 */
		public function enqueue_scripts() {

			wp_enqueue_style( 'commerce7-for-wordpress', C7WP_URI . 'assets/css/commerce7-for-wordpress.css', array(), C7WP_VERSION );
			wp_register_script( 'c7js', 'https://cdn.commerce7.com/beta/commerce7.js', array(), C7WP_VERSION, true );
			wp_enqueue_script( 'c7js' );
			wp_register_style( 'c7css', 'https://cdn.commerce7.com/beta/commerce7.css', false, C7WP_VERSION );
			wp_enqueue_style ( 'c7css' );

		}


		/**
		 * Add custom attributes to enqueued C7 script. Add RocketLoader false sync flag in case customer uses CloudFlare.
		 * 
		 * @param string $tag
		 * @param string $handle
		 * @param string $src
		 *
		 * @return string
		 */

		public function add_data_to_c7_script( $tag, $handle, $src ) {
			if ( 'c7js' === $handle ) {
				$options = get_option( 'c7wp_settings' );
				$tag = '<script data-cfasync="false" type="text/javascript" src="' . esc_url( $src ) . '" id="c7-javascript" data-tenant="' . $options['c7wp_tenant'] . '"></script>';
			}

			return $tag;
		}



		/**
		 * Add rewrite rules to WordPress for Commerce7 static routes
		 * 
		 */
		public function add_c7_rewrites() {

			add_rewrite_rule(
        		'^(profile|collection|product|club|checkout|reservation)/(.+)/?$',
        		'index.php?pagename=$matches[1]&c7slug=$matches[2]',
        		'top'
    		);

		}



		/**
		 * Add Cart Box to body
		 * 
		 */
		public function footer_inject() {

			$options = get_option( 'c7wp_settings' );
			if ( $options['c7wp_display_cart'] == 'yes' ) {

				$color = ($options['c7wp_display_cart_color'] == 'dark') ? 'c7dark' : 'c7light';

				switch ($options['c7wp_display_cart_location']) {
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

				echo '<div id="c7wp-cart-box" class="' . $class . $color . '"><div id="c7-login"></div><div id="c7-cart"></div></div>';

			}
			

		}



		/**
		 * [c7wp] Shortcode for div output (used by pagebuilder elements, or in the editor)
		 * 
		 * @param array $atts
		 * 
		 */
		public function c7wp_shortcode($atts) {

			$atts = shortcode_atts(
				array(
					'type' => 'default',
					'data' => '',
				), 
				$atts, 
				'c7wp' 
			);

			$allowed_types = array(
				'default',
				'personalization',
				'buy',
				'subscribe',
				'collection',
				'login',
				'cart',
				'reservation',
				'form',
				'joinnow'
			);

			if ( !in_array($atts['type'], $allowed_types) ) $atts['type'] = 'default';

			$output = '<div class="c7wp-wrap" data-c7-type="' . $atts['type'] . '">';

			switch ($atts['type']) {
				case 'default':
					$output .= '<div id="c7-content"></div>';
					break;
				
				case 'personalization':
					$output .= '<div class="c7-personalization" data-block-code="' . esc_attr($atts['data']) . '"></div>';
					break;

				case 'buy':
					$output .= '<div class="c7-buy-variant" data-sku="' . esc_attr($atts['data']) . '"></div>';
					break;

				case 'subscribe':
					$output .= ($atts['data'] == 'true') ? '<div class="c7-subscribe" data-has-name-fields="true"></div>' : '<div class="c7-subscribe"></div>';
					break;

				case 'collection':
					$output .= '<div class="c7-product-collection" data-collection-slug="' . esc_attr($atts['data']) . '"></div>';
					break;

				case 'login':
					$output .= '<div id="c7-login"></div>';
					break;

				case 'cart':
					$output .= '<div id="c7-cart"></div>';
					break;

				case 'reservation':
					$output .= '<div class="c7-reservation-availability" data-reservation-type-slug="' . esc_attr($atts['data']) . '"></div>';
					break;

				case 'form':
					$output .= '<div class="c7-form-wrapper" data-form-code="' . esc_attr($atts['data']) . '"></div>';
					break;

				case 'joinnow':
					$output .= '<div class="c7-club-join-button" data-club-slug="' . esc_attr($atts['data']) . '"></div>';
					break;

				default:
					$output .= '<div id="c7-content"></div>';
					break;
			}

			$output .= '</div>';

			return $output;

		}


}

function commerce7_wp_manager() {
	return C7WP::getInstance();
}

commerce7_wp_manager();