<?php
/**
 * Shared Club Selector v2 markup renderer.
 *
 * Uses pre-mounted Commerce7 join buttons (strategy A: show/hide per selection).
 *
 * @package wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Normalize club rows from builder-specific structures.
 *
 * @param array $clubs Raw club rows.
 * @return array
 */
function c7wp_normalize_clubselector_v2_clubs( $clubs ) {
	$normalized = array();

	if ( ! is_array( $clubs ) ) {
		return $normalized;
	}

	foreach ( $clubs as $club ) {
		if ( is_object( $club ) ) {
			$club = (array) $club;
		}

		$normalized[] = array(
			'slug'      => isset( $club['slug'] ) ? $club['slug'] : ( isset( $club['club_slug'] ) ? $club['club_slug'] : '' ),
			'name'      => isset( $club['name'] ) ? $club['name'] : ( isset( $club['club_name'] ) ? $club['club_name'] : '' ),
			'join_text' => isset( $club['joinText'] ) ? $club['joinText'] : ( isset( $club['join_text'] ) ? $club['join_text'] : __( 'Join Now', 'wp-commerce7' ) ),
			'edit_text' => isset( $club['editText'] ) ? $club['editText'] : ( isset( $club['edit_text'] ) ? $club['edit_text'] : __( 'Edit Membership', 'wp-commerce7' ) ),
		);
	}

	return $normalized;
}

/**
 * Render club selector v2 HTML.
 *
 * @param array $args {
 *     @type array  $clubs            Club rows with slug, name, join_text, edit_text.
 *     @type string $display_type     radio|select.
 *     @type string $radio_group_name Radio input group name.
 *     @type string $widget_id        Optional unique suffix for input ids.
 *     @type bool   $echo             Echo or return HTML.
 * }
 * @return string
 */
function c7wp_render_clubselector_v2( $args ) {
	$defaults = array(
		'clubs'            => array(),
		'display_type'     => 'radio',
		'radio_group_name' => 'club-selector-v2',
		'widget_id'        => uniqid( 'c7v2', false ),
		'echo'             => true,
	);

	$args = wp_parse_args( $args, $defaults );

	$valid_clubs = array();
	foreach ( c7wp_normalize_clubselector_v2_clubs( $args['clubs'] ) as $club ) {
		if ( ! empty( $club['slug'] ) && ! empty( $club['name'] ) ) {
			$valid_clubs[] = $club;
		}
	}

	$slugs = array_map(
		static function ( $club ) {
			return strtolower( $club['slug'] );
		},
		$valid_clubs
	);

	if ( empty( $valid_clubs ) || count( $slugs ) !== count( array_unique( $slugs ) ) ) {
		$message = empty( $valid_clubs )
			? __( 'Please add at least one valid club with slug and name.', 'wp-commerce7' )
			: __( 'Duplicate club slugs found. Please ensure each club has a unique slug.', 'wp-commerce7' );

		$html = '<div class="c7-clubselector-v2-error">' . esc_html( $message ) . '</div>';
		if ( $args['echo'] ) {
			echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return '';
		}
		return $html;
	}

	ob_start();
	?>
	<div class="club-selector-v2-wrapper" data-c7-widget-id="<?php echo esc_attr( $args['widget_id'] ); ?>">
		<?php if ( 'select' === $args['display_type'] ) : ?>
			<select class="club-select-v2" aria-label="<?php esc_attr_e( 'Choose your desired club', 'wp-commerce7' ); ?>">
				<?php foreach ( $valid_clubs as $index => $club ) : ?>
					<option value="<?php echo esc_attr( $club['slug'] ); ?>" <?php selected( $index, 0 ); ?>>
						<?php echo esc_html( $club['name'] ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php else : ?>
			<div class="club-radio-buttons-v2">
				<fieldset>
					<legend class="screen-reader-text"><?php esc_html_e( 'Choose your desired club', 'wp-commerce7' ); ?></legend>
					<div class="radios">
						<?php foreach ( $valid_clubs as $index => $club ) : ?>
							<div class="row">
								<input
									type="radio"
									name="<?php echo esc_attr( $args['radio_group_name'] ); ?>"
									id="club-v2-<?php echo esc_attr( $club['slug'] ); ?>-<?php echo esc_attr( $args['widget_id'] ); ?>"
									value="<?php echo esc_attr( $club['slug'] ); ?>"
									class="choice-v2"
									<?php checked( $index, 0 ); ?>
									aria-checked="<?php echo 0 === $index ? 'true' : 'false'; ?>"
									aria-label="<?php echo esc_attr( $club['name'] ); ?>"
								>
								<label for="club-v2-<?php echo esc_attr( $club['slug'] ); ?>-<?php echo esc_attr( $args['widget_id'] ); ?>">
									<?php echo esc_html( $club['name'] ); ?>
								</label>
							</div>
						<?php endforeach; ?>
					</div>
				</fieldset>
			</div>
		<?php endif; ?>

		<div class="club-join-buttons-v2">
			<?php foreach ( $valid_clubs as $index => $club ) : ?>
				<div
					class="club-join-button-wrap<?php echo 0 === $index ? ' is-active' : ''; ?>"
					data-club-slug="<?php echo esc_attr( $club['slug'] ); ?>"
					<?php echo 0 === $index ? '' : ' hidden'; ?>
					aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>"
				>
					<div
						class="c7-club-join-button"
						data-club-slug="<?php echo esc_attr( $club['slug'] ); ?>"
						data-join-text="<?php echo esc_attr( $club['join_text'] ); ?>"
						data-edit-text="<?php echo esc_attr( $club['edit_text'] ); ?>"
					></div>
				</div>
			<?php endforeach; ?>
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
