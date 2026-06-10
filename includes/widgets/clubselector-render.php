<?php
/**
 * Shared Club Selector markup renderer.
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Render club selector HTML.
 *
 * @param array $args {
 *     @type array  $clubs            Club rows with club_slug, club_name, button_text.
 *     @type string $display_type     radio|select.
 *     @type string $radio_group_name   Radio input group name.
 *     @type string $widget_id          Optional unique suffix for input ids.
 *     @type string $button_link_class  CSS class for the button anchor.
 *     @type string $wrapper_class      Extra wrapper classes.
 * }
 * @return string
 */
function c7wp_render_clubselector( $args ) {
	$defaults = array(
		'clubs'             => array(),
		'display_type'      => 'radio',
		'radio_group_name'  => 'club-selector',
		'widget_id'         => uniqid( 'c7', false ),
		'button_link_class' => 'club-selector-button',
		'wrapper_class'     => '',
		'echo'              => true,
	);

	$args = wp_parse_args( $args, $defaults );

	$valid_clubs = array();
	foreach ( $args['clubs'] as $club ) {
		if ( ! empty( $club['club_slug'] ) && ! empty( $club['club_name'] ) && ! empty( $club['button_text'] ) ) {
			$valid_clubs[] = $club;
		}
	}

	$slugs        = array_map(
		static function ( $club ) {
			return strtolower( $club['club_slug'] );
		},
		$valid_clubs
	);
	$unique_slugs = array_unique( $slugs );

	if ( empty( $valid_clubs ) || count( $slugs ) !== count( $unique_slugs ) ) {
		$message = empty( $valid_clubs )
			? __( 'Please add at least one valid club with slug, name, and button text.', 'wp-commerce7' )
			: __( 'Duplicate club slugs found. Please ensure each club has a unique slug.', 'wp-commerce7' );

		$html = '<div class="c7-clubselector-error">' . esc_html( $message ) . '</div>';
		if ( $args['echo'] ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return '';
		}
		return $html;
	}

	$options    = get_option( 'c7wp_settings', array() );
	$club_route = isset( $options['c7wp_frontend_routes']['club'] ) ? $options['c7wp_frontend_routes']['club'] : 'club';
	$first_club = $valid_clubs[0];
	$button_url = '/' . trailingslashit( ltrim( $club_route, '/' ) ) . trailingslashit( $first_club['club_slug'] );

	ob_start();
	?>
	<div class="club-selector-wrapper <?php echo esc_attr( $args['wrapper_class'] ); ?>" data-c7-widget-id="<?php echo esc_attr( $args['widget_id'] ); ?>">
		<?php if ( 'select' === $args['display_type'] ) : ?>
			<select class="club-select" aria-label="<?php esc_attr_e( 'Choose your desired club', 'wp-commerce7' ); ?>">
				<?php foreach ( $valid_clubs as $index => $club ) : ?>
					<option value="<?php echo esc_attr( $club['club_slug'] ); ?>" data-button-text="<?php echo esc_attr( $club['button_text'] ); ?>" <?php selected( $index, 0 ); ?>>
						<?php echo esc_html( $club['club_name'] ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php else : ?>
			<div class="club-radio-buttons">
				<fieldset>
					<legend class="screen-reader-text"><?php esc_html_e( 'Choose your desired club', 'wp-commerce7' ); ?></legend>
					<div class="radios">
						<?php foreach ( $valid_clubs as $index => $club ) : ?>
							<div class="row">
								<input
									type="radio"
									name="<?php echo esc_attr( $args['radio_group_name'] ); ?>"
									id="club-<?php echo esc_attr( $club['club_slug'] ); ?>-<?php echo esc_attr( $args['widget_id'] ); ?>"
									value="<?php echo esc_attr( $club['club_slug'] ); ?>"
									data-button-text="<?php echo esc_attr( $club['button_text'] ); ?>"
									class="choice"
									<?php checked( $index, 0 ); ?>
									aria-checked="<?php echo 0 === $index ? 'true' : 'false'; ?>"
									aria-label="<?php echo esc_attr( $club['club_name'] ); ?>"
								>
								<label for="club-<?php echo esc_attr( $club['club_slug'] ); ?>-<?php echo esc_attr( $args['widget_id'] ); ?>">
									<?php echo esc_html( $club['club_name'] ); ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</fieldset>
			</div>
		<?php endif; ?>

		<div class="club-button">
			<a href="<?php echo esc_url( $button_url ); ?>" class="<?php echo esc_attr( $args['button_link_class'] ); ?>">
				<?php echo esc_html( $first_club['button_text'] ); ?>
			</a>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	if ( $args['echo'] ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return '';
	}

	return $html;
}

/**
 * Normalize club rows from builder-specific structures.
 *
 * @param array $clubs Raw club rows.
 * @return array
 */
function c7wp_normalize_clubselector_clubs( $clubs ) {
	$normalized = array();

	if ( ! is_array( $clubs ) ) {
		return $normalized;
	}

	foreach ( $clubs as $club ) {
		if ( is_object( $club ) ) {
			$club = (array) $club;
		}

		$normalized[] = array(
			'club_slug'   => isset( $club['club_slug'] ) ? $club['club_slug'] : ( isset( $club['slug'] ) ? $club['slug'] : '' ),
			'club_name'   => isset( $club['club_name'] ) ? $club['club_name'] : ( isset( $club['name'] ) ? $club['name'] : '' ),
			'button_text' => isset( $club['button_text'] ) ? $club['button_text'] : ( isset( $club['button'] ) ? $club['button'] : '' ),
		);
	}

	return $normalized;
}
