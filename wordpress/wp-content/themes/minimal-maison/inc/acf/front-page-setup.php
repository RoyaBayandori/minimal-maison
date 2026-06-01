<?php
/**
 * Ensure a static Front Page exists for homepage ACF fields.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option flag: front page bootstrap completed.
 */
const MM_FRONT_PAGE_SETUP_OPTION = 'mm_front_page_configured';

/**
 * Slug for the homepage page when auto-created.
 */
const MM_FRONT_PAGE_SLUG = 'home';

/**
 * Configure Reading settings with a Home page when not yet set up.
 */
function mm_ensure_front_page(): void {
	if ( get_option( MM_FRONT_PAGE_SETUP_OPTION ) ) {
		return;
	}

	if ( wp_installing() ) {
		return;
	}

	$page_id = mm_get_or_create_front_page_id();

	if ( ! $page_id ) {
		return;
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $page_id );
	update_option( MM_FRONT_PAGE_SETUP_OPTION, '1' );
}
add_action( 'init', 'mm_ensure_front_page', 5 );

/**
 * Re-run front page bootstrap when the theme is activated.
 */
function mm_front_page_setup_on_theme_switch(): void {
	delete_option( MM_FRONT_PAGE_SETUP_OPTION );
	mm_ensure_front_page();
}
add_action( 'after_switch_theme', 'mm_front_page_setup_on_theme_switch' );

/**
 * Resolve or create the page used as the WordPress Front Page.
 *
 * @return int Page ID, or 0 on failure.
 */
function mm_get_or_create_front_page_id(): int {
	$front_id = (int) get_option( 'page_on_front' );

	if ( $front_id > 0 && 'page' === get_option( 'show_on_front' ) ) {
		return $front_id;
	}

	$page = get_page_by_path( MM_FRONT_PAGE_SLUG );

	if ( $page instanceof WP_Post ) {
		return (int) $page->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => __( 'Home', 'minimal-maison' ),
			'post_name'    => MM_FRONT_PAGE_SLUG,
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
 * Post ID for homepage ACF fields (the static Front Page).
 *
 * @return int
 */
function mm_homepage_post_id(): int {
	static $post_id = null;

	if ( null !== $post_id ) {
		return $post_id;
	}

	$post_id = (int) get_option( 'page_on_front' );

	return $post_id;
}
