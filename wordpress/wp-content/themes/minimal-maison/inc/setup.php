<?php
/**
 * Theme setup: supports, menus, image sizes.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme features.
 */
function minimal_maison_setup(): void {
	load_theme_textdomain( 'minimal-maison', MM_THEME_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 56,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'minimal-maison' ),
			'footer'  => __( 'Footer Menu', 'minimal-maison' ),
		)
	);

	add_image_size( 'mm-product-card', 600, 750, true );
}
add_action( 'after_setup_theme', 'minimal_maison_setup' );

/**
 * Body classes for layout hooks.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function minimal_maison_body_classes( array $classes ): array {
	if ( is_rtl() ) {
		$classes[] = 'mm-rtl';
	}

	if ( is_page_template( 'page-custom-order.php' ) ) {
		$classes[] = 'mm-custom-order-page';
	}

	return $classes;
}
add_filter( 'body_class', 'minimal_maison_body_classes' );

/**
 * Allow SVG uploads for custom logo assets.
 *
 * @param array<string, string> $mimes Allowed mime types.
 * @return array<string, string>
 */
function minimal_maison_upload_mimes( array $mimes ): array {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';

	return $mimes;
}
add_filter( 'upload_mimes', 'minimal_maison_upload_mimes' );

/**
 * Append theme logo class to WordPress custom logo markup.
 *
 * @param string $html Custom logo HTML.
 * @return string
 */
function minimal_maison_custom_logo_markup( string $html ): string {
	if ( '' === $html ) {
		return $html;
	}

	return (string) preg_replace(
		'/class="custom-logo-link"/',
		'class="custom-logo-link site-logo"',
		$html,
		1
	);
}
add_filter( 'get_custom_logo', 'minimal_maison_custom_logo_markup' );

/**
 * Output site logo — Custom Logo image or Persian text fallback.
 *
 * @param array<string, mixed> $args {
 *     @type bool $footer Apply footer layout classes.
 *     @type bool $header Apply header layout classes.
 * }
 */
function mm_the_site_logo( array $args = array() ): void {
	$args = wp_parse_args(
		$args,
		array(
			'footer' => false,
			'header' => false,
		)
	);

	$classes = array( 'site-logo' );

	if ( $args['footer'] ) {
		$classes[] = 'site-logo--footer';
	}

	if ( $args['header'] ) {
		$classes[] = 'site-logo--header';
	}

	$class_attr = esc_attr( implode( ' ', $classes ) );
	$home_url   = esc_url( home_url( '/' ) );
	$label      = esc_attr( get_bloginfo( 'name', 'display' ) );

	if ( has_custom_logo() ) {
		$logo_id = (int) get_theme_mod( 'custom_logo' );
		$logo    = wp_get_attachment_image(
			$logo_id,
			'full',
			false,
			array(
				'class'    => 'site-logo__image',
				'alt'      => $label,
				'decoding' => 'async',
			)
		);

		if ( '' !== $logo ) {
			printf(
				'<a href="%1$s" class="%2$s" rel="home" aria-label="%3$s">%4$s</a>',
				$home_url,
				$class_attr,
				$label,
				$logo // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by wp_get_attachment_image().
			);

			return;
		}
	}

	printf(
		'<a href="%1$s" class="%2$s" rel="home">%3$s</a>',
		$home_url,
		$class_attr,
		esc_html( 'مینیمال' )
	);
}
