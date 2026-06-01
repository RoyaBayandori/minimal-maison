<?php
/**
 * Custom post type — Testimonials.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Testimonials post type.
 */
function mm_register_testimonial_post_type(): void {
	$labels = array(
		'name'               => __( 'Testimonials', 'minimal-maison' ),
		'singular_name'      => __( 'Testimonial', 'minimal-maison' ),
		'menu_name'          => __( 'Testimonials', 'minimal-maison' ),
		'add_new'            => __( 'افزودن نظر', 'minimal-maison' ),
		'add_new_item'       => __( 'افزودن نظر جدید', 'minimal-maison' ),
		'edit_item'          => __( 'ویرایش نظر', 'minimal-maison' ),
		'new_item'           => __( 'نظر جدید', 'minimal-maison' ),
		'view_item'          => __( 'مشاهده نظر', 'minimal-maison' ),
		'search_items'       => __( 'جستجوی نظر', 'minimal-maison' ),
		'not_found'          => __( 'نظری یافت نشد.', 'minimal-maison' ),
		'not_found_in_trash' => __( 'نظری در زباله‌دان نیست.', 'minimal-maison' ),
	);

	register_post_type(
		'mm_testimonial',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-format-quote',
			'menu_position'       => 28,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'supports'            => array( 'title', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'mm_register_testimonial_post_type' );
