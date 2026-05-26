<?php
/**
 * Minimal Maison — application-layer hardening (mu-plugin).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

// XML-RPC (nginx also blocks /xmlrpc.php — defense in depth).
add_filter( 'xmlrpc_enabled', '__return_false' );

add_filter(
	'wp_headers',
	static function ( array $headers ): array {
		unset( $headers['X-Pingback'] );
		return $headers;
	}
);
