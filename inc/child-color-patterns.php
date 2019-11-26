<?php
/**
 * Add child theme-specific custom colours.
 */
function newspack_style_4_custom_colors_css() {
	$primary_color = newspack_get_primary_color();
	$secondary_color = newspack_get_secondary_color();

	if ( 'default' !== get_theme_mod( 'theme_colors', 'default' ) ) {
		$primary_color = get_theme_mod( 'primary_color_hex', $primary_color );
		$secondary_color = get_theme_mod( 'secondary_color_hex', $secondary_color );
	}

	$primary_color_contrast   = newspack_get_color_contrast( $primary_color );
	$secondary_color_contrast = newspack_get_color_contrast( $secondary_color );

	$style_4_theme_css = '
		.archive .page-title,
		.entry-meta .byline a, .entry-meta .byline a:visited,
		.entry .entry-content .entry-meta .byline a, .entry .entry-content .entry-meta .byline a:visited,
		.entry .entry-meta a:hover,
		.accent-header,
		.article-section-title,
		.cat-links,
		.entry .entry-footer,
		.site-footer .widget .widget-title  {
			color: ' . newspack_color_with_contrast( $primary_color ) . ';
		}

		.has-drop-cap:not(:focus)::first-letter {
			background-color: ' . $primary_color . ';
			color: ' . $primary_color_contrast . ';
		}

		.header-solid-background.header-simplified .site-header .nav1 .main-menu .sub-menu a:hover,
		.header-solid-background.header-simplified .site-header .nav1 .main-menu .sub-menu a:focus {
			background-color: ' . newspack_adjust_brightness( $primary_color, -30 ) . ';
		}
	';

	$style_4_editor_css = '
		.editor-block-list__layout .editor-block-list__block .entry-meta .byline a,
		.editor-block-list__layout .editor-block-list__block .accent-header,
		.editor-block-list__layout .editor-block-list__block .wp-block-newspack-blocks-homepage-articles:not(.has-text-color) .article-section-title {
			color: ' . newspack_color_with_contrast( $primary_color ) . ';
		}

		.editor-block-list__layout .editor-block-list__block .wp-block-paragraph.has-drop-cap:not(:focus)::first-letter {
			background-color: ' . $primary_color . ';
			color: ' . $primary_color_contrast . ';
		}
	';

	if ( function_exists( 'register_block_type' ) && is_admin() ) {
		$style_4_theme_css = $style_4_editor_css;
	}

	/**
	 * Filters Newspack Theme custom colors CSS.
	 *
	 * @since Newspack Theme 1.0
	 *
	 * @param string $style_4_theme_css   Base theme colors CSS.
	 * @param int    $primary_color       The user's selected color hex.
	 */
	return apply_filters( 'newspack_style_4_custom_colors_css', $style_4_theme_css, $primary_color );
}
