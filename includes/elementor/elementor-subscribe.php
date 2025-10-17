<?php
/**
 * Elementor widget: Subscribe Form
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Tuesday, September 16th 2025, 10:35:48 pm
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
class C7WP_Elementor_Subscribe extends \Elementor\Widget_Base {


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
		return 'commerce7-subscribe';
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
		return __( 'Subscribe Form', 'wp-commerce7' );
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
		return [ 'commerce7', 'subscribe', 'email' ];
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
				'raw'             => '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><strong>Preview Notice:</strong> The preview shown in your editor is for example purposes only.</div>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);

		$this->add_control(
			'data',
			[
				'label'   => __( 'Show Name Fields?', 'wp-commerce7' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'false' => [
						'title' => __( 'No', 'wp-commerce7' ),
						'icon'  => 'fa fa-times',
					],
					'true'  => [
						'title' => __( 'Yes', 'wp-commerce7' ),
						'icon'  => 'fa fa-check',
					],
				],
				'default' => 'false',
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
			$showNameField = ( $data === 'true' );
			?>
			<div class="c7-subscribe-placeholder" data-has-name-field="<?php echo esc_attr( $data ); ?>">
				<form class="c7-form">
					<div class="c7-form__group">
						<?php if ( $showNameField ) : ?>
							<div class="c7-form__field">
								<label class="c7-required">First & Last Name</label>
								<input name="fullName" type="text" tabindex="-1" disabled value="">
							</div>
						<?php endif; ?>
						<div class="c7-form__field">
							<label class="c7-required">Email</label>
							<input name="email" type="email" tabindex="-1" disabled value="">
						</div>
						<button type="submit" tabindex="-1" disabled class="c7-btn c7-btn--primary">
							<span>Subscribe</span>
						</button>
					</div>
				</form>
			</div>
			<?php
		} else {
			// Frontend - show actual shortcode
			echo do_shortcode( '[c7wp type="subscribe" data="' . $data . '"]' );
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
		var showNameField = settings.data === 'true';
		#>
		<div class="c7-subscribe-placeholder" data-has-name-field="{{{ settings.data }}}">
			<form class="c7-form">
				<div class="c7-form__group">
					<# if (showNameField) { #>
						<div class="c7-form__field">
							<label class="c7-required">First & Last Name</label>
							<input name="fullName" type="text" tabindex="-1" disabled value="">
						</div>
					<# } #>
					<div class="c7-form__field">
						<label class="c7-required">Email</label>
						<input name="email" type="email" tabindex="-1" disabled value="">
					</div>
					<button type="submit" tabindex="-1" disabled class="c7-btn c7-btn--primary">
						<span>Subscribe</span>
					</button>
				</div>
			</form>
		</div>
		<?php
	}
	public function render_plain_content( $instance = [] ) {}

}