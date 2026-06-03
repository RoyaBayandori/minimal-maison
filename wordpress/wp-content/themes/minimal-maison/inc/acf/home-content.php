<?php
/**
 * Homepage content helpers — ACF with graceful fallbacks.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/home-defaults.php';

/**
 * Whether ACF is available.
 */
function mm_acf_available(): bool {
	return function_exists( 'get_field' );
}

/**
 * Get a homepage field from the Front Page with fallback to defaults.
 *
 * @param string $field_name ACF field name.
 * @return mixed
 */
function mm_home_option( string $field_name ) {
	$defaults = mm_home_default_strings();
	$default  = $defaults[ $field_name ] ?? '';

	if ( ! mm_acf_available() ) {
		return $default;
	}

	$post_id = mm_homepage_post_id();

	if ( ! $post_id ) {
		return $default;
	}

	$value = get_field( $field_name, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Echo escaped homepage text option.
 *
 * @param string $field_name ACF field name.
 */
function mm_home_text( string $field_name ): void {
	echo esc_html( (string) mm_home_option( $field_name ) );
}

/**
 * Homepage URL option with internal path support.
 *
 * @param string $field_name ACF field name.
 * @return string
 */
function mm_home_url( string $field_name ): string {
	$url = (string) mm_home_option( $field_name );

	if ( '' === $url ) {
		return '#';
	}

	if ( str_starts_with( $url, '#' ) || str_contains( $url, '://' ) ) {
		return $url;
	}

	return home_url( $url );
}

/**
 * Read a homepage ACF field value only — no PHP theme defaults.
 *
 * @param string $field_name ACF field name.
 * @return mixed
 */
function mm_home_acf_value( string $field_name ) {
	if ( ! mm_acf_available() ) {
		return '';
	}

	$post_id = mm_homepage_post_id();

	if ( ! $post_id ) {
		return '';
	}

	$value = get_field( $field_name, $post_id );

	if ( null === $value || false === $value ) {
		return '';
	}

	return $value;
}

/**
 * Echo escaped homepage ACF text — no PHP theme defaults.
 *
 * @param string $field_name ACF field name.
 */
function mm_home_acf_text( string $field_name ): void {
	echo esc_html( trim( (string) mm_home_acf_value( $field_name ) ) );
}

/**
 * Homepage ACF URL — no PHP theme defaults; empty when unset.
 *
 * @param string $field_name ACF field name.
 * @return string
 */
function mm_home_acf_url( string $field_name ): string {
	$url = trim( (string) mm_home_acf_value( $field_name ) );

	if ( '' === $url ) {
		return '';
	}

	if ( str_starts_with( $url, '#' ) || str_contains( $url, '://' ) ) {
		return $url;
	}

	return home_url( $url );
}

/**
 * About section paragraphs from ACF repeater or defaults.
 *
 * @return string[]
 */
function mm_home_about_paragraphs(): array {
	if ( mm_acf_available() ) {
		$post_id = mm_homepage_post_id();

		if ( ! $post_id ) {
			return mm_home_default_about_paragraphs();
		}

		$rows = get_field( 'about_paragraphs', $post_id );

		if ( is_array( $rows ) && ! empty( $rows ) ) {
			$paragraphs = array();

			foreach ( $rows as $row ) {
				$text = isset( $row['paragraph'] ) ? trim( (string) $row['paragraph'] ) : '';

				if ( '' !== $text ) {
					$paragraphs[] = $text;
				}
			}

			if ( ! empty( $paragraphs ) ) {
				return $paragraphs;
			}
		}
	}

	return mm_home_default_about_paragraphs();
}

/**
 * Whether the Brand Philosophy section should render.
 */
function mm_should_show_philosophy(): bool {
	$heading = trim( (string) mm_home_acf_value( 'philosophy_heading' ) );
	$body    = trim( (string) mm_home_acf_value( 'philosophy_body' ) );

	return '' !== $heading || '' !== $body;
}

/**
 * Whether Brand Philosophy has a complete CTA.
 */
function mm_philosophy_has_cta(): bool {
	$label = trim( (string) mm_home_acf_value( 'philosophy_cta_label' ) );
	$url   = trim( (string) mm_home_acf_value( 'philosophy_cta_url' ) );

	return '' !== $label && '' !== $url;
}

/**
 * Brand philosophy body paragraphs from ACF textarea only.
 *
 * @return string[]
 */
function mm_home_philosophy_paragraphs(): array {
	$body = trim( (string) mm_home_acf_value( 'philosophy_body' ) );

	if ( '' === $body ) {
		return array();
	}

	$paragraphs = array_filter(
		array_map(
			'trim',
			preg_split( '/\r\n|\r|\n/', $body )
		)
	);

	return array_values( $paragraphs );
}

/**
 * Craft Process steps from homepage group fields (ACF Free).
 *
 * Display order is defined by the registry below — not by field name sorting.
 *
 * @return array<int, array{title: string, text: string}>
 */
function mm_home_craft_steps(): array {
	$field_names = array(
		'craft_step_consultation',
		'craft_step_design',
		'craft_step_approval',
		'craft_step_production',
		'craft_step_delivery',
	);

	$steps = array();

	foreach ( $field_names as $field_name ) {
		$group = mm_home_acf_value( $field_name );

		if ( ! is_array( $group ) ) {
			continue;
		}

		$title = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		$text  = isset( $group['text'] ) ? trim( (string) $group['text'] ) : '';

		if ( '' === $title && '' === $text ) {
			continue;
		}

		$steps[] = array(
			'title' => $title,
			'text'  => $text,
		);
	}

	return $steps;
}

/**
 * Featured creations from homepage relationship to mm_creation CPT.
 *
 * Reads `featured_creations` in relationship selection order.
 *
 * @return array<int, array{post_id: int, title: string, image_id: int}>
 */
function mm_home_featured_creations(): array {
	$selected = mm_home_acf_value( 'featured_creations' );

	if ( ! is_array( $selected ) || empty( $selected ) ) {
		return array();
	}

	$items = array();

	foreach ( $selected as $entry ) {
		$post = null;

		if ( $entry instanceof WP_Post ) {
			$post = $entry;
		} elseif ( is_numeric( $entry ) ) {
			$post = get_post( (int) $entry );
		}

		if ( ! $post instanceof WP_Post || 'mm_creation' !== $post->post_type || 'publish' !== $post->post_status ) {
			continue;
		}

		$image_id = (int) get_post_thumbnail_id( $post );

		if ( $image_id <= 0 ) {
			continue;
		}

		$items[] = array(
			'post_id'  => (int) $post->ID,
			'title'    => trim( get_the_title( $post ) ),
			'image_id' => $image_id,
		);
	}

	return $items;
}

/**
 * Process steps from ACF repeater or defaults.
 *
 * @return array<int, array{number: string, title: string, text: string}>
 */
function mm_home_process_steps(): array {
	if ( mm_acf_available() ) {
		$post_id = mm_homepage_post_id();

		if ( ! $post_id ) {
			return mm_home_default_process_steps();
		}

		$rows = get_field( 'process_steps', $post_id );

		if ( is_array( $rows ) && ! empty( $rows ) ) {
			$steps = array();

			foreach ( $rows as $row ) {
				$number = isset( $row['step_number'] ) ? trim( (string) $row['step_number'] ) : '';
				$title  = isset( $row['step_title'] ) ? trim( (string) $row['step_title'] ) : '';
				$text   = isset( $row['step_text'] ) ? trim( (string) $row['step_text'] ) : '';

				if ( '' === $title && '' === $text ) {
					continue;
				}

				$steps[] = array(
					'number' => $number,
					'title'  => $title,
					'text'   => $text,
				);
			}

			if ( ! empty( $steps ) ) {
				return $steps;
			}
		}
	}

	return mm_home_default_process_steps();
}

/**
 * Testimonials from CPT or defaults.
 *
 * @return array<int, array{quote: string, author: string}>
 */
function mm_home_testimonials(): array {
	$posts = get_posts(
		array(
			'post_type'      => 'mm_testimonial',
			'posts_per_page' => 3,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'post_status'    => 'publish',
		)
	);

	if ( ! empty( $posts ) ) {
		$stories = array();

		foreach ( $posts as $post ) {
			$quote  = mm_acf_available() ? (string) get_field( 'testimonial_quote', $post->ID ) : '';
			$author = mm_acf_available() ? (string) get_field( 'testimonial_attribution', $post->ID ) : '';

			if ( '' === $quote ) {
				$quote = get_the_excerpt( $post );
			}

			if ( '' === $author ) {
				$author = get_the_title( $post );
			}

			if ( '' === trim( $quote ) ) {
				continue;
			}

			$stories[] = array(
				'quote'  => $quote,
				'author' => $author,
			);
		}

		if ( ! empty( $stories ) ) {
			return $stories;
		}
	}

	return mm_home_default_testimonials();
}

/**
 * Creation portfolio items: CPT, then WooCommerce, then placeholders.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_home_creations(): array {
	$creation_posts = get_posts(
		array(
			'post_type'      => 'mm_creation',
			'posts_per_page' => 6,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'post_status'    => 'publish',
		)
	);

	if ( ! empty( $creation_posts ) ) {
		$items = array();

		foreach ( $creation_posts as $post ) {
			$description = mm_acf_available() ? (string) get_field( 'creation_subtitle', $post->ID ) : '';

			if ( '' === $description && mm_acf_available() ) {
				$description = (string) get_field( 'creation_price_label', $post->ID );
			}

			$items[] = array(
				'type'         => 'creation',
				'post'         => $post,
				'title'        => get_the_title( $post ),
				'description'  => $description,
				'image_id'     => get_post_thumbnail_id( $post ),
				'fallback_key' => '',
			);
		}

		return $items;
	}

	if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_products' ) ) {
		$featured = wc_get_products(
			array(
				'limit'    => 6,
				'status'   => 'publish',
				'featured' => true,
				'orderby'  => 'date',
				'order'    => 'DESC',
			)
		);

		$products = ! empty( $featured ) ? $featured : wc_get_products(
			array(
				'limit'   => 6,
				'status'  => 'publish',
				'orderby' => 'date',
				'order'   => 'DESC',
			)
		);

		if ( ! empty( $products ) ) {
			$items = array();

			foreach ( $products as $product ) {
				$items[] = array(
					'type'    => 'product',
					'product' => $product,
				);
			}

			return $items;
		}
	}

	$items = array();

	foreach ( mm_home_default_creation_placeholders() as $placeholder ) {
		$items[] = array(
			'type'        => 'placeholder',
			'placeholder' => $placeholder,
		);
	}

	return $items;
}

/**
 * Resolve an ACF image field ID from the Front Page.
 *
 * @param string $field_name ACF image field name.
 * @return int
 */
function mm_home_option_image_id( string $field_name ): int {
	if ( ! mm_acf_available() ) {
		return 0;
	}

	$post_id = mm_homepage_post_id();

	if ( ! $post_id ) {
		return 0;
	}

	$image = get_field( $field_name, $post_id );

	if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
		return (int) $image['ID'];
	}

	if ( is_numeric( $image ) ) {
		return (int) $image;
	}

	return 0;
}

/**
 * Render a homepage ACF image only — no theme asset fallback.
 *
 * @param string               $field_name      ACF image field name.
 * @param array<string, mixed> $attrs           Extra img attributes.
 * @param string               $attachment_size WordPress image size.
 * @param string               $sizes_attr      Responsive sizes attribute.
 * @return string
 */
function mm_render_home_option_image(
	string $field_name,
	array $attrs = array(),
	string $attachment_size = 'full',
	string $sizes_attr = ''
): string {
	$image_id = mm_home_option_image_id( $field_name );

	if ( ! $image_id ) {
		return '';
	}

	$default_class = $attrs['class'] ?? 'h-full w-full object-cover object-center';
	unset( $attrs['class'] );

	$wp_attrs = array(
		'class'    => $default_class,
		'loading'  => $attrs['loading'] ?? 'lazy',
		'decoding' => 'async',
	);

	if ( '' !== $sizes_attr ) {
		$wp_attrs['sizes'] = $sizes_attr;
	}

	$html = wp_get_attachment_image(
		$image_id,
		$attachment_size,
		false,
		array_merge( $wp_attrs, $attrs )
	);

	return $html ? $html : '';
}

/**
 * Render a homepage image from ACF or theme asset registry.
 *
 * @param string               $fallback_key     Theme image registry key.
 * @param string               $option_field     ACF image field name.
 * @param array<string, mixed> $attrs            Extra img attributes.
 * @param string               $attachment_size  WordPress image size (e.g. large, full).
 * @param string               $sizes_attr       Responsive sizes attribute (empty = WP default).
 * @return string
 */
function mm_render_home_image(
	string $fallback_key,
	string $option_field,
	array $attrs = array(),
	string $attachment_size = 'large',
	string $sizes_attr = ''
): string {
	$image_id = mm_home_option_image_id( $option_field );

	if ( $image_id ) {
		$default_class = $attrs['class'] ?? 'h-full w-full object-cover object-center';
		unset( $attrs['class'] );

		$wp_attrs = array(
			'class'    => $default_class,
			'loading'  => $attrs['loading'] ?? 'lazy',
			'decoding' => 'async',
		);

		if ( '' !== $sizes_attr ) {
			$wp_attrs['sizes'] = $sizes_attr;
		}

		$html = wp_get_attachment_image(
			$image_id,
			$attachment_size,
			false,
			array_merge( $wp_attrs, $attrs )
		);

		return $html ? $html : mm_home_image_tag( $fallback_key, $attrs );
	}

	return mm_home_image_tag( $fallback_key, $attrs );
}

/**
 * Hero image URL for preload — ACF override or theme asset.
 *
 * @return string|null
 */
function mm_home_hero_preload_url(): ?string {
	$image_id = mm_home_option_image_id( 'hero_image' );

	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, 'full' );

		return $url ? $url : null;
	}

	return mm_home_image_url( 'hero' );
}
