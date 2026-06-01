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
 * Order type options.
 *
 * @return array<string, string>
 */
function mm_jewelry_request_order_types(): array {
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
 * Approximate budget options.
 *
 * @return array<string, string>
 */
function mm_jewelry_request_budget_ranges(): array {
	return array(
		'under_50'   => __( 'تا حدود ۵۰ میلیون تومان', 'minimal-maison' ),
		'50_100'     => __( '۵۰ تا ۱۰۰ میلیون تومان', 'minimal-maison' ),
		'100_200'    => __( '۱۰۰ تا ۲۰۰ میلیون تومان', 'minimal-maison' ),
		'200_500'    => __( '۲۰۰ تا ۵۰۰ میلیون تومان', 'minimal-maison' ),
		'over_500'   => __( 'بیش از ۵۰۰ میلیون تومان', 'minimal-maison' ),
		'undecided'  => __( 'هنوز درباره بودجه مطمئن نیستم', 'minimal-maison' ),
	);
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
 * Label for an order type slug.
 *
 * @param string $slug Order type slug.
 * @return string
 */
function mm_jewelry_request_order_type_label( string $slug ): string {
	$types = mm_jewelry_request_order_types();

	return $types[ $slug ] ?? $slug;
}

/**
 * Label for a budget slug.
 *
 * @param string $slug Budget slug.
 * @return string
 */
function mm_jewelry_request_budget_label( string $slug ): string {
	$ranges = mm_jewelry_request_budget_ranges();

	return $ranges[ $slug ] ?? $slug;
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
