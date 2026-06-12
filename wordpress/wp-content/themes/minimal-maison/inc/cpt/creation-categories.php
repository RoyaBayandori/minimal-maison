<?php
/**
 * Taxonomy — Creation categories for portfolio gallery filtering.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Taxonomy slug for creation categories.
 */
const MM_CREATION_CATEGORY_TAXONOMY = 'mm_creation_category';

/**
 * Register creation category taxonomy.
 */
function mm_register_creation_category_taxonomy(): void {
	$labels = array(
		'name'              => __( 'دسته‌بندی نمونه کار', 'minimal-maison' ),
		'singular_name'     => __( 'دسته‌بندی', 'minimal-maison' ),
		'search_items'      => __( 'جستجوی دسته‌بندی', 'minimal-maison' ),
		'all_items'         => __( 'همه دسته‌بندی‌ها', 'minimal-maison' ),
		'parent_item'       => __( 'دسته والد', 'minimal-maison' ),
		'parent_item_colon' => __( 'دسته والد:', 'minimal-maison' ),
		'edit_item'         => __( 'ویرایش دسته‌بندی', 'minimal-maison' ),
		'update_item'       => __( 'به‌روزرسانی دسته‌بندی', 'minimal-maison' ),
		'add_new_item'      => __( 'افزودن دسته‌بندی جدید', 'minimal-maison' ),
		'new_item_name'     => __( 'نام دسته‌بندی جدید', 'minimal-maison' ),
		'menu_name'         => __( 'دسته‌بندی‌ها', 'minimal-maison' ),
	);

	register_taxonomy(
		MM_CREATION_CATEGORY_TAXONOMY,
		array( 'mm_creation' ),
		array(
			'labels'            => $labels,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'rewrite'           => false,
			'query_var'         => false,
		)
	);
}
add_action( 'init', 'mm_register_creation_category_taxonomy', 11 );

/**
 * All creation categories for gallery filters.
 *
 * @return WP_Term[]
 */
function mm_portfolio_categories(): array {
	$terms = get_terms(
		array(
			'taxonomy'   => MM_CREATION_CATEGORY_TAXONOMY,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	return $terms;
}
