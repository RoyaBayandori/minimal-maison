<?php
/**
 * Custom Order landing page default copy and structured fallbacks.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default scalar field values keyed by field name.
 *
 * @return array<string, string>
 */
function mm_co_default_strings(): array {
	return array(
		'co_hero_eyebrow'            => __( 'سفارش اختصاصی', 'minimal-maison' ),
		'co_hero_heading'            => __( 'طلایی که فقط برای شما ساخته می‌شود', 'minimal-maison' ),
		'co_hero_description'        => __( 'از اولین گفتگو تا تحویل، هر مرحله بر اساس سلیقه، داستان و خواسته شما پیش می‌رود — نه بر اساس ویترین.', 'minimal-maison' ),
		'co_hero_cta_label'          => __( 'شروع درخواست', 'minimal-maison' ),
		'co_hero_cta_url'            => '#request-form',
		'co_benefits_heading'        => __( 'چرا سفارش اختصاصی', 'minimal-maison' ),
		// 'co_benefits_description'    => __( 'در مینیمال هر قطعه یک‌بار و برای یک نفر ساخته می‌شود.', 'minimal-maison' ),
		'co_form_heading'            => __( 'فرم درخواست مشاوره', 'minimal-maison' ),
		'co_form_description'        => __( 'چند پرسش کوتاه — سپس کارگاه برای هماهنگی گفتگو با شما تماس می‌گیرد.', 'minimal-maison' ),
		'co_form_note'                 => '',
		'co_faq_heading'             => __( 'پرسش‌های متداول', 'minimal-maison' ),
		'co_final_cta_heading'       => __( 'آماده شروع گفت‌وگو هستید؟', 'minimal-maison' ),
		'co_final_cta_description'   => __( 'فرم را تکمیل کنید — معمولاً ظرف یک تا دو روز کاری برای هماهنگی با شما تماس می‌گیریم.', 'minimal-maison' ),
		'co_final_cta_button_label'  => __( 'ارسال درخواست', 'minimal-maison' ),
		'co_final_cta_button_url'    => '#request-form',
	);
}

/**
 * Benefit cards are CMS-only. No front-end fallback rows.
 *
 * @return array<int, array{image_id: int, title: string, description: string}>
 */
function mm_co_default_benefits(): array {
	return array();
}
