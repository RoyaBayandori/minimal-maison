<?php
/**
 * Header navigation helpers.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

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

		$is_current = in_array( 'current-menu-item', (array) $item->classes, true );

		printf(
			'<li class="site-nav__item%s"><a href="%s"%s>%s</a></li>',
			$is_current ? ' site-nav__item--current' : '',
			esc_url( $item->url ),
			$is_current ? ' aria-current="page"' : '',
			esc_html( $item->title )
		);
	}

	echo '</ul></nav>';
}
