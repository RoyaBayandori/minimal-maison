<?php
/**
 * Portfolio / Gallery page content helpers.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/portfolio-defaults.php';

/**
 * Whether the current request uses the Portfolio page template.
 *
 * @return bool
 */
function mm_is_portfolio_page(): bool {
	return is_page_template( 'page-portfolio.php' );
}

/**
 * Whether the current request uses the Portfolio archive template.
 *
 * @return bool
 */
function mm_is_portfolio_archive_page(): bool {
	return is_page_template( 'page-portfolio-archive.php' );
}

/**
 * Post ID for the main Portfolio page (hero, gallery labels, etc.).
 *
 * @return int
 */
function mm_portfolio_page_id(): int {
	static $post_id = null;

	if ( null !== $post_id ) {
		return $post_id;
	}

	if ( mm_is_portfolio_page() ) {
		$post_id = (int) get_queried_object_id();
		return $post_id;
	}

	$post_id = (int) get_the_ID();

	if ( $post_id > 0 && 'page-portfolio.php' === get_page_template_slug( $post_id ) ) {
		return $post_id;
	}

	$post_id = 0;

	return $post_id;
}

/**
 * Post ID used to read Portfolio ACF settings (main page on archive views).
 *
 * @return int
 */
function mm_portfolio_settings_page_id(): int {
	if ( mm_is_portfolio_page() ) {
		return mm_portfolio_page_id();
	}

	if ( mm_is_portfolio_archive_page() ) {
		return mm_get_or_create_portfolio_page_id();
	}

	return mm_portfolio_page_id();
}

/**
 * Read a Portfolio ACF field without PHP defaults.
 *
 * @param string $field_name Field name.
 * @return mixed
 */
function mm_pf_acf_value( string $field_name ) {
	if ( ! mm_acf_available() ) {
		return '';
	}

	$post_id = mm_portfolio_settings_page_id();

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
 * Scalar Portfolio field with PHP default fallback.
 *
 * @param string $field_name Field name.
 * @return string
 */
function mm_pf_option( string $field_name ): string {
	$defaults = mm_portfolio_default_strings();
	$default  = $defaults[ $field_name ] ?? '';

	if ( ! mm_acf_available() ) {
		return $default;
	}

	$post_id = mm_portfolio_settings_page_id();

	if ( ! $post_id ) {
		return $default;
	}

	$value = get_field( $field_name, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return is_string( $value ) ? $value : (string) $value;
}

/**
 * Echo escaped Portfolio text.
 *
 * @param string $field_name Field name.
 */
function mm_pf_text( string $field_name ): void {
	echo esc_html( mm_pf_option( $field_name ) );
}

/**
 * Portfolio URL field with internal path support.
 *
 * @param string $field_name Field name.
 * @return string
 */
function mm_pf_url( string $field_name ): string {
	$url = trim( mm_pf_option( $field_name ) );

	if ( '' === $url ) {
		return '#';
	}

	if ( str_starts_with( $url, '#' ) || str_contains( $url, '://' ) ) {
		return $url;
	}

	return home_url( $url );
}

/**
 * Split a textarea field into non-empty lines.
 *
 * @param string $field_name Field name.
 * @return string[]
 */
function mm_pf_textarea_lines( string $field_name ): array {
	$text = trim( mm_pf_option( $field_name ) );

	if ( '' === $text ) {
		return array();
	}

	return array_values(
		array_filter(
			array_map(
				'trim',
				preg_split( '/\r\n|\r|\n/', $text )
			)
		)
	);
}

/**
 * About section body paragraphs.
 *
 * @return string[]
 */
function mm_pf_about_paragraphs(): array {
	$body = trim( mm_pf_option( 'pf_about_body' ) );

	if ( '' === $body ) {
		return array();
	}

	return array_values(
		array_filter(
			array_map(
				'trim',
				preg_split( '/\r\n|\r|\n/', $body )
			)
		)
	);
}

/**
 * Portfolio image attachment ID.
 *
 * @param string $field_name Field name.
 * @return int
 */
function mm_pf_image_id( string $field_name ): int {
	if ( ! mm_acf_available() ) {
		return 0;
	}

	$post_id = mm_portfolio_settings_page_id();

	if ( ! $post_id ) {
		return 0;
	}

	$value = get_field( $field_name, $post_id );

	return mm_acf_image_to_id( $value );
}

/**
 * Render Portfolio hero image markup.
 *
 * @param string $field_name Image field name.
 * @param string $class      Image class.
 * @return string
 */
function mm_pf_render_image( string $field_name, string $class = 'mm-portfolio-hero__image' ): string {
	$image_id = mm_pf_image_id( $field_name );

	if ( $image_id <= 0 ) {
		return '';
	}

	return wp_get_attachment_image(
		$image_id,
		'large',
		false,
		array(
			'class'   => $class,
			'loading' => 'eager',
			'sizes'   => '(min-width: 1024px) 50vw, 100vw',
		)
	);
}

/**
 * Number of creations shown per gallery batch.
 */
function mm_portfolio_gallery_page_size(): int {
	return 8;
}

/**
 * Label for the gallery load-more control.
 */
function mm_pf_gallery_load_more_label(): string {
	$label = trim( mm_pf_option( 'pf_gallery_load_more_label' ) );

	if ( '' !== $label ) {
		return $label;
	}

	return __( 'مشاهده آثار بیشتر', 'minimal-maison' );
}

/**
 * Base query args for gallery creations.
 *
 * @param string $category Category slug or `all`.
 * @return array<string, mixed>
 */
function mm_portfolio_gallery_query_args( string $category = 'all' ): array {
	$args = array(
		'post_type'      => 'mm_creation',
		'post_status'    => 'publish',
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => false,
	);

	if ( 'all' !== $category && '' !== $category ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => MM_CREATION_CATEGORY_TAXONOMY,
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	return $args;
}

/**
 * Count published gallery items for a category filter.
 */
function mm_portfolio_gallery_items_count( string $category = 'all' ): int {
	$query = new WP_Query(
		array_merge(
			mm_portfolio_gallery_query_args( $category ),
			array(
				'posts_per_page'      => 1,
				'fields'              => 'ids',
				'ignore_sticky_posts' => true,
			)
		)
	);

	return (int) $query->found_posts;
}

/**
 * Map a creation post to gallery item data.
 *
 * @param WP_Post $post Creation post.
 * @return array<string, mixed>|null
 */
function mm_portfolio_map_creation_item( WP_Post $post ): ?array {
	$image_id = (int) get_post_thumbnail_id( $post );

	if ( $image_id <= 0 ) {
		return null;
	}

	$terms = get_the_terms( $post, MM_CREATION_CATEGORY_TAXONOMY );
	$slugs = array();
	$names = array();

	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( ! $term instanceof WP_Term ) {
				continue;
			}

			$slugs[] = $term->slug;
			$names[] = $term->name;
		}
	}

	$full     = wp_get_attachment_image_src( $image_id, 'mm-portfolio-gallery' );
	$full_url = is_array( $full ) && ! empty( $full[0] ) ? (string) $full[0] : (string) wp_get_attachment_url( $image_id );

	return array(
		'id'             => (int) $post->ID,
		'title'          => get_the_title( $post ),
		'image_id'       => $image_id,
		'full_url'       => $full_url,
		'year'           => mm_jalali_year_from_post( $post ),
		'category_slugs' => $slugs,
		'category_names' => $names,
	);
}

/**
 * Gallery items from mm_creation CPT.
 *
 * @return array<int, array{
 *     id: int,
 *     title: string,
 *     image_id: int,
 *     full_url: string,
 *     year: string,
 *     category_slugs: string[],
 *     category_names: string[]
 * }>
 */
function mm_portfolio_gallery_items(): array {
	$posts = get_posts(
		array_merge(
			mm_portfolio_gallery_query_args( 'all' ),
			array(
				'posts_per_page' => -1,
			)
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	$items = array();

	foreach ( $posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}

		$item = mm_portfolio_map_creation_item( $post );

		if ( null !== $item ) {
			$items[] = $item;
		}
	}

	return $items;
}

/**
 * Fetch a paginated batch of gallery items.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_portfolio_gallery_items_batch( int $offset, int $limit, string $category = 'all' ): array {
	$posts = get_posts(
		array_merge(
			mm_portfolio_gallery_query_args( $category ),
			array(
				'posts_per_page' => max( 1, $limit ),
				'offset'         => max( 0, $offset ),
			)
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	$items = array();

	foreach ( $posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}

		$item = mm_portfolio_map_creation_item( $post );

		if ( null !== $item ) {
			$items[] = $item;
		}
	}

	return $items;
}

/**
 * Lightweight manifest for lightbox navigation across the full collection.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_portfolio_gallery_manifest(): array {
	$items    = mm_portfolio_gallery_items();
	$manifest = array();

	foreach ( $items as $item ) {
		$manifest[] = array(
			'id'       => (int) $item['id'],
			'title'    => (string) $item['title'],
			'category' => ! empty( $item['category_names'] ) ? (string) $item['category_names'][0] : '',
			'year'     => (string) $item['year'],
			'full'     => (string) $item['full_url'],
			'cats'     => array_values( (array) ( $item['category_slugs'] ?? array() ) ),
		);
	}

	return $manifest;
}

/**
 * Render gallery piece markup for one or more items.
 */
function mm_portfolio_render_gallery_pieces_html( array $items, int $start_index = 0 ): string {
	if ( empty( $items ) ) {
		return '';
	}

	ob_start();

	foreach ( $items as $offset => $item ) {
		get_template_part(
			'template-parts/portfolio/gallery',
			'piece',
			array(
				'item'  => $item,
				'index' => $start_index + (int) $offset,
			)
		);
	}

	return (string) ob_get_clean();
}

/**
 * Whether the hero section should render.
 */
function mm_pf_should_show_hero(): bool {
	return '' !== trim( mm_pf_option( 'pf_hero_heading' ) )
		|| '' !== trim( mm_pf_option( 'pf_hero_description' ) );
}

/**
 * Whether the gallery section shell should render.
 *
 * The section always renders so an empty state is available before any items exist.
 */
function mm_pf_should_show_gallery(): bool {
	return true;
}

/**
 * Hover CTA label for gallery pieces.
 */
function mm_pf_gallery_view_label(): string {
	$label = trim( mm_pf_option( 'pf_gallery_view_label' ) );

	if ( '' !== $label ) {
		return $label;
	}

	return __( 'مشاهده تصویر', 'minimal-maison' );
}

/**
 * Gallery empty-state message from CMS or a minimal system fallback.
 */
function mm_pf_gallery_empty_message(): string {
	$message = trim( mm_pf_option( 'pf_gallery_empty_message' ) );

	if ( '' !== $message ) {
		return $message;
	}

	return __( 'هنوز نمونه کاری در گالری منتشر نشده است.', 'minimal-maison' );
}

/**
 * Whether the about section should render.
 */
function mm_pf_should_show_about(): bool {
	$heading = trim( mm_pf_option( 'pf_about_heading' ) );

	return '' !== $heading && ! empty( mm_pf_about_paragraphs() );
}

/**
 * Whether the final CTA section should render.
 */
function mm_pf_should_show_final_cta(): bool {
	$heading = trim( mm_pf_option( 'pf_final_cta_heading' ) );
	$label   = trim( mm_pf_option( 'pf_final_cta_button_label' ) );
	$url     = trim( mm_pf_url( 'pf_final_cta_button_url' ) );

	return '' !== $heading && '' !== $label && '#' !== $url && '' !== $url;
}
