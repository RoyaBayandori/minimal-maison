<?php
/**
 * WooCommerce theme integration.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce support.
 */
function minimal_maison_woocommerce_setup(): void {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'minimal_maison_woocommerce_setup' );

/**
 * Use theme templates; dequeue default WooCommerce styles (Tailwind handles UI).
 *
 * @param array<string, string> $styles Registered styles.
 * @return array<string, string>
 */
function minimal_maison_woocommerce_dequeue_styles( array $styles ): array {
	return array();
}
add_filter( 'woocommerce_enqueue_styles', 'minimal_maison_woocommerce_dequeue_styles' );

/**
 * Products per row on shop archive.
 *
 * @return int
 */
function minimal_maison_loop_columns(): int {
	return 3;
}
add_filter( 'loop_shop_columns', 'minimal_maison_loop_columns' );
