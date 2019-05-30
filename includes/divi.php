<?php
/**
* Divi Integration
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


class C7WP_Divi extends ET_Builder_Module {
	public $slug       = 'c7wp_content';
	public $vb_support = 'on';
	public function init() {
		$this->name = esc_html__( 'Commerce7 Content', 'commerce7-for-wordpress' );
	}
	public function get_fields() {
		return array(
			'data'     => array(
				'label'           => esc_html__( 'Data', 'commerce7-for-wordpress' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter the data for your selected type, if applicable.', 'commerce7-for-wordpress' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}
	public function render( $unprocessed_props, $content = null, $render_slug ) {
		
		$type = esc_attr( $this->props['type'] );
		$data = esc_attr( $this->props['data'] );

		ob_start();

		echo do_shortcode( '[c7wp type="' . $type . '" data="' . $data . '"]' );

		return ob_get_clean();
	}
}
new C7WP_Divi;