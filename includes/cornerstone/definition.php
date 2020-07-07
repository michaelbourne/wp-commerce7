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

class C7WP_csElement {

	public function ui() {
		return array(
			'title' => __('Commerce7', 'commerce7-for-wordpress') ,
			'icon_group' => 'commerce7',
			'icon_id' => 'Layer_1'
		);
	}

	public function register_shortcode() {
		return false;
	}

	public $shortcode_name = 'c7wp';

}