<?php
/**
 * Canonical ACF field definitions — Portfolio / Gallery page.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * All Portfolio page fields in admin display order.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_acf_portfolio_page_field_definitions(): array {
	return array(
		array(
			'key'   => 'field_mm_pf_tab_hero',
			'label' => __( 'Hero', 'minimal-maison' ),
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_mm_pf_hero_eyebrow',
			'label' => __( 'برچسب بالای عنوان', 'minimal-maison' ),
			'name'  => 'pf_hero_eyebrow',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_hero_heading',
			'label' => __( 'عنوان اصلی', 'minimal-maison' ),
			'name'  => 'pf_hero_heading',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_hero_description',
			'label' => __( 'توضیح', 'minimal-maison' ),
			'name'  => 'pf_hero_description',
			'type'  => 'textarea',
			'rows'  => 3,
		),
		array(
			'key'           => 'field_mm_pf_hero_image',
			'label'         => __( 'تصویر', 'minimal-maison' ),
			'name'          => 'pf_hero_image',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'library'       => 'all',
		),
		array(
			'key'   => 'field_mm_pf_hero_cta_label',
			'label' => __( 'متن دکمه', 'minimal-maison' ),
			'name'  => 'pf_hero_cta_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_hero_cta_url',
			'label' => __( 'لینک دکمه', 'minimal-maison' ),
			'name'  => 'pf_hero_cta_url',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_tab_gallery',
			'label' => __( 'Gallery', 'minimal-maison' ),
			'type'  => 'tab',
		),
		array(
			'key'          => 'field_mm_pf_gallery_notice',
			'label'        => __( 'نمونه کارها', 'minimal-maison' ),
			'name'         => '',
			'type'         => 'message',
			'message'      => __( 'آیتم‌های گالری از منوی «Creations» مدیریت می‌شوند. تصویر شاخص، عنوان، دسته‌بندی و ترتیب نمایش (Page Attributes) را در هر نمونه کار تنظیم کنید.', 'minimal-maison' ),
			'new_lines'    => 'wpautop',
			'esc_html'     => 0,
		),
		array(
			'key'   => 'field_mm_pf_gallery_eyebrow',
			'label' => __( 'برچسب بخش', 'minimal-maison' ),
			'name'  => 'pf_gallery_eyebrow',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_gallery_heading',
			'label' => __( 'عنوان بخش', 'minimal-maison' ),
			'name'  => 'pf_gallery_heading',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_gallery_description',
			'label' => __( 'توضیح بخش', 'minimal-maison' ),
			'name'  => 'pf_gallery_description',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'   => 'field_mm_pf_gallery_filter_all_label',
			'label' => __( 'برچسب فیلتر «همه»', 'minimal-maison' ),
			'name'  => 'pf_gallery_filter_all_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_gallery_view_label',
			'label' => __( 'متن دکمه روی تصویر (هاور)', 'minimal-maison' ),
			'name'  => 'pf_gallery_view_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_gallery_load_more_label',
			'label' => __( 'متن دکمه «مشاهده آثار بیشتر»', 'minimal-maison' ),
			'name'  => 'pf_gallery_load_more_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_gallery_empty_message',
			'label' => __( 'پیام گالری خالی', 'minimal-maison' ),
			'name'  => 'pf_gallery_empty_message',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_tab_about',
			'label' => __( 'About Atelier', 'minimal-maison' ),
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_mm_pf_about_eyebrow',
			'label' => __( 'برچسب بالای عنوان', 'minimal-maison' ),
			'name'  => 'pf_about_eyebrow',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_about_heading',
			'label' => __( 'عنوان', 'minimal-maison' ),
			'name'  => 'pf_about_heading',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_about_body',
			'label' => __( 'متن', 'minimal-maison' ),
			'name'  => 'pf_about_body',
			'type'  => 'textarea',
			'rows'  => 6,
		),
		array(
			'key'           => 'field_mm_pf_about_image',
			'label'         => __( 'تصویر', 'minimal-maison' ),
			'name'          => 'pf_about_image',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'library'       => 'all',
		),
		array(
			'key'   => 'field_mm_pf_about_cta_label',
			'label' => __( 'متن دکمه', 'minimal-maison' ),
			'name'  => 'pf_about_cta_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_about_cta_url',
			'label' => __( 'لینک دکمه', 'minimal-maison' ),
			'name'  => 'pf_about_cta_url',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_tab_final_cta',
			'label' => __( 'Final CTA', 'minimal-maison' ),
			'type'  => 'tab',
		),
		array(
			'key'           => 'field_mm_pf_final_cta_image',
			'label'         => __( 'تصویر', 'minimal-maison' ),
			'name'          => 'pf_final_cta_image',
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'library'       => 'all',
		),
		array(
			'key'   => 'field_mm_pf_final_cta_heading',
			'label' => __( 'عنوان', 'minimal-maison' ),
			'name'  => 'pf_final_cta_heading',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'   => 'field_mm_pf_final_cta_description',
			'label' => __( 'توضیح', 'minimal-maison' ),
			'name'  => 'pf_final_cta_description',
			'type'  => 'textarea',
			'rows'  => 2,
		),
		array(
			'key'   => 'field_mm_pf_final_cta_button_label',
			'label' => __( 'متن دکمه', 'minimal-maison' ),
			'name'  => 'pf_final_cta_button_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_mm_pf_final_cta_button_url',
			'label' => __( 'لینک دکمه', 'minimal-maison' ),
			'name'  => 'pf_final_cta_button_url',
			'type'  => 'text',
		),
	);
}
