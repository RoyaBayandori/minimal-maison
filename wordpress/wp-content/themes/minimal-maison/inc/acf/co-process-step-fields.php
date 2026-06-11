<?php
/**
 * ACF group field definitions — Custom Order process steps.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build one Custom Order process step group field.
 *
 * @param int $number Step slot number (1–4).
 * @return array<string, mixed>
 */
function mm_acf_co_process_step_group_field( int $number ): array {
	$key = 'field_mm_co_process_step_' . $number;

	return array(
		'key'        => $key,
		'label'      => sprintf(
			/* translators: %d: process step slot number */
			__( 'مرحله %d', 'minimal-maison' ),
			$number
		),
		'name'       => 'co_process_step_' . $number,
		'type'       => 'group',
		'layout'     => 'block',
		'sub_fields' => array(
			array(
				'key'           => $key . '_icon',
				'label'         => __( 'آیکن', 'minimal-maison' ),
				'name'          => 'icon',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
			),
			array(
				'key'   => $key . '_title',
				'label' => __( 'عنوان', 'minimal-maison' ),
				'name'  => 'title',
				'type'  => 'text',
			),
			array(
				'key'   => $key . '_description',
				'label' => __( 'توضیح', 'minimal-maison' ),
				'name'  => 'description',
				'type'  => 'textarea',
				'rows'  => 2,
			),
		),
	);
}

/**
 * Ordered Custom Order process step group fields.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_acf_co_process_step_group_fields(): array {
	$fields = array();

	for ( $number = 1; $number <= 4; $number++ ) {
		$fields[] = mm_acf_co_process_step_group_field( $number );
	}

	return $fields;
}

/**
 * Registered process step group field names in display order.
 *
 * @return string[]
 */
function mm_co_process_step_field_names(): array {
	return array(
		'co_process_step_1',
		'co_process_step_2',
		'co_process_step_3',
		'co_process_step_4',
	);
}
