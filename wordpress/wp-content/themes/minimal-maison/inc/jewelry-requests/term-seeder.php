<?php
/**
 * Seed default piece type and budget range taxonomy terms.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Option key tracking seeded taxonomy data version.
 */
const MM_JEWELRY_REQUEST_DATA_VERSION_OPTION = 'mm_jewelry_request_data_version';

/**
 * Current seeded data schema version.
 */
const MM_JEWELRY_REQUEST_DATA_VERSION = 1;

/**
 * Seed default terms after theme activation.
 */
function mm_jewelry_request_seed_terms_on_theme_switch(): void {
	mm_jewelry_request_seed_terms();
	update_option( MM_JEWELRY_REQUEST_DATA_VERSION_OPTION, MM_JEWELRY_REQUEST_DATA_VERSION, false );
}
add_action( 'after_switch_theme', 'mm_jewelry_request_seed_terms_on_theme_switch' );

/**
 * Ensure default terms exist on boot (clean installs, existing activations).
 */
function mm_jewelry_request_maybe_seed_terms(): void {
	if ( ! taxonomy_exists( MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY ) ) {
		return;
	}

	$stored_version = (int) get_option( MM_JEWELRY_REQUEST_DATA_VERSION_OPTION, 0 );

	if ( $stored_version >= MM_JEWELRY_REQUEST_DATA_VERSION && mm_jewelry_request_has_seeded_terms() ) {
		return;
	}

	mm_jewelry_request_seed_terms();
	update_option( MM_JEWELRY_REQUEST_DATA_VERSION_OPTION, MM_JEWELRY_REQUEST_DATA_VERSION, false );
}
add_action( 'init', 'mm_jewelry_request_maybe_seed_terms', 20 );

/**
 * Whether both taxonomies contain at least one term.
 *
 * @return bool
 */
function mm_jewelry_request_has_seeded_terms(): bool {
	$piece_count  = wp_count_terms(
		array(
			'taxonomy'   => MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY,
			'hide_empty' => false,
		)
	);
	$budget_count = wp_count_terms(
		array(
			'taxonomy'   => MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY,
			'hide_empty' => false,
		)
	);

	return ! is_wp_error( $piece_count )
		&& ! is_wp_error( $budget_count )
		&& (int) $piece_count > 0
		&& (int) $budget_count > 0;
}

/**
 * Insert default piece type and budget range terms.
 */
function mm_jewelry_request_seed_terms(): void {
	foreach ( mm_jewelry_request_default_order_types() as $slug => $label ) {
		mm_jewelry_request_ensure_term( MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY, $slug, $label );
	}

	foreach ( mm_jewelry_request_default_budget_ranges() as $slug => $label ) {
		mm_jewelry_request_ensure_term( MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY, $slug, $label );
	}
}

/**
 * Create a taxonomy term when missing.
 *
 * @param string $taxonomy Taxonomy slug.
 * @param string $slug     Term slug.
 * @param string $label    Term name.
 */
function mm_jewelry_request_ensure_term( string $taxonomy, string $slug, string $label ): void {
	if ( term_exists( $slug, $taxonomy ) ) {
		return;
	}

	wp_insert_term(
		$label,
		$taxonomy,
		array(
			'slug' => $slug,
		)
	);
}
