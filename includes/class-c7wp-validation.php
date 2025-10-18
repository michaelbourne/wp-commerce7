<?php
/**
 * Commerce7 Block Validation Helper
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validation helper class for Commerce7 blocks and widgets
 */
class C7WP_Validation {

	/**
	 * Validate a slug format
	 *
	 * @param string $slug The slug to validate.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_slug( $slug ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		if ( empty( $slug ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Slug cannot be empty.', 'wp-commerce7' );
			return $result;
		}

		// Check length
		if ( strlen( $slug ) > 50 ) {
			$result['valid']   = false;
			$result['message'] = __( 'Slug must be 50 characters or less.', 'wp-commerce7' );
			return $result;
		}

		// Check for valid characters (alphanumeric, hyphens, underscores)
		if ( ! preg_match( '/^[a-zA-Z0-9_-]+$/', $slug ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Slug can only contain letters, numbers, hyphens, and underscores.', 'wp-commerce7' );
			return $result;
		}

		// Check for reserved words
		$reserved_words = array( 'admin', 'api', 'wp-admin', 'wp-content', 'wp-includes', 'feed', 'comments', 'search', 'author', 'archives', 'attachment', 'page', 'paged', 'embed', 'trackback', 'xmlrpc' );
		if ( in_array( strtolower( $slug ), $reserved_words, true ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'This slug is reserved and cannot be used.', 'wp-commerce7' );
			return $result;
		}

		return $result;
	}

	/**
	 * Validate club data array
	 *
	 * @param array $clubs Array of club data.
	 * @return array Validation result with 'valid' boolean and 'messages' array.
	 */
	public static function validate_club_data( $clubs ) {
		$result = array(
			'valid'    => true,
			'messages' => array(),
		);

		if ( ! is_array( $clubs ) || empty( $clubs ) ) {
			$result['valid']     = false;
			$result['messages'][] = __( 'At least one club is required.', 'wp-commerce7' );
			return $result;
		}

		$slugs = array();
		foreach ( $clubs as $index => $club ) {
			$club_num = $index + 1;

			// Validate slug
			if ( empty( $club['slug'] ) ) {
				$result['valid']     = false;
				$result['messages'][] = sprintf( __( 'Club #%d has no slug.', 'wp-commerce7' ), $club_num );
			} else {
				$slug_validation = self::validate_slug( $club['slug'] );
				if ( ! $slug_validation['valid'] ) {
					$result['valid']     = false;
					$result['messages'][] = sprintf( __( 'Club #%1$d: %2$s', 'wp-commerce7' ), $club_num, $slug_validation['message'] );
				}

				// Check for duplicate slugs
				$slug_lower = strtolower( $club['slug'] );
				if ( in_array( $slug_lower, $slugs, true ) ) {
					$result['valid']     = false;
					$result['messages'][] = sprintf( __( 'Club #%d has a duplicate slug.', 'wp-commerce7' ), $club_num );
				}
				$slugs[] = $slug_lower;
			}

			// Validate name
			if ( empty( $club['name'] ) ) {
				$result['valid']     = false;
				$result['messages'][] = sprintf( __( 'Club #%d has no name.', 'wp-commerce7' ), $club_num );
			} elseif ( strlen( $club['name'] ) > 100 ) {
				$result['valid']     = false;
				$result['messages'][] = sprintf( __( 'Club #%d name must be 100 characters or less.', 'wp-commerce7' ), $club_num );
			}

			// Validate button text
			if ( empty( $club['buttonText'] ) ) {
				$result['valid']     = false;
				$result['messages'][] = sprintf( __( 'Club #%d has no button text.', 'wp-commerce7' ), $club_num );
			} elseif ( strlen( $club['buttonText'] ) > 50 ) {
				$result['valid']     = false;
				$result['messages'][] = sprintf( __( 'Club #%d button text must be 50 characters or less.', 'wp-commerce7' ), $club_num );
			}
		}

		return $result;
	}

	/**
	 * Validate collection slug
	 *
	 * @param string $slug The collection slug to validate.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_collection_slug( $slug ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		if ( empty( $slug ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Collection slug cannot be empty.', 'wp-commerce7' );
			return $result;
		}

		return self::validate_slug( $slug );
	}

	/**
	 * Validate form ID
	 *
	 * @param string $form_id The form ID to validate.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_form_id( $form_id ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		if ( empty( $form_id ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Form ID cannot be empty.', 'wp-commerce7' );
			return $result;
		}

		// Form IDs are typically alphanumeric
		if ( ! preg_match( '/^[a-zA-Z0-9_-]+$/', $form_id ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Form ID can only contain letters, numbers, hyphens, and underscores.', 'wp-commerce7' );
			return $result;
		}

		return $result;
	}

	/**
	 * Validate reservation type
	 *
	 * @param string $type The reservation type to validate.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_reservation_type( $type ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		$valid_types = array( 'tasting', 'tour', 'event', 'dining', 'custom' );
		if ( ! in_array( $type, $valid_types, true ) ) {
			$result['valid']   = false;
			$result['message'] = sprintf( __( 'Invalid reservation type. Must be one of: %s', 'wp-commerce7' ), implode( ', ', $valid_types ) );
			return $result;
		}

		return $result;
	}

	/**
	 * Validate display type for collections
	 *
	 * @param string $display_type The display type to validate.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_display_type( $display_type ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		$valid_types = array( 'grid', 'list', 'carousel' );
		if ( ! in_array( $display_type, $valid_types, true ) ) {
			$result['valid']   = false;
			$result['message'] = sprintf( __( 'Invalid display type. Must be one of: %s', 'wp-commerce7' ), implode( ', ', $valid_types ) );
			return $result;
		}

		return $result;
	}

	/**
	 * Validate items per row setting
	 *
	 * @param int $items_per_row The number of items per row.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_items_per_row( $items_per_row ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		$items_per_row = intval( $items_per_row );
		if ( $items_per_row < 1 || $items_per_row > 6 ) {
			$result['valid']   = false;
			$result['message'] = __( 'Items per row must be between 1 and 6.', 'wp-commerce7' );
			return $result;
		}

		return $result;
	}

	/**
	 * Validate radio group name
	 *
	 * @param string $name The radio group name to validate.
	 * @return array Validation result with 'valid' boolean and 'message' string.
	 */
	public static function validate_radio_group_name( $name ) {
		$result = array(
			'valid'   => true,
			'message' => '',
		);

		if ( empty( $name ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Radio group name cannot be empty.', 'wp-commerce7' );
			return $result;
		}

		// Radio group names should be valid HTML name attributes
		if ( ! preg_match( '/^[a-zA-Z][a-zA-Z0-9_-]*$/', $name ) ) {
			$result['valid']   = false;
			$result['message'] = __( 'Radio group name must start with a letter and contain only letters, numbers, hyphens, and underscores.', 'wp-commerce7' );
			return $result;
		}

		return $result;
	}

	/**
	 * Sanitize and validate text input
	 *
	 * @param string $text The text to sanitize and validate.
	 * @param int    $max_length Maximum allowed length.
	 * @return array Result with 'sanitized' string and 'valid' boolean.
	 */
	public static function sanitize_text_input( $text, $max_length = 255 ) {
		$result = array(
			'sanitized' => '',
			'valid'     => true,
			'message'   => '',
		);

		$sanitized = sanitize_text_field( $text );
		$result['sanitized'] = $sanitized;

		if ( strlen( $sanitized ) > $max_length ) {
			$result['valid']   = false;
			$result['message'] = sprintf( __( 'Text must be %d characters or less.', 'wp-commerce7' ), $max_length );
		}

		return $result;
	}

	/**
	 * Get validation error message for display
	 *
	 * @param array $validation_result The validation result array.
	 * @return string Formatted error message.
	 */
	public static function get_error_message( $validation_result ) {
		if ( $validation_result['valid'] ) {
			return '';
		}

		if ( isset( $validation_result['messages'] ) && is_array( $validation_result['messages'] ) ) {
			return implode( ' ', $validation_result['messages'] );
		}

		return $validation_result['message'] ?? __( 'Validation failed.', 'wp-commerce7' );
	}
}
