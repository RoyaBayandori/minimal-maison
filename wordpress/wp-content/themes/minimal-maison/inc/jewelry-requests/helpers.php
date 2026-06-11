<?php
/**
 * Jewelry request helpers — field definitions and utilities.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta key prefix for request post meta.
 */
const MM_JEWELRY_REQUEST_META_PREFIX = '_mm_req_';

/**
 * Piece type taxonomy slug.
 */
const MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY = 'mm_piece_type';

/**
 * Budget range taxonomy slug.
 */
const MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY = 'mm_budget_range';

/**
 * Default workflow status for new requests.
 */
const MM_JEWELRY_REQUEST_DEFAULT_STATUS = 'new';

/**
 * Fallback piece type options when taxonomy terms are unavailable.
 *
 * @return array<string, string> Slug => label.
 */
function mm_jewelry_request_default_order_types(): array {
	return array(
		'ring'         => __( 'انگشتر', 'minimal-maison' ),
		'necklace'     => __( 'گردنبند', 'minimal-maison' ),
		'bracelet'     => __( 'دستبند', 'minimal-maison' ),
		'earring'      => __( 'گوشواره', 'minimal-maison' ),
		'wedding_ring' => __( 'حلقه ازدواج', 'minimal-maison' ),
		'other'        => __( 'سایر', 'minimal-maison' ),
	);
}

/**
 * Fallback budget options when taxonomy terms are unavailable.
 *
 * @return array<string, string> Slug => label.
 */
function mm_jewelry_request_default_budget_ranges(): array {
	return array(
		'under_50'  => __( 'تا حدود ۵۰ میلیون تومان', 'minimal-maison' ),
		'50_100'    => __( '۵۰ تا ۱۰۰ میلیون تومان', 'minimal-maison' ),
		'100_200'   => __( '۱۰۰ تا ۲۰۰ میلیون تومان', 'minimal-maison' ),
		'200_500'   => __( '۲۰۰ تا ۵۰۰ میلیون تومان', 'minimal-maison' ),
		'over_500'  => __( 'بیش از ۵۰۰ میلیون تومان', 'minimal-maison' ),
		'undecided' => __( 'هنوز درباره بودجه مطمئن نیستم', 'minimal-maison' ),
	);
}

/**
 * Allowed request workflow statuses (application state).
 *
 * @return array<string, string> Slug => label.
 */
function mm_jewelry_request_statuses(): array {
	return array(
		'new'            => __( 'جدید', 'minimal-maison' ),
		'contacted'      => __( 'تماس گرفته شده', 'minimal-maison' ),
		'designing'      => __( 'در حال طراحی', 'minimal-maison' ),
		'approved'       => __( 'تأیید شده', 'minimal-maison' ),
		'in_production'  => __( 'در حال ساخت', 'minimal-maison' ),
		'completed'      => __( 'تکمیل شده', 'minimal-maison' ),
		'cancelled'      => __( 'لغو شده', 'minimal-maison' ),
	);
}

/**
 * Default status slug for new requests.
 *
 * @return string
 */
function mm_jewelry_request_default_status(): string {
	return MM_JEWELRY_REQUEST_DEFAULT_STATUS;
}

/**
 * Whether a status slug is valid.
 *
 * @param string $status Status slug.
 * @return bool
 */
function mm_jewelry_request_is_valid_status( string $status ): bool {
	return array_key_exists( $status, mm_jewelry_request_statuses() );
}

/**
 * Human-readable label for a status slug.
 *
 * @param string $status Status slug.
 * @return string
 */
function mm_jewelry_request_status_label( string $status ): string {
	$statuses = mm_jewelry_request_statuses();

	return $statuses[ $status ] ?? $status;
}

/**
 * Get the workflow status for a request.
 *
 * @param int $post_id Request post ID.
 * @return string
 */
function mm_jewelry_request_get_status( int $post_id ): string {
	$status = mm_jewelry_request_get_meta( $post_id, 'status' );

	if ( '' === $status ) {
		return mm_jewelry_request_default_status();
	}

	return mm_jewelry_request_is_valid_status( $status ) ? $status : mm_jewelry_request_default_status();
}

/**
 * Update the workflow status for a request.
 *
 * @param int    $post_id Request post ID.
 * @param string $status  Status slug.
 * @return bool
 */
function mm_jewelry_request_set_status( int $post_id, string $status ): bool {
	if ( ! mm_jewelry_request_is_valid_status( $status ) ) {
		return false;
	}

	$old_status = mm_jewelry_request_get_status( $post_id );

	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'status', $status );

	mm_jewelry_request_fire_status_changed( $post_id, $old_status, $status );

	return true;
}

/**
 * Piece type options from taxonomy (slug => label).
 *
 * @return array<string, string>
 */
function mm_jewelry_request_order_types(): array {
	return mm_jewelry_request_taxonomy_options( MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY, 'mm_jewelry_request_default_order_types' );
}

/**
 * Budget range options from taxonomy (slug => label).
 *
 * @return array<string, string>
 */
function mm_jewelry_request_budget_ranges(): array {
	return mm_jewelry_request_taxonomy_options( MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY, 'mm_jewelry_request_default_budget_ranges' );
}

/**
 * Build slug => label map from a taxonomy.
 *
 * @param string $taxonomy       Taxonomy slug.
 * @param string $fallback_callback Callable returning fallback options.
 * @return array<string, string>
 */
function mm_jewelry_request_taxonomy_options( string $taxonomy, string $fallback_callback ): array {
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return call_user_func( $fallback_callback );
	}

	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return call_user_func( $fallback_callback );
	}

	$options = array();

	foreach ( $terms as $term ) {
		if ( $term instanceof WP_Term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return ! empty( $options ) ? $options : call_user_func( $fallback_callback );
}

/**
 * Get a piece type term by slug.
 *
 * @param string $slug Term slug.
 * @return WP_Term|null
 */
function mm_jewelry_request_get_piece_type_term( string $slug ): ?WP_Term {
	$term = get_term_by( 'slug', $slug, MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY );

	return $term instanceof WP_Term ? $term : null;
}

/**
 * Get a budget range term by slug.
 *
 * @param string $slug Term slug.
 * @return WP_Term|null
 */
function mm_jewelry_request_get_budget_range_term( string $slug ): ?WP_Term {
	$term = get_term_by( 'slug', $slug, MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY );

	return $term instanceof WP_Term ? $term : null;
}

/**
 * Assign a piece type to a request by slug.
 *
 * @param int    $post_id Request post ID.
 * @param string $slug    Piece type slug.
 * @return bool
 */
function mm_jewelry_request_assign_piece_type( int $post_id, string $slug ): bool {
	$term = mm_jewelry_request_get_piece_type_term( $slug );

	if ( ! $term ) {
		return false;
	}

	$result = wp_set_object_terms( $post_id, (int) $term->term_id, MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY, false );

	return ! is_wp_error( $result );
}

/**
 * Assign a budget range to a request by slug.
 *
 * @param int    $post_id Request post ID.
 * @param string $slug    Budget range slug.
 * @return bool
 */
function mm_jewelry_request_assign_budget_range( int $post_id, string $slug ): bool {
	$term = mm_jewelry_request_get_budget_range_term( $slug );

	if ( ! $term ) {
		return false;
	}

	$result = wp_set_object_terms( $post_id, (int) $term->term_id, MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY, false );

	return ! is_wp_error( $result );
}

/**
 * Get the piece type slug for a request.
 *
 * @param int $post_id Request post ID.
 * @return string
 */
function mm_jewelry_request_get_piece_type_slug( int $post_id ): string {
	$slug = mm_jewelry_request_get_object_term_slug( $post_id, MM_JEWELRY_REQUEST_PIECE_TYPE_TAXONOMY );

	if ( '' !== $slug ) {
		return $slug;
	}

	return mm_jewelry_request_get_meta( $post_id, 'order_type' );
}

/**
 * Get the budget range slug for a request.
 *
 * @param int $post_id Request post ID.
 * @return string
 */
function mm_jewelry_request_get_budget_slug( int $post_id ): string {
	$slug = mm_jewelry_request_get_object_term_slug( $post_id, MM_JEWELRY_REQUEST_BUDGET_RANGE_TAXONOMY );

	if ( '' !== $slug ) {
		return $slug;
	}

	return mm_jewelry_request_get_meta( $post_id, 'budget' );
}

/**
 * Get the first assigned term slug for a post and taxonomy.
 *
 * @param int    $post_id  Request post ID.
 * @param string $taxonomy Taxonomy slug.
 * @return string
 */
function mm_jewelry_request_get_object_term_slug( int $post_id, string $taxonomy ): string {
	if ( ! taxonomy_exists( $taxonomy ) ) {
		return '';
	}

	$terms = wp_get_object_terms(
		$post_id,
		$taxonomy,
		array(
			'fields' => 'slugs',
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return '';
	}

	return (string) $terms[0];
}

/**
 * Label for a piece type slug.
 *
 * @param string $slug Piece type slug.
 * @return string
 */
function mm_jewelry_request_order_type_label( string $slug ): string {
	if ( '' === $slug ) {
		return '';
	}

	$term = mm_jewelry_request_get_piece_type_term( $slug );

	if ( $term ) {
		return $term->name;
	}

	$types = mm_jewelry_request_default_order_types();

	return $types[ $slug ] ?? $slug;
}

/**
 * Label for a budget range slug.
 *
 * @param string $slug Budget range slug.
 * @return string
 */
function mm_jewelry_request_budget_label( string $slug ): string {
	if ( '' === $slug ) {
		return '';
	}

	$term = mm_jewelry_request_get_budget_range_term( $slug );

	if ( $term ) {
		return $term->name;
	}

	$ranges = mm_jewelry_request_default_budget_ranges();

	return $ranges[ $slug ] ?? $slug;
}

/**
 * Allowed reference image MIME types.
 *
 * @return string[]
 */
function mm_jewelry_request_allowed_mimes(): array {
	return array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
		'webp'         => 'image/webp',
	);
}

/**
 * Max reference upload size in bytes (5 MB).
 */
function mm_jewelry_request_max_upload_bytes(): int {
	return 5 * MB_IN_BYTES;
}

/**
 * Max number of reference images per submission.
 */
function mm_jewelry_request_max_reference_count(): int {
	return 5;
}

/**
 * Validate an optional email address.
 *
 * @param string $email Email address.
 * @return bool
 */
function mm_jewelry_request_validate_email( string $email ): bool {
	if ( '' === $email ) {
		return true;
	}

	return (bool) is_email( $email );
}

/**
 * Get reference attachment IDs for a request.
 *
 * Always returns a normalized int array. Never false, null, or non-array values.
 *
 * @param int $request_id Request post ID.
 * @return int[]
 */
function mm_jewelry_request_get_reference_ids( int $request_id ): array {
	$raw = get_post_meta( $request_id, MM_JEWELRY_REQUEST_META_PREFIX . 'reference_ids', true );
	$ids = array();

	if ( is_array( $raw ) ) {
		foreach ( $raw as $attachment_id ) {
			$attachment_id = (int) $attachment_id;

			if ( $attachment_id > 0 ) {
				$ids[] = $attachment_id;
			}
		}
	}

	if ( ! empty( $ids ) ) {
		return array_values( array_unique( $ids ) );
	}

	$legacy_id = (int) get_post_meta( $request_id, MM_JEWELRY_REQUEST_META_PREFIX . 'reference_id', true );

	if ( $legacy_id > 0 ) {
		return array( $legacy_id );
	}

	return array();
}

/**
 * Store reference attachment IDs for a request.
 *
 * @param int   $request_id     Request post ID.
 * @param int[] $attachment_ids Attachment IDs.
 */
function mm_jewelry_request_set_reference_ids( int $request_id, array $attachment_ids ): void {
	$normalized = array();

	foreach ( $attachment_ids as $attachment_id ) {
		$attachment_id = (int) $attachment_id;

		if ( $attachment_id > 0 ) {
			$normalized[] = $attachment_id;
		}
	}

	$normalized = array_values( array_unique( $normalized ) );

	update_post_meta( $request_id, MM_JEWELRY_REQUEST_META_PREFIX . 'reference_ids', $normalized );

	if ( ! empty( $normalized ) ) {
		update_post_meta( $request_id, MM_JEWELRY_REQUEST_META_PREFIX . 'reference_id', (int) $normalized[0] );
	}
}

/**
 * Get a sanitized meta value for a request post.
 *
 * @param int    $post_id Request post ID.
 * @param string $key     Meta key without prefix.
 * @return string
 */
function mm_jewelry_request_get_meta( int $post_id, string $key ): string {
	$value = get_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . $key, true );

	return is_string( $value ) ? $value : '';
}

/**
 * Update a sanitized meta value for a request post.
 *
 * @param int    $post_id Request post ID.
 * @param string $key     Meta key without prefix.
 * @param string $value   Meta value.
 */
function mm_jewelry_request_update_meta( int $post_id, string $key, string $value ): void {
	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . $key, $value );
}

/**
 * Build a safe redirect URL back to the form section.
 *
 * @param string $status  success|error
 * @param string $message Optional error code.
 * @return string
 */
function mm_jewelry_request_redirect_url( string $status, string $message = '' ): string {
	$args = array(
		'mm_request' => $status,
	);

	if ( '' !== $message ) {
		$args['mm_error'] = $message;
	}

	$url = add_query_arg( $args, home_url( '/' ) );

	return $url . '#request';
}
