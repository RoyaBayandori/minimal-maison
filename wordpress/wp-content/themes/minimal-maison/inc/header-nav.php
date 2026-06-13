<?php
/**
 * Header navigation helpers.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer contact section element id.
 */
const MM_FOOTER_CONTACT_ID = 'footer-contact';

/**
 * URL for the header «تماس با ما» item.
 */
function mm_footer_contact_nav_url(): string {
	if ( is_front_page() ) {
		return '#' . MM_FOOTER_CONTACT_ID;
	}

	return home_url( '/#' . MM_FOOTER_CONTACT_ID );
}

/**
 * Whether a nav menu item should scroll to the footer contact block.
 *
 * @param WP_Post $item Menu item.
 */
function mm_is_footer_contact_nav_item( WP_Post $item ): bool {
	$title = trim( html_entity_decode( (string) $item->title, ENT_QUOTES, 'UTF-8' ) );

	if ( in_array( $title, array( 'تماس با ما', 'تماس', 'Contact', 'Contact Us' ), true ) ) {
		return true;
	}

	if ( 'page' === $item->object && mm_is_legacy_contact_page_id( (int) $item->object_id ) ) {
		return true;
	}

	$url  = (string) $item->url;
	$path = wp_parse_url( $url, PHP_URL_PATH );

	if ( is_string( $path ) && '' !== $path ) {
		$slug = trim( rawurldecode( basename( untrailingslashit( $path ) ) ) );

		if ( in_array( $slug, array( 'contact', 'contact-us', 'تماس', 'تماس-با-ما' ), true ) ) {
			return true;
		}
	}

	return str_contains( $url, '#' . MM_FOOTER_CONTACT_ID );
}

/**
 * Whether a page is a legacy standalone Contact page.
 *
 * @param int $post_id Page ID.
 */
function mm_is_legacy_contact_page_id( int $post_id ): bool {
	if ( $post_id <= 0 ) {
		return false;
	}

	$post = get_post( $post_id );

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}

	return mm_is_legacy_contact_page( $post );
}

/**
 * Whether a page post is a legacy standalone Contact page.
 */
function mm_is_legacy_contact_page( WP_Post $post ): bool {
	$slug = (string) $post->post_name;

	if ( in_array( $slug, array( 'contact', 'contact-us', 'تماس', 'تماس-با-ما' ), true ) ) {
		return true;
	}

	$title = trim( html_entity_decode( get_the_title( $post ), ENT_QUOTES, 'UTF-8' ) );

	return in_array( $title, array( 'تماس با ما', 'Contact', 'Contact Us' ), true );
}

/**
 * Rewrite Contact menu links to the footer contact anchor.
 *
 * @param array<int, WP_Post>|false|null $items Menu items.
 * @return array<int, WP_Post>|false|null
 */
function mm_nav_menu_items_footer_contact_url( $items ) {
	if ( ! is_array( $items ) ) {
		return $items;
	}

	foreach ( $items as $item ) {
		if ( ! $item instanceof WP_Post || ! mm_is_footer_contact_nav_item( $item ) ) {
			continue;
		}

		$item->url     = mm_footer_contact_nav_url();
		$item->classes = array_values(
			array_diff(
				(array) $item->classes,
				array( 'current-menu-item', 'current_page_item', 'current-menu-ancestor' )
			)
		);
	}

	return $items;
}
add_filter( 'wp_get_nav_menu_items', 'mm_nav_menu_items_footer_contact_url' );

/**
 * Redirect legacy Contact pages to the homepage footer anchor.
 */
function mm_redirect_legacy_contact_pages(): void {
	if ( ! is_page() ) {
		return;
	}

	$post = get_queried_object();

	if ( ! $post instanceof WP_Post || ! mm_is_legacy_contact_page( $post ) ) {
		return;
	}

	wp_safe_redirect( home_url( '/#' . MM_FOOTER_CONTACT_ID ), 301 );
	exit;
}
add_action( 'template_redirect', 'mm_redirect_legacy_contact_pages' );

/**
 * Top-level items from the Primary Menu location.
 *
 * @return array<int, WP_Post>
 */
function mm_primary_nav_items(): array {
	if ( ! has_nav_menu( 'primary' ) ) {
		return array();
	}

	$locations = get_nav_menu_locations();

	if ( empty( $locations['primary'] ) ) {
		return array();
	}

	$items = wp_get_nav_menu_items( (int) $locations['primary'] );

	if ( ! is_array( $items ) ) {
		return array();
	}

	$top_level = array_filter(
		$items,
		static function ( $item ) {
			return isset( $item->menu_item_parent ) && '0' === (string) $item->menu_item_parent;
		}
	);

	return array_values( $top_level );
}

/**
 * Split primary nav items for symmetrical desktop header zones.
 *
 * First half → start (left in LTR maison layout). Second half → end.
 *
 * @param array<int, WP_Post> $items Menu items.
 * @return array{start: array<int, WP_Post>, end: array<int, WP_Post>}
 */
function mm_split_header_nav_items( array $items ): array {
	$count = count( $items );

	if ( 0 === $count ) {
		return array(
			'start' => array(),
			'end'   => array(),
		);
	}

	$mid = (int) ceil( $count / 2 );

	return array(
		'start' => array_slice( $items, 0, $mid ),
		'end'   => array_slice( $items, $mid ),
	);
}

/**
 * Render a flat header navigation list from menu item objects.
 *
 * @param array<int, WP_Post> $items       Menu items.
 * @param string              $list_class Class attribute for the <ul>.
 * @param string              $label       Accessible nav label.
 */
function mm_render_header_nav_list( array $items, string $list_class, string $label ): void {
	if ( empty( $items ) ) {
		return;
	}

	printf( '<nav class="site-nav" aria-label="%s">', esc_attr( $label ) );
	printf( '<ul class="%s">', esc_attr( $list_class ) );

	foreach ( $items as $item ) {
		if ( ! $item instanceof WP_Post ) {
			continue;
		}

		$is_footer_contact = mm_is_footer_contact_nav_item( $item );
		$is_current        = ! $is_footer_contact && in_array( 'current-menu-item', (array) $item->classes, true );

		printf(
			'<li class="site-nav__item%s%s"><a href="%s"%s%s>%s</a></li>',
			$is_current ? ' site-nav__item--current' : '',
			$is_footer_contact ? ' site-nav__item--footer-contact' : '',
			esc_url( $item->url ),
			$is_current ? ' aria-current="page"' : '',
			$is_footer_contact ? ' data-footer-contact-link' : '',
			esc_html( $item->title )
		);
	}

	echo '</ul></nav>';
}
