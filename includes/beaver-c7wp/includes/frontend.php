<?php
/**
* Beaver Builder Integration
*
* @package   Commerce7 for WordPress
* @author    Michael Bourne
* @license   GPL3
* @link      https://ursa6.com
* @since     1.0.0
*/

$type = (isset( $settings->ctype ) && '' != $settings->ctype) ? esc_attr( $settings->ctype ) : 'default';
$data = (isset( $settings->cdata )) ? esc_attr( $settings->cdata ) : '' ;

echo do_shortcode('[c7wp type="' . $type . '" data="' . $data . '"]');