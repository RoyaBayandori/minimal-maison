<?php
/**
 * Jewelry request custom post type.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the jewelry request post type.
 */
function mm_jewelry_request_register_post_type(): void {
	$labels = array(
		'name'               => __( 'درخواست‌های سفارش', 'minimal-maison' ),
		'singular_name'      => __( 'درخواست سفارش', 'minimal-maison' ),
		'menu_name'          => __( 'درخواست‌های سفارش', 'minimal-maison' ),
		'all_items'          => __( 'همه درخواست‌ها', 'minimal-maison' ),
		'view_item'          => __( 'مشاهده درخواست', 'minimal-maison' ),
		'search_items'       => __( 'جستجوی درخواست', 'minimal-maison' ),
		'not_found'          => __( 'درخواستی یافت نشد.', 'minimal-maison' ),
		'not_found_in_trash' => __( 'درخواستی در زباله‌دان نیست.', 'minimal-maison' ),
	);

	register_post_type(
		'mm_jewelry_request',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-art',
			'menu_position'       => 26,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'supports'            => array( 'title' ),
		)
	);
}
add_action( 'init', 'mm_jewelry_request_register_post_type' );
