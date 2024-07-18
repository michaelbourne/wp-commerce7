<?php
/**
 * Elementor Integration
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
 * Legacy Widget class
 */
class C7WP_Elementor extends \Elementor\Widget_Base {


	/**
	 * Get widget name.
	 *
	 * Retrieve Commerce7 widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'commerce7';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Commerce7 widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Commerce7 (Deprecated)', 'wp-commerce7' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Commerce7 widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'commerce7' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => __( 'Content Type', 'wp-commerce7' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  		  => __( 'Default Content', 'wp-commerce7' ),
					'personalization' => __( 'Personalization Block', 'wp-commerce7' ),
					'buy' 			  => __( 'Buy Now (SKU)', 'wp-commerce7' ),
					'buyslug' 		  => __( 'Buy Now (Slug)', 'wp-commerce7' ),
					'subscribe' 	  => __( 'Subscribe Form', 'wp-commerce7' ),
					'collection' 	  => __( 'Collection Grid', 'wp-commerce7' ),
					'login' 		  => __( 'Login/Logout Link', 'wp-commerce7' ),
					'cart' 			  => __( 'Cart Data Link', 'wp-commerce7' ),
					'reservation' 	  => __( 'Reservation Widget', 'wp-commerce7' ),
					'form' 			  => __( 'General Form', 'wp-commerce7' ),
					'joinnow' 		  => __( 'Join/Edit Club magic button', 'wp-commerce7' ),
					'quickshop'		  => __( 'Quick Shop form', 'wp-commerce7' ),
					'loginform'		  => __( 'Login Form', 'wp-commerce7' ),
					'createaccount'	  => __( 'Create account form', 'wp-commerce7' ),
				],
			]
		);

		$this->add_control(
			'data',
			[
				'label' => __( 'Data/Slug', 'wp-commerce7' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render Commerce widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$type = esc_attr( $settings['type'] );
		$data = esc_attr( $settings['data'] );

		echo do_shortcode( '[c7wp type="' . $type . '" data="' . $data . '"]' );

	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}

}