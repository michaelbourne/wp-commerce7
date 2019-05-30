<?php
/**
* Element Controls
*
* @package   Commerce7 for WordPress
* @author    Michael Bourne
* @license   GPL3
* @link      https://ursa6.com
* @since     1.0.0
*/

return array(

  'type' => array(
    'type' => 'select',
    'ui'   => array(
      'title'   => __( 'Element Type', 'commerce7-for-wordpress' ),
    ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'default',  'label' => __( 'Default Content', 'commerce7-for-wordpress' )  ),
        array( 'value' => 'personalization', 'label' => __( 'Personalization Block', 'commerce7-for-wordpress' ) ),
        array( 'value' => 'buy',  'label' => __( 'Buy Now Button', 'commerce7-for-wordpress' )  ),
        array( 'value' => 'subscribe', 'label' => __( 'Subscribe Form', 'commerce7-for-wordpress' ) ),
        array( 'value' => 'collection',  'label' => __( 'Collection Grid', 'commerce7-for-wordpress' )  ),
        array( 'value' => 'login', 'label' => __( 'Magic login link', 'commerce7-for-wordpress' ) ),
        array( 'value' => 'cart', 'label' => __( 'Magic cart link', 'commerce7-for-wordpress' ) ),
        array( 'value' => 'reservation', 'label' => __( 'Reservation Widget', 'commerce7-for-wordpress' ) ),
        array( 'value' => 'form', 'label' => __( 'General Form', 'commerce7-for-wordpress' ) ),
      ),
    ),
  ),

  'data' => array(
    'type' => 'text',
    'ui'   => array(
      'title' => __( 'Data', 'commerce7-for-wordpress' ),
    ),
  ),

  'common' => array( '!style', '!id', '!class' )
);