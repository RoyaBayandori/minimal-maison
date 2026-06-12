<?php
/**
 * Ensure a Portfolio / Gallery page exists for the page template.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option flag: portfolio page bootstrap completed.
 */
const MM_PORTFOLIO_PAGE_SETUP_OPTION = 'mm_portfolio_page_configured';

/**
 * Slug for the portfolio page when auto-created.
 */
const MM_PORTFOLIO_PAGE_SLUG = 'gallery';

/**
 * Option flag: portfolio archive page bootstrap completed.
 */
const MM_PORTFOLIO_ARCHIVE_PAGE_SETUP_OPTION = 'mm_portfolio_archive_page_configured';

/**
 * Slug for the portfolio archive page when auto-created.
 */
const MM_PORTFOLIO_ARCHIVE_PAGE_SLUG = 'gallery-archive';

/**
 * Create or resolve the Portfolio page on theme boot.
 */
function mm_ensure_portfolio_page(): void {
	if ( get_option( MM_PORTFOLIO_PAGE_SETUP_OPTION ) ) {
		return;
	}

	if ( wp_installing() ) {
		return;
	}

	$page_id = mm_get_or_create_portfolio_page_id();

	if ( ! $page_id ) {
		return;
	}

	update_post_meta( $page_id, '_wp_page_template', 'page-portfolio.php' );
	update_option( MM_PORTFOLIO_PAGE_SETUP_OPTION, '1' );
}
add_action( 'init', 'mm_ensure_portfolio_page', 6 );

/**
 * Create or resolve the Portfolio archive page on theme boot.
 */
function mm_ensure_portfolio_archive_page(): void {
	if ( get_option( MM_PORTFOLIO_ARCHIVE_PAGE_SETUP_OPTION ) ) {
		return;
	}

	if ( wp_installing() ) {
		return;
	}

	$page_id = mm_get_or_create_portfolio_archive_page_id();

	if ( ! $page_id ) {
		return;
	}

	update_post_meta( $page_id, '_wp_page_template', 'page-portfolio-archive.php' );
	update_option( MM_PORTFOLIO_ARCHIVE_PAGE_SETUP_OPTION, '1' );
}
add_action( 'init', 'mm_ensure_portfolio_archive_page', 6 );

/**
 * Re-run portfolio page bootstrap when the theme is activated.
 */
function mm_portfolio_page_setup_on_theme_switch(): void {
	delete_option( MM_PORTFOLIO_PAGE_SETUP_OPTION );
	delete_option( MM_PORTFOLIO_ARCHIVE_PAGE_SETUP_OPTION );
	mm_ensure_portfolio_page();
	mm_ensure_portfolio_archive_page();
}
add_action( 'after_switch_theme', 'mm_portfolio_page_setup_on_theme_switch' );

/**
 * Resolve or create the Portfolio page.
 *
 * @return int Page ID, or 0 on failure.
 */
function mm_get_or_create_portfolio_page_id(): int {
	$page = get_page_by_path( MM_PORTFOLIO_PAGE_SLUG );

	if ( $page instanceof WP_Post ) {
		return (int) $page->ID;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-portfolio.php',
			'fields'         => 'ids',
		)
	);

	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => __( 'گالری', 'minimal-maison' ),
			'post_name'    => MM_PORTFOLIO_PAGE_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}

	return (int) $page_id;
}

/**
 * Permalink for the Portfolio page.
 *
 * @return string
 */
function mm_portfolio_page_url(): string {
	$page_id = mm_get_or_create_portfolio_page_id();

	if ( $page_id <= 0 ) {
		return home_url( '/' . MM_PORTFOLIO_PAGE_SLUG . '/' );
	}

	return (string) get_permalink( $page_id );
}

/**
 * Resolve or create the Portfolio archive page.
 *
 * @return int Page ID, or 0 on failure.
 */
function mm_get_or_create_portfolio_archive_page_id(): int {
	$page = get_page_by_path( MM_PORTFOLIO_ARCHIVE_PAGE_SLUG );

	if ( $page instanceof WP_Post ) {
		return (int) $page->ID;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-portfolio-archive.php',
			'fields'         => 'ids',
		)
	);

	if ( ! empty( $existing ) ) {
		return (int) $existing[0];
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => __( 'آرشیو آثار', 'minimal-maison' ),
			'post_name'    => MM_PORTFOLIO_ARCHIVE_PAGE_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $page_id ) || ! $page_id ) {
		return 0;
	}

	return (int) $page_id;
}

/**
 * Permalink for the Portfolio archive page.
 *
 * @return string
 */
function mm_portfolio_archive_page_url(): string {
	$page_id = mm_get_or_create_portfolio_archive_page_id();

	if ( $page_id <= 0 ) {
		return home_url( '/' . MM_PORTFOLIO_ARCHIVE_PAGE_SLUG . '/' );
	}

	return (string) get_permalink( $page_id );
}
