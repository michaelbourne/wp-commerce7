<?php
/**
 * Element rendering on front end
 *
 * Created Date: Thursday September 3rd 2020
 * Author: Michael Bourne
 * -----
 * Last Modified: Thursday, September 3rd 2020, 7:38:06 pm
 * Modified By: Michael Bourne
 * -----
 * Copyright (c) 2020 URSA6
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$ctype = 'joinnow';
$data  = ( isset( $settings->cdata ) ) ? esc_attr( $settings->cdata ) : '';

echo do_shortcode( '[c7wp type="' . $ctype . '" data="' . $data . '"]' );