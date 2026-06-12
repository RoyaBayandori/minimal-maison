<?php
/**
 * Portfolio gallery — AJAX batch loading.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register gallery AJAX handlers.
 */
function mm_portfolio_gallery_register_ajax(): void {
	add_action( 'wp_ajax_mm_portfolio_gallery_batch', 'mm_portfolio_gallery_ajax_batch' );
	add_action( 'wp_ajax_nopriv_mm_portfolio_gallery_batch', 'mm_portfolio_gallery_ajax_batch' );
}
add_action( 'init', 'mm_portfolio_gallery_register_ajax' );

/**
 * AJAX: return the next batch of gallery piece markup.
 */
function mm_portfolio_gallery_ajax_batch(): void {
	check_ajax_referer( 'mm_portfolio_gallery', 'nonce' );

	$offset   = isset( $_POST['offset'] ) ? max( 0, (int) $_POST['offset'] ) : 0;
	$limit    = mm_portfolio_gallery_page_size();
	$category = isset( $_POST['category'] ) ? sanitize_title( wp_unslash( (string) $_POST['category'] ) ) : 'all';

	if ( '' === $category ) {
		$category = 'all';
	}

	$total = mm_portfolio_gallery_items_count( $category );
	$items = mm_portfolio_gallery_items_batch( $offset, $limit, $category );

	wp_send_json_success(
		array(
			'html'     => mm_portfolio_render_gallery_pieces_html( $items, $offset ),
			'offset'   => $offset + count( $items ),
			'total'    => $total,
			'has_more' => ( $offset + count( $items ) ) < $total,
		)
	);
}
