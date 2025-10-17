<?php
/**
 * Elementor widget: Magic Club Button
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, January 9th 2025, 1:51:36 pm
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
	protected function register_controls() { // phpcs:ignore

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Settings', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'preview_notice',
			[
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><strong>Preview Notice:</strong> The preview shown in your editor is for example purposes only, it does not reflect the club slug you provide nor is it interactive.</div>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
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

		// Show preview in Elementor editor, shortcode on frontend
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$slugProvided = !empty( $data );
			$joinText = !empty( $settings['join-text'] ) ? $settings['join-text'] : 'Join Now';
			$editText = !empty( $settings['edit-text'] ) ? $settings['edit-text'] : 'Edit Membership';
			?>
			<div class="c7-club-join-button-placeholder" data-club-slug="<?php echo esc_attr( $data ); ?>" data-join-text="<?php echo esc_attr( $joinText ); ?>" data-edit-text="<?php echo esc_attr( $editText ); ?>">
				<?php if ( $slugProvided ) : ?>
					<a class="c7-btn c7-btn--primary" role="link" tabindex="-1" disabled>
						<?php echo esc_html( $joinText ); ?>
					</a>
				<?php else : ?>
					<div class="c7-message c7-message--alert-error" role="presentation">
						<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"></circle>
							<line x1="12" y1="8" x2="12" y2="12"></line>
							<line x1="12" y1="16" x2="12.01" y2="16"></line>
						</svg>
						Please enter a club slug in the widget settings
					</div>
				<?php endif; ?>
			</div>
			<?php
		} else {
			// Frontend - show actual shortcode
			$extras = '';
			if ( ! empty( $settings['join-text'] ) ) {
				$extras .= ' join-text="' . esc_attr( $settings['join-text'] ) . '"';
			}
			if ( ! empty( $settings['edit-text'] ) ) {
				$extras .= ' edit-text="' . esc_attr( $settings['edit-text'] ) . '"';
			}
			echo do_shortcode( '[c7wp type="joinnow" data="' . $data . '"' . $extras . ']' );
		}
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		var slugProvided = settings.data && settings.data.length > 0;
		var joinText = settings['join-text'] || 'Join Now';
		var editText = settings['edit-text'] || 'Edit Membership';
		#>
		<div class="c7-club-join-button-placeholder" data-club-slug="{{{ settings.data }}}" data-join-text="{{{ joinText }}}" data-edit-text="{{{ editText }}}">
			<# if (slugProvided) { #>
				<a class="c7-btn c7-btn--primary" role="link" tabindex="-1" disabled>
					{{{ joinText }}}
				</a>
			<# } else { #>
				<div class="c7-message c7-message--alert-error" role="presentation">
					<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"></circle>
						<line x1="12" y1="8" x2="12" y2="12"></line>
						<line x1="12" y1="16" x2="12.01" y2="16"></line>
					</svg>
					Please enter a club slug in the widget settings
				</div>
			<# } #>
		</div>
		<?php
	}
	public function render_plain_content( $instance = [] ) {}

}