<?php
/**
 * Elementor widget: Buy Button (single Variant)
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Monday, October 4th 2021, 12:09:18 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2020 URSA6
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Widget class
 */
class C7WP_Elementor_Buy extends \Elementor\Widget_Base {


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
		return 'commerce7-buy';
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
		return __( 'Buy Button (SKU)', 'wp-commerce7' );
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
		return 'c7icon-c7sm';
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
	 * Retrieve widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'commerce7', 'buy', 'button' ];
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
				'label' => __( 'Settings', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'data',
			[
				'label' 	  => __( 'Variant SKU', 'wp-commerce7' ),
				'type'  	  => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'ABC123', 'wp-commerce7' ),
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

		$data = esc_attr( $settings['data'] );

		echo do_shortcode( '[c7wp type="buy" data="' . $data . '"]' );

	}

	protected function _content_template() {} //phpcs:ignore
	public function render_plain_content( $instance = [] ) {}

}