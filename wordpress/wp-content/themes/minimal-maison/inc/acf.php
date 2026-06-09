<?php
/**
 * ACF integration bootstrap.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/json.php';
require MM_THEME_DIR . '/inc/acf/options-content.php';
require MM_THEME_DIR . '/inc/acf/footer-content.php';
require MM_THEME_DIR . '/inc/acf/front-page-setup.php';
require MM_THEME_DIR . '/inc/acf/home-content.php';
require MM_THEME_DIR . '/inc/acf/field-groups.php';

/**
 * Ensure ACF is active; show admin notice if missing.
 */
function mm_acf_admin_notice(): void {
	if ( mm_acf_available() || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'Minimal Maison: Advanced Custom Fields is required for homepage content management.', 'minimal-maison' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'mm_acf_admin_notice' );

/**
 * Activate ACF on theme setup when bundled in wp-content/plugins.
 */
function mm_acf_maybe_activate_plugin(): void {
	if ( mm_acf_available() ) {
		return;
	}

	$plugin = 'advanced-custom-fields/acf.php';

	if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
		return;
	}

	if ( is_admin() && current_user_can( 'activate_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		if ( ! is_plugin_active( $plugin ) ) {
			activate_plugin( $plugin );
		}
	}
}
add_action( 'after_setup_theme', 'mm_acf_maybe_activate_plugin', 20 );
