<?php
/**
 * Load all Elementor widgets
 *
 * @package   wp-commerce7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once C7WP_ROOT . '/includes/elementor/elementor-legacy.php';
C7WP_Widgets::register_clubselector_assets( C7WP::getInstance() );
C7WP_Widgets::register_clubselector_v2_assets( C7WP::getInstance() );
\Elementor\Plugin::instance()->widgets_manager->register( new \C7WP_Elementor() );

$elements = C7WP_Widgets::get_slugs_for_version( $this->widgetsver, 'elementor' );

foreach ( $elements as $element ) {
	require_once C7WP_ROOT . '/includes/elementor/elementor-' . $element . '.php';
	$class = '\C7WP_Elementor_' . C7WP_Widgets::get_builder_class_suffix( $element );
	\Elementor\Plugin::instance()->widgets_manager->register( new $class() );
}
