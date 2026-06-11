<?php
/**
 * ACF local field groups — Custom Order landing page and FAQ CPT.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether Custom Order field groups are loaded from JSON.
 */
function mm_acf_custom_order_groups_loaded_from_json(): bool {
	return is_readable( mm_acf_json_path() . '/group_mm_custom_order_page.json' )
		&& is_readable( mm_acf_json_path() . '/group_mm_co_faq_details.json' );
}

/**
 * Register Custom Order field groups when JSON is not present.
 */
function mm_acf_register_custom_order_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	if ( mm_acf_custom_order_groups_loaded_from_json() ) {
		return;
	}

	$benefit_fields       = mm_acf_co_benefit_group_fields();
	$process_step_fields  = mm_acf_co_process_step_group_fields();

	acf_add_local_field_group(
		array(
			'key'                   => 'group_mm_custom_order_page',
			'title'                 => __( 'Custom Order Page', 'minimal-maison' ),
			'fields'                => array_merge(
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
				$benefit_fields,
				array(
					array(
						'key'   => 'field_mm_co_tab_form',
						'label' => __( 'Form Section', 'minimal-maison' ),
						'type'  => 'tab',
					),
					array(
						'key'   => 'field_mm_co_process_heading',
						'label' => __( 'عنوان مراحل', 'minimal-maison' ),
						'name'  => 'co_process_heading',
						'type'  => 'text',
					),
				),
				$process_step_fields,
				array(
					array(
						'key'   => 'field_mm_co_form_heading',
						'label' => __( 'عنوان فرم', 'minimal-maison' ),
						'name'  => 'co_form_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_mm_co_form_description',
						'label' => __( 'توضیح', 'minimal-maison' ),
						'name'  => 'co_form_description',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_mm_co_form_note',
						'label' => __( 'یادداشت (اختیاری)', 'minimal-maison' ),
						'name'  => 'co_form_note',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_mm_co_tab_faq',
						'label' => __( 'FAQ', 'minimal-maison' ),
						'type'  => 'tab',
					),
					array(
						'key'   => 'field_mm_co_faq_heading',
						'label' => __( 'عنوان بخش', 'minimal-maison' ),
						'name'  => 'co_faq_heading',
						'type'  => 'text',
					),
					array(
						'key'           => 'field_mm_co_faq_items',
						'label'         => __( 'پرسش‌ها', 'minimal-maison' ),
						'name'          => 'co_faq_items',
						'type'          => 'relationship',
						'post_type'     => array( 'mm_co_faq' ),
						'filters'       => array( 'search' ),
						'min'           => 0,
						'max'           => 12,
						'return_format' => 'object',
					),
					array(
						'key'   => 'field_mm_co_tab_final_cta',
						'label' => __( 'Final CTA', 'minimal-maison' ),
						'type'  => 'tab',
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
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-custom-order.php',
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
			'key'                   => 'group_mm_co_faq_details',
			'title'                 => __( 'FAQ Details', 'minimal-maison' ),
			'fields'                => array(
				array(
					'key'   => 'field_mm_co_faq_answer',
					'label' => __( 'پاسخ', 'minimal-maison' ),
					'name'  => 'faq_answer',
					'type'  => 'textarea',
					'rows'  => 4,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'mm_co_faq',
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
add_action( 'acf/init', 'mm_acf_register_custom_order_field_groups' );

/**
 * Mirror FAQ answer into post meta for ACF-free reads.
 *
 * @param int $post_id FAQ post ID.
 */
function mm_co_faq_sync_answer_meta( int $post_id ): void {
	if ( 'mm_co_faq' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( ! mm_acf_available() ) {
		return;
	}

	$answer = get_field( 'faq_answer', $post_id );

	if ( is_string( $answer ) ) {
		update_post_meta( $post_id, MM_CO_FAQ_ANSWER_META, $answer );
	}
}
add_action( 'acf/save_post', 'mm_co_faq_sync_answer_meta' );
