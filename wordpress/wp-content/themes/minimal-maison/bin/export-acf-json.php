<?php
/**
 * Export local ACF field groups to acf-json (run once via WP-CLI).
 *
 * Usage: wp eval-file wp-content/themes/minimal-maison/bin/export-acf-json.php
 *
 * @package Minimal_Maison
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 1 );
}

if ( ! function_exists( 'acf_get_local_field_groups' ) ) {
	WP_CLI::error( 'ACF is not active.' );
}

$json_path = mm_acf_json_path();

if ( ! is_dir( $json_path ) && ! wp_mkdir_p( $json_path ) ) {
	WP_CLI::error( 'Could not create acf-json directory.' );
}

mm_acf_register_field_groups();

$groups = acf_get_local_field_groups();

if ( empty( $groups ) ) {
	WP_CLI::warning( 'No local field groups registered. JSON files may already exist.' );
}

foreach ( $groups as $group ) {
	$key    = $group['key'];
	$fields = acf_get_fields( $group );
	$export = $group;

	if ( is_array( $fields ) ) {
		$export['fields'] = $fields;
	}

	unset( $export['ID'], $export['local'], $export['local_file'] );

	$file = $json_path . '/' . $key . '.json';
	$json = wp_json_encode( $export, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );

	if ( false === $json ) {
		WP_CLI::warning( "Failed to encode {$key}." );
		continue;
	}

	file_put_contents( $file, $json . "\n" );
	WP_CLI::log( "Wrote {$file}" );
}

WP_CLI::success( 'ACF field groups exported to acf-json.' );
