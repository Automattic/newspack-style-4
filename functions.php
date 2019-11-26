<?php

if ( ! function_exists( 'newspack_style_4_setup' ) ) :
	function newspack_style_4_setup() {
		// Remove the default editor styles
		remove_editor_styles();

		// Add child theme editor styles, compiled from `style-child-theme-editor.scss`.
		add_editor_style( 'style-editor.css' );

	}

endif;
add_action( 'after_setup_theme', 'newspack_style_4_setup', 12 );

/**
 * Function to load style pack's Google Fonts.
 */
function newspack_style_4_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by IBM Plex Serif, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$ibm_plex_serif = esc_html_x( 'on', 'IBM Plex Serif font: on or off', 'newspack-style-4' );

	if ( 'off' !== $ibm_plex_serif ) {
		$font_families = array();

		$font_families[] = 'IBM Plex Serif:400,400i,700,700i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
			'display' => urlencode( 'swap' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return esc_url_raw( $fonts_url );
}

/**
 * Remove the 'Style Pack' customizer option.
 */
function newspack_style_4_customizer( $wp_customize ) {
	$wp_customize->remove_control( 'active_style_pack' );
}
add_action( 'customize_register', 'newspack_style_4_customizer' );


/**
 * Display custom color CSS in customizer and on frontend.
 */
function newspack_style_4_custom_colors_css_wrap() {

	// Only bother if we haven't customized the color.
	if ( ( ! is_customize_preview() && 'default' === get_theme_mod( 'theme_colors', 'default' ) ) || is_admin() ) {
		return;
	}

	require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
	?>

	<style type="text/css" id="custom-theme-colors-style-4">
		<?php echo newspack_style_4_custom_colors_css(); ?>
	</style>
	<?php
}
add_action( 'wp_head', 'newspack_style_4_custom_colors_css_wrap' );

/**
 * Display custom font CSS in customizer and on frontend.
 */
function newspack_style_4_typography_css_wrap() {

	if ( is_admin() || ( ! get_theme_mod( 'font_body', '' ) && ! get_theme_mod( 'font_header', '' ) && ! get_theme_mod( 'accent_allcaps', true ) ) ) {
		return;
	}
	?>

	<style type="text/css" id="custom-theme-fonts-style-4">
		<?php echo wp_kses( newspack_style_4_custom_typography_css(), '' ); ?>
	</style>

<?php
}
add_action( 'wp_head', 'newspack_style_4_typography_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function newspack_style_4_scripts() {
	// Dequeue parent styles
	wp_dequeue_style( 'newspack-style' );

	// Enqueue Google fonts.
	wp_enqueue_style( 'newspack-style-4-fonts', newspack_style_4_fonts_url(), array(), null );

	// Enqueue child styles
	wp_enqueue_style('newspack-style-4-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ));

	// Enqueue child RTL styles
	wp_style_add_data( 'newspack-style-4-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'newspack_style_4_scripts', 99 );

/**
 * Enqueue supplemental block editor styles.
 */
function newspack_style_4_editor_customizer_styles() {
	// Check for color or font customizations.
	$theme_customizations = '';
	if ( 'custom' === get_theme_mod( 'theme_colors' ) ) {
		// Include color patterns.
		require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
		$theme_customizations .= newspack_style_4_custom_colors_css();
	}

	if ( get_theme_mod( 'font_body', '' ) || get_theme_mod( 'font_header', '' ) || get_theme_mod( 'accent_allcaps', true ) ) {
		$theme_customizations .= newspack_style_4_custom_typography_css();
	}

	// If there are any, add those styles inline.
	if ( $theme_customizations ) {
		wp_add_inline_style( 'newspack-editor-customizer-styles', $theme_customizations );
	}
}
add_action( 'enqueue_block_editor_assets', 'newspack_style_4_editor_customizer_styles', 99 );


/**
 * Custom colors styles for child theme.
 */
require get_stylesheet_directory() . '/inc/child-color-patterns.php';

/**
 * Custom typography styles for child theme.
 */
require get_stylesheet_directory() . '/inc/child-typography.php';
