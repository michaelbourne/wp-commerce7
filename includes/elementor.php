<?php
/**
* Elementor Integration
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
		return __( 'Commerce7', 'commerce7-for-wordpress' );
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
		return [ 'general' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' 	=> __( 'Content', 'commerce7-for-wordpress' ),
				'tab' 		=> \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'type',
			[
				'label' 	=> __( 'Content Type', 'commerce7-for-wordpress' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> 'default',
				'options' 	=> [
					'default'  			=> __( 'Default Content', 'commerce7-for-wordpress' ),
					'personalization' 	=> __( 'Personalization Block', 'commerce7-for-wordpress' ),
					'buy' 				=> __( 'Buy Now Button', 'commerce7-for-wordpress' ),
					'subscribe' 		=> __( 'Subscribe Form', 'commerce7-for-wordpress' ),
					'collection' 		=> __( 'Collection Grid', 'commerce7-for-wordpress' ),
					'login' 			=> __( 'Login/Logout Link', 'commerce7-for-wordpress' ),
					'cart' 				=> __( 'Cart Data Link', 'commerce7-for-wordpress' ),
					'reservation' 		=> __( 'Reservation Widget', 'commerce7-for-wordpress' ),
					'form' 				=> __( 'General Form', 'commerce7-for-wordpress' ),
					'joinnow' 			=> __( 'Join/Edit Club magic button', 'commerce7-for-wordpress' ),
				],
			]
		);

		$this->add_control(
			'data',
			[
				'label' 	=> __( 'Data', 'commerce7-for-wordpress' ),
				'type' 		=> \Elementor\Controls_Manager::TEXT,
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

		echo do_shortcode('[c7wp type="' . $type . '" data="' . $data . '"]');

	}


	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}


}