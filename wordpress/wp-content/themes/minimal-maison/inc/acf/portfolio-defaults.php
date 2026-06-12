<?php
/**
 * Portfolio / Gallery page default copy.
 *
 * All values empty — content is entered only via WP Admin.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default scalar field values keyed by field name.
 *
 * @return array<string, string>
 */
function mm_portfolio_default_strings(): array {
	return array(
		'pf_hero_eyebrow'              => '',
		'pf_hero_heading'              => '',
		'pf_hero_description'          => '',
		'pf_hero_cta_label'            => '',
		'pf_hero_cta_url'              => '',
		'pf_gallery_eyebrow'           => '',
		'pf_gallery_heading'           => '',
		'pf_gallery_description'       => '',
		'pf_gallery_filter_all_label'  => '',
		'pf_gallery_view_label'        => '',
		'pf_gallery_load_more_label'   => '',
		'pf_gallery_empty_message'     => '',
		'pf_about_eyebrow'             => '',
		'pf_about_heading'             => '',
		'pf_about_body'                => '',
		'pf_about_cta_label'           => '',
		'pf_about_cta_url'             => '',
		'pf_final_cta_heading'         => '',
		'pf_final_cta_description'     => '',
		'pf_final_cta_button_label'    => '',
		'pf_final_cta_button_url'      => '',
	);
}
