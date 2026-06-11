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
		'co_hero_eyebrow'              => '',
		'co_hero_heading'              => '',
		'co_hero_description'          => '',
		'co_hero_cta_label'            => '',
		'co_hero_cta_url'              => '',
		'co_benefits_heading'          => '',
		'co_benefits_description'      => '',
		'co_process_heading'           => '',
		'co_form_heading'              => '',
		'co_form_description'          => '',
		'co_form_submit_label'         => '',
		'co_faq_heading'               => '',
		'co_faq_description'           => '',
		'co_final_cta_heading'         => '',
		'co_final_cta_description'     => '',
		'co_final_cta_button_label'    => '',
		'co_final_cta_button_url'      => '',
	);
}

/**
 * Built-in SVG icon keys for process steps when no CMS icon is uploaded.
 *
 * @return string[]
 */
function mm_co_process_step_icon_keys(): array {
	return array(
		'phone',
		'idea',
		'document',
		'delivery',
	);
}
