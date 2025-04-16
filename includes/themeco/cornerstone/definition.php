<?php
/**
 * Element Definition
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

class C7WP_CsElement {

	public function ui() {
		return array(
			'title' => __( 'Commerce7', 'wp-commerce7' ),
			'icon_group' => 'commerce7',
			'icon_id' => 'Layer_1',
		);
	}

	public function register_shortcode() {
		return false;
	}

	/**
	 * Shortcode name for the element
	 *
	 * @var string
	 */
	public $shortcode_name = 'c7wp';

}
