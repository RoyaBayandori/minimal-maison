<?php
/**
 * Homepage image registry and rendering helpers.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registered homepage images (local theme assets).
 *
 * @return array<string, array{file: string, width: int, height: int, alt: string}>
 */
function mm_home_images(): array {
	static $images = null;

	if ( null !== $images ) {
		return $images;
	}

	$images = array(
		'hero' => array(
			'file'   => 'hero.jpg',
			'width'  => 1600,
			'height' => 900,
			'alt'    => __( 'گردنبندهای طلای دست‌ساز با جزئیات ظریف', 'minimal-maison' ),
		),
		'atelier' => array(
			'file'   => 'atelier.jpg',
			'width'  => 1400,
			'height' => 1050,
			'alt'    => __( 'جواهرساز در حال بررسی انگشتر طلا با ذره‌بین', 'minimal-maison' ),
		),
		'about' => array(
			'file'   => 'about.jpg',
			'width'  => 1200,
			'height' => 1500,
			'alt'    => __( 'جواهرات طلای سفارشی با جزئیات دست‌ساز', 'minimal-maison' ),
		),
		'creation-ring' => array(
			'file'   => 'creation-ring.jpg',
			'width'  => 800,
			'height' => 1000,
			'alt'    => __( 'انگشتر نامزدی با الماس قطره‌ای — مدل لینا', 'minimal-maison' ),
		),
		'creation-necklace' => array(
			'file'   => 'creation-necklace.jpg',
			'width'  => 800,
			'height' => 1000,
			'alt'    => __( 'گردنبند مروارید با قلاب گل الماس — مدل آرک', 'minimal-maison' ),
		),
		'creation-bracelet' => array(
			'file'   => 'creation-bracelet.jpg',
			'width'  => 800,
			'height' => 1000,
			'alt'    => __( 'دستبند الماس با پرداخت درخشان — مدل باران', 'minimal-maison' ),
		),
		'creation-earring' => array(
			'file'   => 'creation-earring.jpg',
			'width'  => 800,
			'height' => 1000,
			'alt'    => __( 'گوشواره حلقه‌ای طلای زرد — مدل دون', 'minimal-maison' ),
		),
	);

	return apply_filters( 'mm_home_images', $images );
}

/**
 * Absolute filesystem path to a homepage image.
 *
 * @param string $key Image registry key.
 * @return string|null
 */
function mm_home_image_path( string $key ): ?string {
	$images = mm_home_images();

	if ( ! isset( $images[ $key ] ) ) {
		return null;
	}

	$path = MM_THEME_DIR . '/assets/images/home/' . $images[ $key ]['file'];

	return is_readable( $path ) ? $path : null;
}

/**
 * Public URL for a homepage image.
 *
 * @param string $key Image registry key.
 * @return string|null
 */
function mm_home_image_url( string $key ): ?string {
	if ( null === mm_home_image_path( $key ) ) {
		return null;
	}

	$images = mm_home_images();

	return MM_THEME_URI . '/assets/images/home/' . $images[ $key ]['file'];
}

/**
 * Image metadata for a homepage asset.
 *
 * @param string $key Image registry key.
 * @return array{file: string, width: int, height: int, alt: string, url: string}|null
 */
function mm_home_image( string $key ): ?array {
	$images = mm_home_images();
	$url    = mm_home_image_url( $key );

	if ( ! isset( $images[ $key ] ) || null === $url ) {
		return null;
	}

	return array_merge( $images[ $key ], array( 'url' => $url ) );
}

/**
 * Render a homepage <img> with sensible defaults.
 *
 * @param string               $key   Image registry key.
 * @param array<string, mixed> $attrs Extra HTML attributes.
 * @return string HTML or empty string if image missing.
 */
function mm_home_image_tag( string $key, array $attrs = array() ): string {
	$image = mm_home_image( $key );

	if ( null === $image ) {
		return '';
	}

	$defaults = array(
		'src'      => $image['url'],
		'alt'      => $image['alt'],
		'width'    => $image['width'],
		'height'   => $image['height'],
		'loading'  => 'lazy',
		'decoding' => 'async',
		'class'    => 'h-full w-full object-cover object-center',
	);

	$attributes = array_merge( $defaults, $attrs );

	$html = '<img';

	foreach ( $attributes as $name => $value ) {
		if ( null === $value || false === $value ) {
			continue;
		}

		if ( true === $value ) {
			$html .= ' ' . esc_attr( (string) $name );
			continue;
		}

		$html .= sprintf( ' %s="%s"', esc_attr( (string) $name ), esc_attr( (string) $value ) );
	}

	$html .= '>';

	return $html;
}

/**
 * Preload the homepage hero image for faster LCP.
 */
function mm_home_image_preload_hero(): void {
	if ( ! is_front_page() ) {
		return;
	}

	$url = mm_home_hero_preload_url();

	if ( null === $url ) {
		return;
	}

	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
		esc_url( $url )
	);
}
add_action( 'wp_head', 'mm_home_image_preload_hero', 1 );
