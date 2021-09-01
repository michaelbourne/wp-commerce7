<?php
/**
 * Beaver Builder Integration
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

$ctype = ( isset( $settings->ctype ) && '' != $settings->ctype ) ? esc_attr( $settings->ctype ) : 'default';
$data  = ( isset( $settings->cdata ) ) ? esc_attr( $settings->cdata ) : '';

echo do_shortcode( '[c7wp type="' . $ctype . '" data="' . $data . '"]' );
