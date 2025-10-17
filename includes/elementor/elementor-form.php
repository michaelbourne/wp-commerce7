<?php
/**
 * Elementor widget: Marketing Form
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, January 9th 2025, 1:51:33 pm
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
class C7WP_Elementor_Form extends \Elementor\Widget_Base {


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
		return 'commerce7-form';
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
		return __( 'Marketing Form', 'wp-commerce7' );
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
		return [ 'commerce7', 'form' ];
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
				'raw'             => '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><strong>Preview Notice:</strong> The preview shown in your editor is for example purposes only, it does not reflect the form you provide nor is it interactive.</div>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			]
		);

		$this->add_control(
			'data',
			[
				'label' 	  => __( 'Form Slug', 'wp-commerce7' ),
				'type'  	  => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'contact-us', 'wp-commerce7' ),
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
			?>
			<div class="c7-custom-form-placeholder" data-form-code="<?php echo esc_attr( $data ); ?>">
				<?php if ( $slugProvided ) : ?>
					<form class="c7-form">
						<fieldset>
							<legend class="c7-sr-only">Contact Us</legend>
							<div class="c7-form__field">
								<label class="c7-required">First & Last Name</label>
								<input name="fullName" type="text" value="" disabled tabindex="-1">
							</div>
							<div class="c7-form__field">
								<label class="c7-required">Country</label>
								<select name="countryCode" disabled tabindex="-1">
									<option value="CA">Canada</option>
									<option value="US">United States</option>
								</select>
							</div>
							<div class="c7-form__field">
								<label>Phone</label>
								<input name="phone" type="tel" value="" disabled tabindex="-1">
							</div>
							<div class="c7-form__field">
								<label class="c7-required">Email</label>
								<input name="email" type="email" value="" disabled tabindex="-1">
							</div>
							<div class="c7-form__field">
								<label class="c7-required">Questions/Comments</label>
								<textarea name="questions-comments" rows="3" disabled tabindex="-1"></textarea>
							</div>
						</fieldset>
						<div class="c7-form__buttons">
							<button type="submit" class="c7-btn c7-btn--primary" disabled tabindex="-1">
								<span>Submit</span>
							</button>
						</div>
					</form>
				<?php else : ?>
					<div class="c7-message c7-message--alert-error" role="presentation">
						<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"></circle>
							<line x1="12" y1="8" x2="12" y2="12"></line>
							<line x1="12" y1="16" x2="12.01" y2="16"></line>
						</svg>
						Please enter a form slug in the widget settings
					</div>
				<?php endif; ?>
			</div>
			<?php
		} else {
			// Frontend - show actual shortcode
			echo do_shortcode( '[c7wp type="form" data="' . $data . '"]' );
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
		#>
		<div class="c7-custom-form-placeholder" data-form-code="{{{ settings.data }}}">
			<# if (slugProvided) { #>
				<form class="c7-form">
					<fieldset>
						<legend class="c7-sr-only">Contact Us</legend>
						<div class="c7-form__field">
							<label class="c7-required">First & Last Name</label>
							<input name="fullName" type="text" value="" disabled tabindex="-1">
						</div>
						<div class="c7-form__field">
							<label class="c7-required">Country</label>
							<select name="countryCode" disabled tabindex="-1">
								<option value="CA">Canada</option>
								<option value="US">United States</option>
							</select>
						</div>
						<div class="c7-form__field">
							<label>Phone</label>
							<input name="phone" type="tel" value="" disabled tabindex="-1">
						</div>
						<div class="c7-form__field">
							<label class="c7-required">Email</label>
							<input name="email" type="email" value="" disabled tabindex="-1">
						</div>
						<div class="c7-form__field">
							<label class="c7-required">Questions/Comments</label>
							<textarea name="questions-comments" rows="3" disabled tabindex="-1"></textarea>
						</div>
					</fieldset>
					<div class="c7-form__buttons">
						<button type="submit" class="c7-btn c7-btn--primary" disabled tabindex="-1">
							<span>Submit</span>
						</button>
					</div>
				</form>
			<# } else { #>
				<div class="c7-message c7-message--alert-error" role="presentation">
					<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"></circle>
						<line x1="12" y1="8" x2="12" y2="12"></line>
						<line x1="12" y1="16" x2="12.01" y2="16"></line>
					</svg>
					Please enter a form slug in the widget settings
				</div>
			<# } #>
		</div>
		<?php
	}
	public function render_plain_content( $instance = [] ) {}

}