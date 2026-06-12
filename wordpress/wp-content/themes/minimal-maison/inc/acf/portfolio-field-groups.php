<?php
/**
 * ACF local field groups — Portfolio / Gallery page.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/portfolio-page-fields.php';

/**
 * Whether Portfolio field groups are loaded from JSON.
 */
function mm_acf_portfolio_groups_loaded_from_json(): bool {
	return is_readable( mm_acf_json_path() . '/group_mm_portfolio_page.json' );
}

/**
 * Register Portfolio field groups when JSON is not present.
 */
function mm_acf_register_portfolio_field_groups(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	if ( mm_acf_portfolio_groups_loaded_from_json() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_mm_portfolio_page',
			'title'                 => __( 'Portfolio Page', 'minimal-maison' ),
			'fields'                => mm_acf_portfolio_page_field_definitions(),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-portfolio.php',
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
add_action( 'acf/init', 'mm_acf_register_portfolio_field_groups' );
