<?php
/**
 * Minimal Maison theme functions.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme setup — RTL Persian & WooCommerce support.
 */
function minimal_maison_setup(): void {
	load_theme_textdomain( 'minimal-maison', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// RTL: WordPress uses locale; theme should use logical properties in CSS.
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'minimal_maison_setup' );
