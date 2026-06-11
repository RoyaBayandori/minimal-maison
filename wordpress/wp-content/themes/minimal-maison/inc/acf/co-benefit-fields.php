<?php
/**
 * ACF group field definitions — Custom Order benefit slots.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build one Custom Order benefit group field.
 *
 * @param int $number Benefit slot number (1–6).
 * @return array<string, mixed>
 */
function mm_acf_co_benefit_group_field( int $number ): array {
	$key = 'field_mm_co_benefit_' . $number;

	return array(
		'key'        => $key,
		'label'      => sprintf(
			/* translators: %d: benefit slot number */
			__( 'مزیت %d', 'minimal-maison' ),
			$number
		),
		'name'       => 'co_benefit_' . $number,
		'type'       => 'group',
		'layout'     => 'block',
		'sub_fields' => array(
			array(
				'key'           => $key . '_image',
				'label'         => __( 'تصویر', 'minimal-maison' ),
				'name'          => 'image',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
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
 * Ordered Custom Order benefit group fields.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_acf_co_benefit_group_fields(): array {
	$fields = array();

	for ( $number = 1; $number <= 6; $number++ ) {
		$fields[] = mm_acf_co_benefit_group_field( $number );
	}

	return $fields;
}

/**
 * Registered benefit group field names in display order.
 *
 * @return string[]
 */
function mm_co_benefit_field_names(): array {
	return array(
		'co_benefit_1',
		'co_benefit_2',
		'co_benefit_3',
		'co_benefit_4',
		'co_benefit_5',
		'co_benefit_6',
	);
}
