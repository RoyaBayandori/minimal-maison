<?php
/**
 * Custom post type — Custom Order FAQ entries.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post meta key for FAQ answer (ACF-free fallback).
 */
const MM_CO_FAQ_ANSWER_META = '_mm_co_faq_answer';

/**
 * Register Custom Order FAQ post type.
 */
function mm_register_co_faq_post_type(): void {
	$labels = array(
		'name'               => __( 'Custom Order FAQ', 'minimal-maison' ),
		'singular_name'      => __( 'FAQ Item', 'minimal-maison' ),
		'menu_name'          => __( 'پرسش‌های متداول', 'minimal-maison' ),
		'add_new'            => __( 'افزودن پرسش', 'minimal-maison' ),
		'add_new_item'       => __( 'افزودن پرسش جدید', 'minimal-maison' ),
		'edit_item'          => __( 'ویرایش پرسش', 'minimal-maison' ),
		'new_item'           => __( 'پرسش جدید', 'minimal-maison' ),
		'view_item'          => __( 'مشاهده پرسش', 'minimal-maison' ),
		'search_items'       => __( 'جستجوی پرسش', 'minimal-maison' ),
		'not_found'          => __( 'پرسشی یافت نشد.', 'minimal-maison' ),
		'not_found_in_trash' => __( 'پرسشی در زباله‌دان نیست.', 'minimal-maison' ),
	);

	register_post_type(
		'mm_co_faq',
		array(
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-editor-help',
			'menu_position'       => 29,
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
add_action( 'init', 'mm_register_co_faq_post_type' );
