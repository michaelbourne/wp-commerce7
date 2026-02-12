<?php
/**
 * Elementor widget: Reservation Form
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Wednesday, February 11th 2026, 8:26:26 pm
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
class C7WP_Elementor_Reservation extends \Elementor\Widget_Base {


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
		return 'commerce7-reservation';
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
		return __( 'Reservation Form', 'wp-commerce7' );
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
		return array( 'commerce7' );
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
		return array( 'commerce7', 'reserve', 'reservation' );
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
			array(
				'label' => __( 'Settings', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'preview_notice',
			array(
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><strong>Preview Notice:</strong> The preview shown in your editor is for example purposes only, it does not reflect the experience slug you provide nor is it interactive.</div>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			)
		);

		$this->add_control(
			'data',
			array(
				'label'       => __( 'Experience Slug', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'estate-tour', 'wp-commerce7' ),
			)
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
			$slugProvided = ! empty( $data );
			?>
			<div class="c7-reservation-availability-placeholder" data-reservation-type-slug="<?php echo esc_attr( $data ); ?>">
				<?php if ( $slugProvided ) : ?>
					<section class="c7-reservation__search">
						<form class="c7-form">
							<div class="c7-form__group">
								<div class="c7-form__field">
									<label class="c7-required">Date</label>
									<div class="c7-date-picker-input">
										<input type="text" placeholder="MMM DD YYYY" value="" tabindex="-1" disabled>
										<button type="button" class="c7-date-picker-toggle" tabindex="-1" disabled>
											<span role="img">
												<span class="dashicons dashicons-calendar-alt" aria-hidden="true"></span>
											</span>
										</button>
									</div>
								</div>
								<div class="c7-form__field">
									<label class="c7-required">Time</label>
									<select tabindex="-1" disabled>
										<option value=""></option>
										<option value="10:00:00">10:00 am</option>
										<option value="10:30:00">10:30 am</option>
										<option value="11:00:00">11:00 am</option>
										<option value="11:30:00">11:30 am</option>
										<option value="12:00:00">12:00 pm</option>
										<option value="12:30:00">12:30 pm</option>
										<option value="13:00:00">1:00 pm</option>
										<option value="13:30:00">1:30 pm</option>
										<option value="14:00:00">2:00 pm</option>
										<option value="14:30:00">2:30 pm</option>
										<option value="15:00:00">3:00 pm</option>
										<option value="15:30:00">3:30 pm</option>
										<option value="16:00:00">4:00 pm</option>
									</select>
								</div>
								<div class="c7-form__field">
									<label class="c7-required">No of Guests</label>
									<select tabindex="-1" disabled>
										<option value=""></option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
								<button type="submit" class="c7-btn c7-btn--primary" tabindex="-1" disabled>
									<span>Check Availability</span>
								</button>
							</div>
						</form>
					</section>
				<?php else : ?>
					<div class="c7-message c7-message--alert-error" role="presentation">
						<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="12" cy="12" r="10"></circle>
							<line x1="12" y1="8" x2="12" y2="12"></line>
							<line x1="12" y1="16" x2="12.01" y2="16"></line>
						</svg>
						Please enter the single experience slug in the widget settings
					</div>
				<?php endif; ?>
			</div>
			<?php
		} else {
			// Frontend - show actual shortcode
			echo do_shortcode( '[c7wp type="reservation" data="' . $data . '"]' );
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
		<div class="c7-reservation-availability-placeholder" data-reservation-type-slug="{{{ settings.data }}}">
			<# if (slugProvided) { #>
				<section class="c7-reservation__search">
					<form class="c7-form">
						<div class="c7-form__group">
							<div class="c7-form__field">
								<label class="c7-required">Date</label>
								<div class="c7-date-picker-input">
									<input type="text" placeholder="MMM DD YYYY" value="" tabindex="-1" disabled>
									<button type="button" class="c7-date-picker-toggle" tabindex="-1" disabled>
										<span role="img">
											<span class="dashicons dashicons-calendar-alt" aria-hidden="true"></span>
										</span>
									</button>
								</div>
							</div>
							<div class="c7-form__field">
								<label class="c7-required">Time</label>
								<select tabindex="-1" disabled>
									<option value=""></option>
									<option value="10:00:00">10:00 am</option>
									<option value="10:30:00">10:30 am</option>
									<option value="11:00:00">11:00 am</option>
									<option value="11:30:00">11:30 am</option>
									<option value="12:00:00">12:00 pm</option>
									<option value="12:30:00">12:30 pm</option>
									<option value="13:00:00">1:00 pm</option>
									<option value="13:30:00">1:30 pm</option>
									<option value="14:00:00">2:00 pm</option>
									<option value="14:30:00">2:30 pm</option>
									<option value="15:00:00">3:00 pm</option>
									<option value="15:30:00">3:30 pm</option>
									<option value="16:00:00">4:00 pm</option>
								</select>
							</div>
							<div class="c7-form__field">
								<label class="c7-required">No of Guests</label>
								<select tabindex="-1" disabled>
									<option value=""></option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
							<button type="submit" class="c7-btn c7-btn--primary" tabindex="-1" disabled>
								<span>Check Availability</span>
							</button>
						</div>
					</form>
				</section>
			<# } else { #>
				<div class="c7-message c7-message--alert-error" role="presentation">
					<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"></circle>
						<line x1="12" y1="8" x2="12" y2="12"></line>
						<line x1="12" y1="16" x2="12.01" y2="16"></line>
					</svg>
					Please enter the single experience slug in the widget settings
				</div>
			<# } #>
		</div>
		<?php
	}
	public function render_plain_content( $instance = array() ) {}

}
