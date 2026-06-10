<?php
/**
 * Beaver Builder Integration
 *
 * @package   wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( class_exists( 'FLBuilder' ) ) {
	require_once C7WP_ROOT . '/includes/beaverbuilder/legacy/beaver-c7wp.php';
}

$elements = C7WP_Widgets::get_slugs_for_version( $this->widgetsver, 'beaverbuilder' );

foreach ( $elements as $element ) {
	require_once C7WP_ROOT . '/includes/beaverbuilder/' . $element . '/' . $element . '.php';
}
