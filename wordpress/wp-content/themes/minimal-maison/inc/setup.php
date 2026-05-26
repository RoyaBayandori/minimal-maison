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

	return $classes;
}
add_filter( 'body_class', 'minimal_maison_body_classes' );
