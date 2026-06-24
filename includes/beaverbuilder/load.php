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
	C7WP_Widgets::register_clubselector_assets( C7WP::getInstance() );
	C7WP_Widgets::register_clubselector_v2_assets( C7WP::getInstance() );
}

$elements = C7WP_Widgets::get_slugs_for_version( $this->widgetsver, 'beaverbuilder' );

foreach ( $elements as $element ) {
	require_once C7WP_ROOT . '/includes/beaverbuilder/' . $element . '/' . $element . '.php';
}
