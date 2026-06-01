<?php
/**
 * ACF Local JSON — save/load paths for version-controlled field groups.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Directory for ACF JSON field group files.
 */
function mm_acf_json_path(): string {
	return MM_THEME_DIR . '/acf-json';
}

/**
 * Point ACF Local JSON saves to the theme acf-json directory.
 *
 * @param string $path Default save path.
 * @return string
 */
function mm_acf_json_save_path( string $path ): string {
	return mm_acf_json_path();
}
add_filter( 'acf/settings/save_json', 'mm_acf_json_save_path' );

/**
 * Load ACF field groups from the theme acf-json directory.
 *
 * @param string[] $paths Load paths.
 * @return string[]
 */
function mm_acf_json_load_paths( array $paths ): array {
	$paths[] = mm_acf_json_path();

	return $paths;
}
add_filter( 'acf/settings/load_json', 'mm_acf_json_load_paths' );
