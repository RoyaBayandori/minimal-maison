<?php
/**
 * Canonical ACF field definitions — Custom Order landing page (ACF Free).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require_once MM_THEME_DIR . '/inc/acf/co-benefit-fields.php';
require_once MM_THEME_DIR . '/inc/acf/co-process-step-fields.php';

/**
 * All Custom Order page fields in admin display order.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_acf_co_page_field_definitions(): array {
	return array_merge(
		array(
			array(
				'key'   => 'field_mm_co_tab_hero',
				'label' => __( 'Hero', 'minimal-maison' ),
				'type'  => 'tab',
			),
			array(
				'key'   => 'field_mm_co_hero_eyebrow',
				'label' => __( 'برچسب بالای عنوان', 'minimal-maison' ),
				'name'  => 'co_hero_eyebrow',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_hero_heading',
				'label' => __( 'عنوان اصلی', 'minimal-maison' ),
				'name'  => 'co_hero_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_hero_description',
				'label' => __( 'توضیح', 'minimal-maison' ),
				'name'  => 'co_hero_description',
				'type'  => 'textarea',
				'rows'  => 3,
			),
			array(
				'key'           => 'field_mm_co_hero_image',
				'label'         => __( 'تصویر', 'minimal-maison' ),
				'name'          => 'co_hero_image',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
			),
			array(
				'key'   => 'field_mm_co_hero_cta_label',
				'label' => __( 'متن دکمه', 'minimal-maison' ),
				'name'  => 'co_hero_cta_label',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_hero_cta_url',
				'label' => __( 'لینک دکمه', 'minimal-maison' ),
				'name'  => 'co_hero_cta_url',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_tab_benefits',
				'label' => __( 'Benefits', 'minimal-maison' ),
				'type'  => 'tab',
			),
			array(
				'key'   => 'field_mm_co_benefits_heading',
				'label' => __( 'عنوان بخش', 'minimal-maison' ),
				'name'  => 'co_benefits_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_benefits_description',
				'label' => __( 'توضیح بخش', 'minimal-maison' ),
				'name'  => 'co_benefits_description',
				'type'  => 'textarea',
				'rows'  => 2,
			),
		),
		mm_acf_co_benefit_group_fields(),
		array(
			array(
				'key'   => 'field_mm_co_tab_form_intro',
				'label' => __( 'Form Intro', 'minimal-maison' ),
				'type'  => 'tab',
			),
			array(
				'key'   => 'field_mm_co_form_heading',
				'label' => __( 'عنوان فرم', 'minimal-maison' ),
				'name'  => 'co_form_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_form_description',
				'label' => __( 'توضیح فرم', 'minimal-maison' ),
				'name'  => 'co_form_description',
				'type'  => 'textarea',
				'rows'  => 3,
			),
			array(
				'key'   => 'field_mm_co_form_submit_label',
				'label' => __( 'متن دکمه ارسال', 'minimal-maison' ),
				'name'  => 'co_form_submit_label',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_tab_after_submission',
				'label' => __( 'After Submission', 'minimal-maison' ),
				'type'  => 'tab',
			),
			array(
				'key'   => 'field_mm_co_process_heading',
				'label' => __( 'عنوان بخش', 'minimal-maison' ),
				'name'  => 'co_process_heading',
				'type'  => 'text',
			),
		),
		mm_acf_co_process_step_group_fields(),
		array(
			array(
				'key'   => 'field_mm_co_tab_faq',
				'label' => __( 'FAQ', 'minimal-maison' ),
				'type'  => 'tab',
			),
			array(
				'key'          => 'field_mm_co_faq_notice',
				'label'        => __( 'پرسش‌ها', 'minimal-maison' ),
				'name'         => '',
				'type'         => 'message',
				'message'      => __( 'پرسش‌ها از منوی «پرسش‌های متداول» مدیریت می‌شوند. عنوان = پرسش، فیلد پاسخ = متن پاسخ.', 'minimal-maison' ),
				'new_lines'    => 'wpautop',
				'esc_html'     => 0,
			),
			array(
				'key'   => 'field_mm_co_faq_heading',
				'label' => __( 'عنوان بخش', 'minimal-maison' ),
				'name'  => 'co_faq_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_faq_description',
				'label' => __( 'توضیح بخش (اختیاری)', 'minimal-maison' ),
				'name'  => 'co_faq_description',
				'type'  => 'textarea',
				'rows'  => 2,
			),
			array(
				'key'   => 'field_mm_co_tab_final_cta',
				'label' => __( 'Final CTA', 'minimal-maison' ),
				'type'  => 'tab',
			),
			array(
				'key'           => 'field_mm_co_final_cta_image',
				'label'         => __( 'تصویر', 'minimal-maison' ),
				'name'          => 'co_final_cta_image',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
			),
			array(
				'key'   => 'field_mm_co_final_cta_heading',
				'label' => __( 'عنوان', 'minimal-maison' ),
				'name'  => 'co_final_cta_heading',
				'type'  => 'textarea',
				'rows'  => 2,
			),
			array(
				'key'   => 'field_mm_co_final_cta_description',
				'label' => __( 'توضیح', 'minimal-maison' ),
				'name'  => 'co_final_cta_description',
				'type'  => 'textarea',
				'rows'  => 2,
			),
			array(
				'key'   => 'field_mm_co_final_cta_button_label',
				'label' => __( 'متن دکمه', 'minimal-maison' ),
				'name'  => 'co_final_cta_button_label',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_mm_co_final_cta_button_url',
				'label' => __( 'لینک دکمه', 'minimal-maison' ),
				'name'  => 'co_final_cta_button_url',
				'type'  => 'text',
			),
		)
	);
}
