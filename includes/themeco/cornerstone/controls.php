<?php
/**
 * Element Controls
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

$options = get_option( 'c7wp_settings' );
if ( isset( $options['c7wp_widget_version'] ) && 'v2' == $options['c7wp_widget_version'] ) {
  return array(

    'type'   => array(
      'type'    => 'select',
      'ui'      => array(
        'title' => __( 'Element Type', 'wp-commerce7' ),
      ),
      'options' => array(
        'choices' => array(
          array( 'value' => 'default', 'label' => __( 'Default Content', 'wp-commerce7' )  ),
          array( 'value' => 'personalization', 'label' => __( 'Personalization Block', 'wp-commerce7' ) ),
          array( 'value' => 'buyslug', 'label' => __( 'Buy Now (Slug)', 'wp-commerce7' )  ),
          array( 'value' => 'subscribe', 'label' => __( 'Subscribe Form', 'wp-commerce7' ) ),
          array( 'value' => 'collection', 'label' => __( 'Collection Grid', 'wp-commerce7' )  ),
          array( 'value' => 'login', 'label' => __( 'Magic login link', 'wp-commerce7' ) ),
          array( 'value' => 'cart', 'label' => __( 'Magic cart link', 'wp-commerce7' ) ),
          array( 'value' => 'reservation', 'label' => __( 'Reservation Widget', 'wp-commerce7' ) ),
          array( 'value' => 'form', 'label' => __( 'General Form', 'wp-commerce7' ) ),
          array( 'value' => 'joinnow', 'label' => __( 'Join/Edit Club Magic Button', 'wp-commerce7' ) ),
        ),
      ),
    ),
    'data'   => array(
      'type' => 'text',
      'ui'   => array(
        'title' => __( 'Data/Slug', 'wp-commerce7' ),
      ),
    ),

    'common' => array( '!style', '!id', '!class' ),
  );
} else {
  return array(

    'type'   => array(
      'type'    => 'select',
      'ui'      => array(
        'title' => __( 'Element Type', 'wp-commerce7' ),
      ),
      'options' => array(
        'choices' => array(
          array( 'value' => 'default', 'label' => __( 'Default Content', 'wp-commerce7' )  ),
          array( 'value' => 'personalization', 'label' => __( 'Personalization Block', 'wp-commerce7' ) ),
          array( 'value' => 'buy', 'label' => __( 'Buy Now (SKU)', 'wp-commerce7' )  ),
          array( 'value' => 'buyslug', 'label' => __( 'Buy Now (Slug)', 'wp-commerce7' )  ),
          array( 'value' => 'subscribe', 'label' => __( 'Subscribe Form', 'wp-commerce7' ) ),
          array( 'value' => 'collection', 'label' => __( 'Collection Grid', 'wp-commerce7' )  ),
          array( 'value' => 'login', 'label' => __( 'Magic login link', 'wp-commerce7' ) ),
          array( 'value' => 'cart', 'label' => __( 'Magic cart link', 'wp-commerce7' ) ),
          array( 'value' => 'reservation', 'label' => __( 'Reservation Widget', 'wp-commerce7' ) ),
          array( 'value' => 'form', 'label' => __( 'General Form', 'wp-commerce7' ) ),
          array( 'value' => 'joinnow', 'label' => __( 'Join/Edit Club Magic Button', 'wp-commerce7' ) ),
          array( 'value' => 'quickshop', 'label' => __( 'Quick Shop Form', 'wp-commerce7' ) ),
          array( 'value' => 'loginform', 'label' => __( 'Login Form', 'wp-commerce7' ) ),
          array( 'value' => 'createaccount', 'label' => __( 'Create Account Form', 'wp-commerce7' ) ),
        ),
      ),
    ),
    'data'   => array(
      'type' => 'text',
      'ui'   => array(
        'title' => __( 'Data', 'wp-commerce7' ),
      ),
    ),

    'common' => array( '!style', '!id', '!class' ),
  );
}
