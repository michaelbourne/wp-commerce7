<?php
/**
 * Elementor widget: Magic Club Button
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Wednesday, November 8th 2023, 4:03:34 pm
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
class C7WP_Elementor_Joinnow extends \Elementor\Widget_Base {


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
		return 'commerce7-joinnow';
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
		return __( 'Club Join Button', 'wp-commerce7' );
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
		return [ 'commerce7', 'join', 'club', 'button' ];
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
				'label' 	  => __( 'Club Slug', 'wp-commerce7' ),
				'type'  	  => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( '12-bottle-reds', 'wp-commerce7' ),
			]
		);

		$this->add_control(
			'join-text',
			[
				'label' 	  => __( 'Join Club Text', 'wp-commerce7' ),
				'type'  	  => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Join Club', 'wp-commerce7' ),
			]
		);

		$this->add_control(
			'edit-text',
			[
				'label' 	  => __( 'Edit Membership Text', 'wp-commerce7' ),
				'type'  	  => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Edit Membership', 'wp-commerce7' ),
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

		$extras = '';

		if ( ! empty( $settings['join-text'] ) ) {
			$extras .= ' join-text="' . esc_attr( $settings['join-text'] ) . '"';
		}
		if ( ! empty( $settings['edit-text'] ) ) {
			$extras .= ' edit-text="' . esc_attr( $settings['edit-text'] ) . '"';
		}

		echo do_shortcode( '[c7wp type="joinnow" data="' . $data . '"' . $extras . ']' );
	}

	protected function _content_template() {} //phpcs:ignore
	public function render_plain_content( $instance = [] ) {}

}