<?php
/**
 * ACF local field groups — Custom Order landing page and FAQ CPT.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/co-page-fields.php';

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

	acf_add_local_field_group(
		array(
			'key'                   => 'group_mm_custom_order_page',
			'title'                 => __( 'Custom Order Page', 'minimal-maison' ),
			'fields'                => mm_acf_co_page_field_definitions(),
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
