<?php
/**
 * ACF local field groups.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/craft-step-fields.php';

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
					'label'         => __( 'Desktop Hero Image', 'minimal-maison' ),
					'name'          => 'hero_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => __( 'Landscape image for viewports 1200px and wider.', 'minimal-maison' ),
					'wrapper'       => array(
						'width' => '33',
					),
				),
				array(
					'key'           => 'field_mm_hero_image_tablet',
					'label'         => __( 'Tablet Hero Image', 'minimal-maison' ),
					'name'          => 'hero_image_tablet',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => __( 'Image for viewports 768px–1199px. Falls back to desktop if empty.', 'minimal-maison' ),
					'wrapper'       => array(
						'width' => '33',
					),
				),
				array(
					'key'           => 'field_mm_hero_image_mobile',
					'label'         => __( 'Mobile Hero Image', 'minimal-maison' ),
					'name'          => 'hero_image_mobile',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'instructions'  => __( 'Portrait image for viewports below 768px. Falls back to tablet, then desktop.', 'minimal-maison' ),
					'wrapper'       => array(
						'width' => '34',
					),
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
					'key'   => 'field_mm_home_tab_philosophy',
					'label' => __( 'Brand Philosophy', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mm_philosophy_eyebrow',
					'label'         => __( 'برچسب بخش', 'minimal-maison' ),
					'name'          => 'philosophy_eyebrow',
					'type'          => 'text',
					'default_value' => 'فلسفه مینیمال',
				),
				array(
					'key'           => 'field_mm_philosophy_heading',
					'label'         => __( 'عنوان بخش', 'minimal-maison' ),
					'name'          => 'philosophy_heading',
					'type'          => 'text',
					'default_value' => 'هر قطعه تنها یک بار ساخته می‌شود',
				),
				array(
					'key'           => 'field_mm_philosophy_body',
					'label'         => __( 'متن بخش', 'minimal-maison' ),
					'name'          => 'philosophy_body',
					'type'          => 'textarea',
					'rows'          => 4,
					'default_value' => "در مینیمال هیچ طرح آماده‌ای وجود ندارد.\nهر سفارش از اولین طرح تا آخرین پرداخت، برای یک نفر و تنها یک نفر ساخته می‌شود.",
				),
				array(
					'key'           => 'field_mm_philosophy_cta_label',
					'label'         => __( 'متن دکمه', 'minimal-maison' ),
					'name'          => 'philosophy_cta_label',
					'type'          => 'text',
					'default_value' => 'داستان مینیمال',
				),
				array(
					'key'           => 'field_mm_philosophy_cta_url',
					'label'         => __( 'لینک دکمه', 'minimal-maison' ),
					'name'          => 'philosophy_cta_url',
					'type'          => 'text',
					'default_value' => '/about',
				),
				array(
					'key'           => 'field_mm_philosophy_image',
					'label'         => __( 'تصویر بخش', 'minimal-maison' ),
					'name'          => 'philosophy_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'   => 'field_mm_home_tab_craft',
					'label' => __( 'Craft Process', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_mm_craft_eyebrow',
					'label'        => __( 'برچسب بخش', 'minimal-maison' ),
					'name'         => 'craft_eyebrow',
					'type'         => 'text',
					'instructions' => __( 'Legacy — not rendered on the homepage.', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_craft_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'craft_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_craft_description',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'craft_description',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				...mm_acf_craft_step_group_fields(),
				array(
					'key'          => 'field_mm_craft_steps',
					'label'        => __( 'مراحل (Legacy)', 'minimal-maison' ),
					'name'         => 'craft_steps',
					'type'         => 'repeater',
					'layout'       => 'block',
					'min'          => 1,
					'max'          => 4,
					'button_label' => __( 'افزودن مرحله', 'minimal-maison' ),
					'instructions' => __( 'Legacy — no longer used. Use the step groups above.', 'minimal-maison' ),
					'sub_fields'   => array(
						array(
							'key'   => 'field_mm_craft_step_number',
							'label' => __( 'شماره', 'minimal-maison' ),
							'name'  => 'step_number',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_mm_craft_step_title',
							'label' => __( 'عنوان', 'minimal-maison' ),
							'name'  => 'step_title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_mm_craft_step_text',
							'label' => __( 'توضیح', 'minimal-maison' ),
							'name'  => 'step_text',
							'type'  => 'textarea',
							'rows'  => 3,
						),
					),
				),
				array(
					'key'   => 'field_mm_home_tab_creations',
					'label' => __( 'Featured Creations', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_featured_creations_eyebrow',
					'label' => __( 'برچسب بخش', 'minimal-maison' ),
					'name'  => 'featured_creations_eyebrow',
					'type'  => 'text',
					'instructions' => __( 'Legacy — no longer used by the homepage template.', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_featured_creations_heading',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'featured_creations_heading',
					'type'  => 'text',
					'instructions' => __( 'Legacy — no longer used by the homepage template.', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_featured_creations_intro',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'featured_creations_intro',
					'type'  => 'textarea',
					'rows'  => 2,
					'instructions' => __( 'Legacy — no longer used by the homepage template.', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_featured_creations_label',
					'label' => __( 'برچسب جدید بخش', 'minimal-maison' ),
					'name'  => 'featured_creations_label',
					'type'  => 'text',
					'instructions' => __( 'Legacy — no longer used by the homepage template.', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_featured_creations_title',
					'label' => __( 'عنوان بخش', 'minimal-maison' ),
					'name'  => 'featured_creations_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_featured_creations_description',
					'label' => __( 'توضیح بخش', 'minimal-maison' ),
					'name'  => 'featured_creations_description',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'           => 'field_mm_featured_creations',
					'label'         => __( 'آثار منتخب', 'minimal-maison' ),
					'name'          => 'featured_creations',
					'type'          => 'relationship',
					'post_type'     => array( 'mm_creation' ),
					'filters'       => array( 'search' ),
					'min'           => 0,
					'max'           => '',
					'return_format' => 'object',
					'instructions'  => __( 'Select creations for the homepage collection rail. Drag to set display order. Create pieces under Creations first.', 'minimal-maison' ),
				),
				array(
					'key'           => 'field_mm_featured_creations_cta_label',
					'label'         => __( 'متن دکمه', 'minimal-maison' ),
					'name'          => 'featured_creations_cta_label',
					'type'          => 'text',
					'default_value' => 'مشاهده مجموعه',
				),
				array(
					'key'   => 'field_mm_featured_creations_cta_url',
					'label' => __( 'لینک دکمه', 'minimal-maison' ),
					'name'  => 'featured_creations_cta_url',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_mm_featured_creations_items',
					'label'        => __( 'آیتم‌های آثار منتخب (Legacy)', 'minimal-maison' ),
					'name'         => 'featured_creations_items',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => __( 'افزودن آیتم', 'minimal-maison' ),
					'instructions' => __( 'Legacy — no longer used by the homepage. Use the Featured Creations relationship field above.', 'minimal-maison' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_mm_featured_creations_item_image',
							'label'         => __( 'تصویر', 'minimal-maison' ),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
						array(
							'key'   => 'field_mm_featured_creations_item_title',
							'label' => __( 'عنوان', 'minimal-maison' ),
							'name'  => 'title',
							'type'  => 'text',
						),
					),
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
					'label'         => __( 'Process Image', 'minimal-maison' ),
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
					'key'   => 'field_mm_home_tab_quote',
					'label' => __( 'Customer Quote', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_mm_customer_quote_verified',
					'label'         => __( 'Verified customer quote', 'minimal-maison' ),
					'name'          => 'customer_quote_verified',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 0,
					'instructions'  => __( 'Only enable with client approval. Quote is hidden when off.', 'minimal-maison' ),
				),
				array(
					'key'          => 'field_mm_customer_quote',
					'label'        => __( 'Quote text', 'minimal-maison' ),
					'name'         => 'customer_quote',
					'type'         => 'textarea',
					'rows'         => 4,
					'instructions' => __( 'Approved customer wording only — no placeholder text.', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_customer_quote_attribution',
					'label' => __( 'Attribution', 'minimal-maison' ),
					'name'  => 'customer_quote_attribution',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_mm_home_tab_business',
					'label' => __( 'Business Information', 'minimal-maison' ),
					'type'  => 'tab',
				),
				array(
					'key'   => 'field_mm_instagram_url',
					'label' => __( 'Instagram URL', 'minimal-maison' ),
					'name'  => 'instagram_url',
					'type'  => 'url',
				),
				array(
					'key'          => 'field_mm_whatsapp_url',
					'label'        => __( 'WhatsApp URL', 'minimal-maison' ),
					'name'         => 'whatsapp_url',
					'type'         => 'text',
					'instructions' => __( 'Full wa.me link or mobile number (e.g. 09121234567).', 'minimal-maison' ),
				),
				array(
					'key'   => 'field_mm_email',
					'label' => __( 'Email', 'minimal-maison' ),
					'name'  => 'email',
					'type'  => 'email',
				),
				array(
					'key'   => 'field_mm_phone_number',
					'label' => __( 'Phone Number', 'minimal-maison' ),
					'name'  => 'phone_number',
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
					'key'          => 'field_mm_creation_subtitle',
					'label'        => __( 'نوع قطعه', 'minimal-maison' ),
					'name'         => 'creation_subtitle',
					'type'         => 'text',
					'instructions' => __( 'مثلاً: انگشتر سفارشی', 'minimal-maison' ),
				),
				array(
					'key'          => 'field_mm_creation_story',
					'label'        => __( 'داستان کوتاه', 'minimal-maison' ),
					'name'         => 'creation_story',
					'type'         => 'textarea',
					'rows'         => 3,
					'instructions' => __( 'روایت کوتاه برای نمایش در گالری صفحه اصلی.', 'minimal-maison' ),
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
