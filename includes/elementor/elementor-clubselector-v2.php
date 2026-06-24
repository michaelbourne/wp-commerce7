<?php
/**
 * Elementor widget: Club Selector v2
 *
 * @package   wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once C7WP_ROOT . '/includes/widgets/clubselector-v2-render.php';

/**
 * Club Selector v2 widget class.
 */
class C7WP_Elementor_Clubselector_V2 extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'commerce7-clubselector-v2';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Club Selector v2', 'wp-commerce7' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'c7icon-c7sm';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'commerce7' );
	}

	/**
	 * Retrieve widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'commerce7', 'club', 'selector', 'join', 'membership' );
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Club Selector v2 Settings', 'wp-commerce7' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'radio_group_name',
			array(
				'label'       => __( 'Radio Group Name', 'wp-commerce7' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'club-selector-v2',
				'placeholder' => __( 'premierclub', 'wp-commerce7' ),
				'description' => __( 'Must be unique if you use more than one Club Selector v2 widget on a page.', 'wp-commerce7' ),
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
			'join_text',
			array(
				'label'   => __( 'Join Text', 'wp-commerce7' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Join Now', 'wp-commerce7' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'edit_text',
			array(
				'label'   => __( 'Edit Membership Text', 'wp-commerce7' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Edit Membership', 'wp-commerce7' ),
				'dynamic' => array(
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
						'club_slug' => 'premier-club',
						'club_name' => __( 'Premier Club', 'wp-commerce7' ),
						'join_text' => __( 'Join Now', 'wp-commerce7' ),
						'edit_text' => __( 'Edit Membership', 'wp-commerce7' ),
					),
				),
				'title_field' => '{{{ club_name }}}',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get script dependencies.
	 *
	 * @return array Widget script dependencies.
	 */
	public function get_script_depends() {
		return array( 'c7wp-clubselector-v2-frontend' );
	}

	/**
	 * Get style dependencies.
	 *
	 * @return array Widget style dependencies.
	 */
	public function get_style_depends() {
		return array( 'c7wp-clubselector-v2-frontend' );
	}

	/**
	 * Render Commerce widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		c7wp_render_clubselector_v2(
			array(
				'clubs'            => c7wp_normalize_clubselector_v2_clubs( $settings['clubs'] ),
				'display_type'     => $settings['display_type'],
				'radio_group_name' => ! empty( $settings['radio_group_name'] ) ? $settings['radio_group_name'] : 'club-selector-v2',
				'widget_id'        => $this->get_id(),
			)
		);
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template() {
		?>
		<#
		var clubs = settings.clubs;
		var displayType = settings.display_type;
		var radioGroupName = settings.radio_group_name || 'club-selector-v2';
		var validClubs = [];

		clubs.forEach(function(club) {
			if (club.club_slug && club.club_name) {
				validClubs.push(club);
			}
		});

		if (validClubs.length === 0) {
		#>
			<div class="elementor-alert elementor-alert-warning">
				<span class="elementor-alert-title"><?php esc_html_e( 'Club Selector v2', 'wp-commerce7' ); ?></span>
				<span class="elementor-alert-description"><?php esc_html_e( 'Please add at least one valid club with slug and name.', 'wp-commerce7' ); ?></span>
			</div>
		<#
			return;
		}
		#>
		<div class="club-selector-v2-wrapper">
			<# if (displayType === 'radio') { #>
				<div class="club-radio-buttons-v2">
					<fieldset>
						<legend class="screen-reader-text"><?php esc_html_e( 'Choose your desired club', 'wp-commerce7' ); ?></legend>
						<div class="radios">
							<# validClubs.forEach(function(club, index) { #>
								<div class="row">
									<input
										type="radio"
										name="{{{ radioGroupName }}}"
										id="club-v2-{{{ club.club_slug }}}-{{{ view.getID() }}}"
										value="{{{ club.club_slug }}}"
										class="choice-v2"
										<# if (index === 0) { #>checked<# } #>
										aria-label="{{{ club.club_name }}}"
									>
									<label for="club-v2-{{{ club.club_slug }}}-{{{ view.getID() }}}">
										{{{ club.club_name }}}
									</label>
								</div>
							<# }); #>
						</div>
					</fieldset>
				</div>
			<# } else { #>
				<select class="club-select-v2" aria-label="<?php esc_attr_e( 'Choose your desired club', 'wp-commerce7' ); ?>">
					<# validClubs.forEach(function(club, index) { #>
						<option value="{{{ club.club_slug }}}" <# if (index === 0) { #>selected<# } #>>
							{{{ club.club_name }}}
						</option>
					<# }); #>
				</select>
			<# } #>

			<div class="club-join-buttons-v2">
				<# validClubs.forEach(function(club, index) { #>
					<div
						class="club-join-button-wrap<# if (index === 0) { #> is-active<# } #>"
						data-club-slug="{{{ club.club_slug }}}"
						<# if (index !== 0) { #>hidden<# } #>
						aria-hidden="<# if (index === 0) { #>false<# } else { #>true<# } #>"
					>
						<div
							class="c7-club-join-button"
							data-club-slug="{{{ club.club_slug }}}"
							data-join-text="{{{ club.join_text || '<?php echo esc_js( __( 'Join Now', 'wp-commerce7' ) ); ?>' }}}"
							data-edit-text="{{{ club.edit_text || '<?php echo esc_js( __( 'Edit Membership', 'wp-commerce7' ) ); ?>' }}}"
						></div>
					</div>
				<# }); #>
			</div>
		</div>
		<?php
	}
}
