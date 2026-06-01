<?php
/**
 * Custom post type — Creations (portfolio).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Creations post type.
 */
function mm_register_creation_post_type(): void {
	$labels = array(
		'name'               => __( 'Creations', 'minimal-maison' ),
		'singular_name'      => __( 'Creation', 'minimal-maison' ),
		'menu_name'          => __( 'Creations', 'minimal-maison' ),
		'add_new'            => __( 'افزودن نمونه کار', 'minimal-maison' ),
		'add_new_item'       => __( 'افزودن نمونه کار جدید', 'minimal-maison' ),
		'edit_item'          => __( 'ویرایش نمونه کار', 'minimal-maison' ),
		'new_item'           => __( 'نمونه کار جدید', 'minimal-maison' ),
		'view_item'          => __( 'مشاهده نمونه کار', 'minimal-maison' ),
		'search_items'       => __( 'جستجوی نمونه کار', 'minimal-maison' ),
		'not_found'          => __( 'نمونه کاری یافت نشد.', 'minimal-maison' ),
		'not_found_in_trash' => __( 'نمونه کاری در زباله‌دان نیست.', 'minimal-maison' ),
	);

	register_post_type(
		'mm_creation',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-art',
			'menu_position'       => 27,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'mm_register_creation_post_type' );
