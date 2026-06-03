<?php
/**
 * ACF group field definitions — Craft Process steps (How It Works).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build one Craft Process step group field for local registration.
 *
 * @param string $slug       Field slug (e.g. consultation).
 * @param string $label      Admin label.
 * @return array<string, mixed>
 */
function mm_acf_craft_step_group_field( string $slug, string $label ): array {
	$key = 'field_mm_craft_step_' . $slug;

	return array(
		'key'        => $key,
		'label'      => $label,
		'name'       => 'craft_step_' . $slug,
		'type'       => 'group',
		'layout'     => 'block',
		'instructions' => __( 'Optional image is stored for future use; not displayed on the homepage yet.', 'minimal-maison' ),
		'sub_fields' => array(
			array(
				'key'   => $key . '_title',
				'label' => __( 'عنوان', 'minimal-maison' ),
				'name'  => 'title',
				'type'  => 'text',
			),
			array(
				'key'   => $key . '_text',
				'label' => __( 'توضیح', 'minimal-maison' ),
				'name'  => 'text',
				'type'  => 'textarea',
				'rows'  => 3,
			),
			array(
				'key'           => $key . '_image',
				'label'         => __( 'تصویر', 'minimal-maison' ),
				'name'          => 'image',
				'type'          => 'image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
			),
		),
	);
}

/**
 * Ordered Craft Process step group fields.
 *
 * @return array<int, array<string, mixed>>
 */
function mm_acf_craft_step_group_fields(): array {
	return array(
		mm_acf_craft_step_group_field( 'consultation', __( 'مرحله — گفتگو', 'minimal-maison' ) ),
		mm_acf_craft_step_group_field( 'design', __( 'مرحله — طراحی', 'minimal-maison' ) ),
		mm_acf_craft_step_group_field( 'approval', __( 'مرحله — تأیید', 'minimal-maison' ) ),
		mm_acf_craft_step_group_field( 'production', __( 'مرحله — ساخت', 'minimal-maison' ) ),
		mm_acf_craft_step_group_field( 'delivery', __( 'مرحله — تحویل', 'minimal-maison' ) ),
	);
}
