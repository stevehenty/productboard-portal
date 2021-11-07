<?php
/*
Plugin Name: productboard portal embed
Description: Embed a productboard portal
Version: 1.0
Author: Steve Henty
Author URI: https://www.stevenhenty.com
License: GPL-3.0+

Copyright 2020 Steven Henty
*/

function sh_productboard_shortcode( $atts ) {

	$a = shortcode_atts( array(
		'annonymous_message' => esc_html__( 'Log in to view the portal', 'productboard-portal' ),
		'key_constant'       => 'PRODUCTBOARD_KEY',
		'url'                => '',
	), $atts );

	if ( empty( $a['url'] ) ) {
		return esc_html__( 'The "url" shortcode attribute is required', 'productboard-portal' );
	}

	$a['url'] = trailingslashit( $a['url'] );

	$key = defined( $a['key_constant'] ) ? constant( $a['key_constant'] ) : '';

	if ( empty( $key ) ) {
		return esc_html__( 'The productboard key must be set in a constant. The default constant name is PRODUCTBOARD_KEY.', 'productboard-portal' );
	}

	$user = wp_get_current_user();

	if ( empty ( $user->ID ) ) {
		return '';
	}

	require __DIR__ . '/vendor/autoload.php';

	$payload = array(
		"email" => $user->user_email,
		"id"    => $user->ID,
		"name"  => $user->display_name,
		'iat'   => time(),
		//"company_name" => '',
		//"company_domain" => ''
	);

	$jwt = \Firebase\JWT\JWT::encode( $payload, $key );

	$c = sanitize_text_field( rgget( 'c' ) );

	$card = empty( $c ) ? '' : 'c/' . $c;

	$html = "<iframe src='{$a['url']}{$card}?hide_header=1&token={$jwt}' frameborder='0' style='width:100%; height:1000px'></iframe>";

	return $html;
}

add_shortcode( 'productboard', 'sh_productboard_shortcode' );



