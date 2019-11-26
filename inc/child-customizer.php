<?php
/**
 * Newspack Style 4 Theme: Customizer
 *
 * @package Newspack Style 4
 */

/**
 * Remove the 'Style Pack' customizer option.
 */
function newspack_style_4_customizer( $wp_customize ) {
	$wp_customize->remove_control( 'active_style_pack' );
}
add_action( 'customize_register', 'newspack_style_4_customizer', 99 );
