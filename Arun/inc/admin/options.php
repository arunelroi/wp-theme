<?php

if ( ! defined( 'ARUN_OPTION_NAME' ) ) {
	$theme_name = sanitize_key( '' . wp_get_theme() );
	define( 'ARUN_OPTION_NAME', $theme_name );
}

if ( ! defined( 'ARUN_THEME_URI' ) ) {
	define( 'ARUN_THEME_URI', 'https://wp-puzzle.com/' );
}

define( 'ARUN_OPTION_NAME', 'arun_theme_options_' . ARUN_OPTION_NAME );


/* ==========================================================================
* 	customize get_option for theme options
* ========================================================================== */
if ( ! function_exists( 'arun_get_theme_option' ) ) :
	function arun_get_theme_option( $key, $default = false ) {

		$cache = wp_cache_get( ARUN_OPTION_NAME );
		if ( $cache ) {
			return ( isset( $cache[ $key ] ) ) ? $cache[ $key ] : $default;
		}

		$opt = get_option( ARUN_OPTION_NAME );

		wp_cache_add( ARUN_OPTION_NAME, $opt );

		return ( isset( $opt[ $key ] ) ) ? $opt[ $key ] : $default;
	}
endif;
/* ============================================================================= */


/* ==========================================================================
* 	customize get_option for theme options
* ========================================================================== */
function arun_backward_compatible_theme_option_name() {

	$old_option_name = 'theme_options_' . get_template();
	$old_option      = get_option( $old_option_name );

	if ( false == $old_option ) {
		return;
	}

	delete_option( ARUN_OPTION_NAME );
	update_option( ARUN_OPTION_NAME, $old_option );

	delete_option( $old_option_name );

}

add_action( 'init', 'arun_backward_compatible_theme_option_name' );
/* ============================================================================= */

