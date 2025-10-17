<?php
/**
 * Elementor widget: Club Selector
 *
 * Created Date: Wednesday September 2nd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Tuesday, September 16th 2025, 10:04:18 pm
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
class C7WP_Elementor_Clubselector extends \Elementor\Widget_Base {

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
		return 'commerce7-clubselector';
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
		return __( 'Club Selector', 'wp-commerce7' );
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
		return array( 'commerce7', 'club', 'selector', 'membership' );
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Club Selector Settings', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'radio_group_name',
			array(
				'label'       => __( 'Radio Group Name', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'club-selector',
				'placeholder' => __( 'premierclub', 'wp-commerce7' ),
				'description' => __( 'This must be unique if you use more than one Club Selector widget on a page. Use plain text only, such as premierclub or cruclub.', 'wp-commerce7' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'display_type',
			array(
				'label'   => __( 'Display Type', 'wp-commerce7' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'radio',
				'options' => array(
					'radio'  => __( 'Radio Buttons', 'wp-commerce7' ),
					'select' => __( 'Dropdown', 'wp-commerce7' ),
				),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'club_slug',
			array(
				'label'       => __( 'Club Slug', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( '12-bottle-club', 'wp-commerce7' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'club_name',
			array(
				'label'       => __( 'Club Name', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( '12 Bottles', 'wp-commerce7' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'button_text',
			array(
				'label'       => __( 'Button Text', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Join the 12 Bottle Club', 'wp-commerce7' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'clubs',
			array(
				'label'       => __( 'Clubs', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'club_slug'   => 'premier-club',
						'club_name'   => __( 'Premier Club', 'wp-commerce7' ),
						'button_text' => __( 'Join Premier Club', 'wp-commerce7' ),
					),
				),
				'title_field' => '{{{ club_name }}}',
			)
		);

		$this->end_controls_section();

		// Style Section - Radio Buttons
		$this->start_controls_section(
			'radio_style_section',
			array(
				'label'     => __( 'Radio Buttons', 'wp-commerce7' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'display_type' => 'radio',
				),
			)
		);

		$this->add_control(
			'radio_spacing',
			array(
				'label'      => __( 'Spacing', 'wp-commerce7' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 8,
				),
				'selectors'  => array(
					'{{WRAPPER}} .club-radio-buttons .row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'radio_label_color',
			array(
				'label'     => __( 'Label Color', 'wp-commerce7' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .club-radio-buttons label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'radio_label_typography',
				'label'    => __( 'Label Typography', 'wp-commerce7' ),
				'selector' => '{{WRAPPER}} .club-radio-buttons label',
			)
		);

		$this->end_controls_section();

		// Style Section - Dropdown
		$this->start_controls_section(
			'select_style_section',
			array(
				'label'     => __( 'Dropdown', 'wp-commerce7' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'display_type' => 'select',
				),
			)
		);

		$this->add_control(
			'select_padding',
			array(
				'label'      => __( 'Padding', 'wp-commerce7' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .club-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'select_border_radius',
			array(
				'label'      => __( 'Border Radius', 'wp-commerce7' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .club-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'select_background_color',
			array(
				'label'     => __( 'Background Color', 'wp-commerce7' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .club-select' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'select_text_color',
			array(
				'label'     => __( 'Text Color', 'wp-commerce7' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .club-select' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'select_border',
				'label'    => __( 'Border', 'wp-commerce7' ),
				'selector' => '{{WRAPPER}} .club-select',
			)
		);

		$this->end_controls_section();

		// Style Section - Button
		$this->start_controls_section(
			'button_style_section',
			array(
				'label' => __( 'Button', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_margin',
			array(
				'label'      => __( 'Margin', 'wp-commerce7' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .club-button .elementor-button-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'wp-commerce7' ),
				'selector' => '{{WRAPPER}} .club-button .elementor-button-link',
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => __( 'Text Color', 'wp-commerce7' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .club-button .elementor-button-link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => __( 'Background Color', 'wp-commerce7' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .club-button .elementor-button-link' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'label'    => __( 'Border', 'wp-commerce7' ),
				'selector' => '{{WRAPPER}} .club-button .elementor-button-link',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'wp-commerce7' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .club-button .elementor-button-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_padding',
			array(
				'label'      => __( 'Padding', 'wp-commerce7' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .club-button .elementor-button-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get script dependencies.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget script dependencies.
	 */
	public function get_script_depends() {
		// Always try to load the frontend script for clubselector functionality
		// The script will be registered either by Gutenberg loader or fallback method
		return array( 'c7wp-clubselector-frontend' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget style dependencies.
	 */
	public function get_style_depends() {
		// Always try to load the frontend style for clubselector functionality
		// The style will be registered either by Gutenberg loader or fallback method
		return array( 'c7wp-clubselector-frontend' );
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

		// Validate settings
		$clubs            = $settings['clubs'];
		$display_type     = $settings['display_type'];
		$radio_group_name = ! empty( $settings['radio_group_name'] ) ? $settings['radio_group_name'] : 'club-selector';

		// Filter out empty clubs and validate
		$valid_clubs = array();
		foreach ( $clubs as $club ) {
			if ( ! empty( $club['club_slug'] ) && ! empty( $club['club_name'] ) && ! empty( $club['button_text'] ) ) {
				$valid_clubs[] = $club;
			}
		}

		// Check for duplicate slugs
		$slugs = array_map(
			function( $club ) {
				return strtolower( $club['club_slug'] );
			},
			$valid_clubs
		);
		$unique_slugs = array_unique( $slugs );

		if ( empty( $valid_clubs ) || count( $slugs ) !== count( $unique_slugs ) ) {
			echo '<div class="elementor-alert elementor-alert-warning">';
			echo '<span class="elementor-alert-title">' . esc_html__( 'Club Selector Error', 'wp-commerce7' ) . '</span>';
			echo '<span class="elementor-alert-description">';
			if ( empty( $valid_clubs ) ) {
				echo esc_html__( 'Please add at least one valid club with slug, name, and button text.', 'wp-commerce7' );
			} else {
				echo esc_html__( 'Duplicate club slugs found. Please ensure each club has a unique slug.', 'wp-commerce7' );
			}
			echo '</span>';
			echo '</div>';
			return;
		}

		// Get the first club for default button
		$first_club           = $valid_clubs[0];
		$default_button_text  = $first_club['button_text'];

		// Get club route from settings
		$options              = get_option( 'c7wp_settings' );
		$club_route           = isset( $options['c7wp_frontend_routes']['club'] ) ? $options['c7wp_frontend_routes']['club'] : 'club';
		$default_button_url   = '/' . $club_route . '/' . $first_club['club_slug'] . '/';

		?>
		<div class="club-selector-wrapper" data-elementor-widget-id="<?php echo esc_attr( $this->get_id() ); ?>">
			<?php if ( 'radio' === $display_type ) : ?>
				<div class="club-radio-buttons">
					<fieldset>
						<legend class="screen-reader-text"><?php esc_html_e( 'Choose your desired club', 'wp-commerce7' ); ?></legend>
						<div class="radios">
							<?php foreach ( $valid_clubs as $index => $club ) : ?>
								<div class="row">
									<input 
										type="radio" 
										name="<?php echo esc_attr( $radio_group_name ); ?>" 
										id="club-<?php echo esc_attr( $club['club_slug'] ); ?>-<?php echo esc_attr( $this->get_id() ); ?>" 
										value="<?php echo esc_attr( $club['club_slug'] ); ?>" 
										data-button-text="<?php echo esc_attr( $club['button_text'] ); ?>" 
										class="choice" 
										<?php checked( $index, 0 ); ?>
										aria-checked="<?php echo 0 === $index ? 'true' : 'false'; ?>"
										aria-label="<?php echo esc_attr( $club['club_name'] ); ?>"
									>
									<label for="club-<?php echo esc_attr( $club['club_slug'] ); ?>-<?php echo esc_attr( $this->get_id() ); ?>">
										<?php echo esc_html( $club['club_name'] ); ?>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
					</fieldset>
				</div>
			<?php else : ?>
				<select class="club-select" aria-label="<?php esc_attr_e( 'Choose your desired club', 'wp-commerce7' ); ?>">
					<?php foreach ( $valid_clubs as $index => $club ) : ?>
						<option 
							value="<?php echo esc_attr( $club['club_slug'] ); ?>" 
							data-button-text="<?php echo esc_attr( $club['button_text'] ); ?>" 
							<?php selected( $index, 0 ); ?>
						>
							<?php echo esc_html( $club['club_name'] ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>

			<div class="club-button">
				<a href="<?php echo esc_url( $default_button_url ); ?>" class="elementor-button-link elementor-button">
					<?php echo esc_html( $default_button_text ); ?>
				</a>
			</div>
		</div>
		<?php
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
		var clubs = settings.clubs;
		var displayType = settings.display_type;
		var radioGroupName = settings.radio_group_name || 'club-selector';
		var validClubs = [];
		
		// Filter out empty clubs
		clubs.forEach(function(club) {
			if (club.club_slug && club.club_name && club.button_text) {
				validClubs.push(club);
			}
		});
		
		if (validClubs.length === 0) {
		#>
			<div class="elementor-alert elementor-alert-warning">
				<span class="elementor-alert-title"><?php esc_html_e( 'Club Selector Error', 'wp-commerce7' ); ?></span>
				<span class="elementor-alert-description"><?php esc_html_e( 'Please add at least one valid club with slug, name, and button text.', 'wp-commerce7' ); ?></span>
			</div>
		<#
			return;
		}
		
		var firstClub = validClubs[0];
		var defaultButtonText = firstClub.button_text;
		var defaultButtonUrl = '#';
		#>
		<div class="club-selector-wrapper">
			<# if (displayType === 'radio') { #>
				<div class="club-radio-buttons">
					<fieldset>
						<legend class="screen-reader-text"><?php esc_html_e( 'Choose your desired club', 'wp-commerce7' ); ?></legend>
						<div class="radios">
							<# validClubs.forEach(function(club, index) { #>
								<div class="row">
									<input 
										type="radio" 
										name="{{{ radioGroupName }}}" 
										id="club-{{{ club.club_slug }}}-{{{ view.getID() }}}" 
										value="{{{ club.club_slug }}}" 
										data-button-text="{{{ club.button_text }}}" 
										class="choice" 
										<# if (index === 0) { #>checked<# } #>
										aria-checked="<# if (index === 0) { #>true<# } else { #>false<# } #>"
										aria-label="{{{ club.club_name }}}"
									>
									<label for="club-{{{ club.club_slug }}}-{{{ view.getID() }}}">
										{{{ club.club_name }}}
									</label>
								</div>
							<# }); #>
						</div>
					</fieldset>
				</div>
			<# } else { #>
				<select class="club-select" aria-label="<?php esc_attr_e( 'Choose your desired club', 'wp-commerce7' ); ?>">
					<# validClubs.forEach(function(club, index) { #>
						<option 
							value="{{{ club.club_slug }}}" 
							data-button-text="{{{ club.button_text }}}" 
							<# if (index === 0) { #>selected<# } #>
						>
							{{{ club.club_name }}}
						</option>
					<# }); #>
				</select>
			<# } #>

			<div class="club-button">
				<a href="{{{ defaultButtonUrl }}}" class="elementor-button-link elementor-button">
					{{{ defaultButtonText }}}
				</a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render plain content.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content( $instance = array() ) {
		// This method is required by Elementor but not used for this widget
	}
}