<?php
/**
 * Jewelry request taxonomies — admin-managed piece types and budget ranges.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register taxonomies for jewelry requests.
 */
function mm_jewelry_request_register_taxonomies(): void {
	register_taxonomy(
		MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY,
		'mm_jewelry_request',
		array(
			'labels'            => array(
				'name'          => __( 'انواع قطعه', 'minimal-maison' ),
				'singular_name' => __( 'نوع قطعه', 'minimal-maison' ),
				'menu_name'     => __( 'انواع قطعه', 'minimal-maison' ),
				'all_items'     => __( 'همه انواع قطعه', 'minimal-maison' ),
				'edit_item'     => __( 'ویرایش نوع قطعه', 'minimal-maison' ),
				'view_item'     => __( 'مشاهده نوع قطعه', 'minimal-maison' ),
				'update_item'   => __( 'به‌روزرسانی نوع قطعه', 'minimal-maison' ),
				'add_new_item'  => __( 'افزودن نوع قطعه', 'minimal-maison' ),
				'new_item_name' => __( 'نام نوع قطعه جدید', 'minimal-maison' ),
				'search_items'  => __( 'جستجوی انواع قطعه', 'minimal-maison' ),
				'not_found'     => __( 'نوع قطعه‌ای یافت نشد.', 'minimal-maison' ),
			),
			'hierarchical'      => false,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'show_in_rest'      => true,
			'rewrite'           => false,
			'query_var'         => false,
		)
	);

	register_taxonomy(
		MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY,
		'mm_jewelry_request',
		array(
			'labels'            => array(
				'name'          => __( 'محدوده‌های بودجه', 'minimal-maison' ),
				'singular_name' => __( 'محدوده بودجه', 'minimal-maison' ),
				'menu_name'     => __( 'محدوده‌های بودجه', 'minimal-maison' ),
				'all_items'     => __( 'همه محدوده‌های بودجه', 'minimal-maison' ),
				'edit_item'     => __( 'ویرایش محدوده بودجه', 'minimal-maison' ),
				'view_item'     => __( 'مشاهده محدوده بودجه', 'minimal-maison' ),
				'update_item'   => __( 'به‌روزرسانی محدوده بودجه', 'minimal-maison' ),
				'add_new_item'  => __( 'افزودن محدوده بودجه', 'minimal-maison' ),
				'new_item_name' => __( 'نام محدوده بودجه جدید', 'minimal-maison' ),
				'search_items'  => __( 'جستجوی محدوده‌های بودجه', 'minimal-maison' ),
				'not_found'     => __( 'محدوده بودجه‌ای یافت نشد.', 'minimal-maison' ),
			),
			'hierarchical'      => false,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'show_in_rest'      => true,
			'rewrite'           => false,
			'query_var'         => false,
		)
	);
}
add_action( 'init', 'mm_jewelry_request_register_taxonomies', 11 );
