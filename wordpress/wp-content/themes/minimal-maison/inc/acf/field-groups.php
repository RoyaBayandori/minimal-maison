<?php
/**
 * ACF local field groups.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether field groups are loaded from acf-json files.
 */
function mm_acf_field_groups_loaded_from_json(): bool {
	return is_readable( mm_acf_json_path() . '/group_mm_homepage_settings.json' );
}

/**
 * Register theme field groups when ACF is active and JSON files are not present.
 */
function mm_acf_register_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	if ( mm_acf_field_groups_loaded_from_json() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_mm_homepage_settings',
			'title'                 => __( 'Homepage Settings', 'minimal-maison' ),
			'fields'                => array(
				array(
					'key'   => 'field_mm_home_tab_hero',
					'label' => __( 'Hero', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_hero_eyebrow',
					'label' => __( 'برچسب بالای عنوان', 'minimal-maison' ),
					'name'  => 'hero_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_hero_heading',
					'label' => __( 'عنوان اصلی', 'minimal-maison' ),
					'name'  => 'hero_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_hero_description',
					'label' => __( 'توضیح', 'minimal-maison' ),
					'name'  => 'hero_description',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_mm_hero_primary_cta_label',
					'label' => __( 'متن دکمه اصلی', 'minimal-maison' ),
					'name'  => 'hero_primary_cta_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_hero_primary_cta_url',
					'label' => __( 'لینک دکمه اصلی', 'minimal-maison' ),
					'name'  => 'hero_primary_cta_url',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_hero_secondary_cta_label',
					'label' => __( 'متن دکمه ثانویه', 'minimal-maison' ),
					'name'  => 'hero_secondary_cta_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_hero_secondary_cta_url',
					'label' => __( 'لینک دکمه ثانویه', 'minimal-maison' ),
					'name'  => 'hero_secondary_cta_url',
					'type'  => 'text',
				),
				array(
					'key'           => 'field_mm_hero_image',
					'label'         => __( 'تصویر بزرگ', 'minimal-maison' ),
					'name'          => 'hero_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_mm_hero_banner_eyebrow',
					'label' => __( 'برچسب روی تصویر', 'minimal-maison' ),
					'name'  => 'hero_banner_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_hero_banner_text',
					'label' => __( 'متن روی تصویر', 'minimal-maison' ),
					'name'  => 'hero_banner_text',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_mm_home_tab_creations',
					'label' => __( 'Creations Section', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_creations_eyebrow',
					'label' => __( 'برچسب بخش', 'minimal-maison' ),
					'name'  => 'creations_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_creations_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'creations_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_creations_description',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'creations_description',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_mm_home_tab_process',
					'label' => __( 'Process', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_process_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'process_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_process_description',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'process_description',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'           => 'field_mm_process_image',
					'label'         => __( 'تصویر بخش', 'minimal-maison' ),
					'name'          => 'process_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'          => 'field_mm_process_steps',
					'label'        => __( 'مراحل', 'minimal-maison' ),
					'name'         => 'process_steps',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'افزودن مرحله', 'minimal-maison' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_mm_process_step_number',
							'label' => __( 'شماره', 'minimal-maison' ),
							'name'  => 'step_number',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_mm_process_step_title',
							'label' => __( 'عنوان', 'minimal-maison' ),
							'name'  => 'step_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_mm_process_step_text',
							'label' => __( 'توضیح', 'minimal-maison' ),
							'name'  => 'step_text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),
				array(
					'key'   => 'field_mm_home_tab_testimonials',
					'label' => __( 'Testimonials Section', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_testimonials_eyebrow',
					'label' => __( 'برچسب بخش', 'minimal-maison' ),
					'name'  => 'testimonials_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_testimonials_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'testimonials_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_testimonials_description',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'testimonials_description',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'   => 'field_mm_home_tab_about',
					'label' => __( 'About', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_about_eyebrow',
					'label' => __( 'برچسب بخش', 'minimal-maison' ),
					'name'  => 'about_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_about_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'about_heading',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_mm_about_paragraphs',
					'label'        => __( 'پاراگراف‌ها', 'minimal-maison' ),
					'name'         => 'about_paragraphs',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'افزودن پاراگراف', 'minimal-maison' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_mm_about_paragraph',
							'label' => __( 'متن', 'minimal-maison' ),
							'name'  => 'paragraph',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),
				array(
					'key'           => 'field_mm_about_image',
					'label'         => __( 'تصویر بخش', 'minimal-maison' ),
					'name'          => 'about_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_mm_about_cta_label',
					'label' => __( 'متن دکمه', 'minimal-maison' ),
					'name'  => 'about_cta_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_about_cta_url',
					'label' => __( 'لینک دکمه', 'minimal-maison' ),
					'name'  => 'about_cta_url',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_home_tab_cta',
					'label' => __( 'CTA / Request Form', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_cta_eyebrow',
					'label' => __( 'برچسب بخش', 'minimal-maison' ),
					'name'  => 'cta_eyebrow',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_cta_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'cta_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_cta_description',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'cta_description',
					'type'  => 'textarea',
					'rows'  => 3,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_mm_creation_details',
			'title'                 => __( 'Creation Details', 'minimal-maison' ),
			'fields'                => array(
				array(
					'key'   => 'field_mm_creation_subtitle',
					'label' => __( 'نوع قطعه', 'minimal-maison' ),
					'name'  => 'creation_subtitle',
					'type'  => 'text',
					'instructions' => __( 'مثلاً: انگشتر سفارشی', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_creation_price_label',
					'label' => __( 'برچسب قیمت', 'minimal-maison' ),
					'name'  => 'creation_price_label',
					'type'  => 'text',
					'instructions' => __( 'مثلاً: قیمت پس از مشاوره', 'minimal-maison' ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'mm_creation',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_mm_testimonial_details',
			'title'                 => __( 'Testimonial Details', 'minimal-maison' ),
			'fields'                => array(
				array(
					'key'   => 'field_mm_testimonial_quote',
					'label' => __( 'نقل‌قول', 'minimal-maison' ),
					'name'  => 'testimonial_quote',
					'type'  => 'textarea',
					'rows'  => 4,
				),
				array(
					'key'   => 'field_mm_testimonial_attribution',
					'label' => __( 'نوع سفارش / نام', 'minimal-maison' ),
					'name'  => 'testimonial_attribution',
					'type'  => 'text',
					'instructions' => __( 'در صورت خالی بودن، عنوان نوشته استفاده می‌شود.', 'minimal-maison' ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'mm_testimonial',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}
add_action( 'acf/init', 'mm_acf_register_field_groups' );
