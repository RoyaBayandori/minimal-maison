<?php
/**
 * Minimal Maison — additional wp-config.php settings
 * Loaded via WORDPRESS_CONFIG_EXTRA in docker-compose.yml
 *
 * @package Minimal_Maison
 */

// Never expose PHP errors to visitors unless debug display is explicitly enabled below.
@ini_set( 'display_errors', '0' );

// Debug mode — controlled only via environment variables
$mm_debug = filter_var( getenv( 'WORDPRESS_DEBUG' ) ?: 'false', FILTER_VALIDATE_BOOLEAN );
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', $mm_debug );
}
if ( ! defined( 'WP_DEBUG_LOG' ) ) {
	define( 'WP_DEBUG_LOG', filter_var( getenv( 'WORDPRESS_DEBUG_LOG' ) ?: 'false', FILTER_VALIDATE_BOOLEAN ) );
}
if ( ! defined( 'WP_DEBUG_DISPLAY' ) ) {
	define( 'WP_DEBUG_DISPLAY', filter_var( getenv( 'WORDPRESS_DEBUG_DISPLAY' ) ?: 'false', FILTER_VALIDATE_BOOLEAN ) );
}
if ( WP_DEBUG && WP_DEBUG_DISPLAY ) {
	@ini_set( 'display_errors', '1' );
}

// Environment type: local | development | staging | production
if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
	define( 'WP_ENVIRONMENT_TYPE', getenv( 'WP_ENVIRONMENT_TYPE' ) ?: 'local' );
}

// Site URL (set in .env after install or when using a custom port/domain)
if ( getenv( 'WP_HOME' ) && ! defined( 'WP_HOME' ) ) {
	define( 'WP_HOME', getenv( 'WP_HOME' ) );
}
if ( getenv( 'WP_SITEURL' ) && ! defined( 'WP_SITEURL' ) ) {
	define( 'WP_SITEURL', getenv( 'WP_SITEURL' ) );
}

// Persian (RTL) — set locale; install fa_IR language pack via WP-CLI or admin
if ( ! defined( 'WPLANG' ) && getenv( 'WORDPRESS_LOCALE' ) ) {
	define( 'WPLANG', getenv( 'WORDPRESS_LOCALE' ) );
}

// Redis object cache (requires Redis Object Cache plugin)
if ( ! defined( 'WP_REDIS_HOST' ) ) {
	define( 'WP_REDIS_HOST', getenv( 'WP_REDIS_HOST' ) ?: 'redis' );
}
if ( ! defined( 'WP_REDIS_PORT' ) ) {
	define( 'WP_REDIS_PORT', (int) ( getenv( 'WP_REDIS_PORT' ) ?: 6379 ) );
}
$redis_password = getenv( 'WP_REDIS_PASSWORD' ) ?: getenv( 'REDIS_PASSWORD' );
if ( $redis_password && ! defined( 'WP_REDIS_PASSWORD' ) ) {
	define( 'WP_REDIS_PASSWORD', $redis_password );
}
if ( ! defined( 'WP_CACHE_KEY_SALT' ) ) {
	define( 'WP_CACHE_KEY_SALT', getenv( 'WP_CACHE_KEY_SALT' ) ?: 'minimal-maison:' );
}

// WooCommerce-ready: memory, SSL behind proxy, cron
if ( ! defined( 'WP_MEMORY_LIMIT' ) ) {
	define( 'WP_MEMORY_LIMIT', getenv( 'WP_MEMORY_LIMIT' ) ?: '256M' );
}
if ( ! defined( 'WP_MAX_MEMORY_LIMIT' ) ) {
	define( 'WP_MAX_MEMORY_LIMIT', getenv( 'WP_MAX_MEMORY_LIMIT' ) ?: '512M' );
}

// MailHog (SMTP) — use with WP Mail SMTP or similar plugin in development
if ( ! defined( 'MM_SMTP_HOST' ) ) {
	define( 'MM_SMTP_HOST', getenv( 'MM_SMTP_HOST' ) ?: 'mailhog' );
}
if ( ! defined( 'MM_SMTP_PORT' ) ) {
	define( 'MM_SMTP_PORT', (int) ( getenv( 'MM_SMTP_PORT' ) ?: 1025 ) );
}

// Disable file editing in admin (recommended for production)
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', filter_var( getenv( 'DISALLOW_FILE_EDIT' ) ?: 'true', FILTER_VALIDATE_BOOLEAN ) );
}

// Force SSL admin when behind TLS terminator (set in production)
if ( filter_var( getenv( 'FORCE_SSL_ADMIN' ) ?: 'false', FILTER_VALIDATE_BOOLEAN ) ) {
	if ( ! defined( 'FORCE_SSL_ADMIN' ) ) {
		define( 'FORCE_SSL_ADMIN', true );
	}
}

// Reverse proxy / HTTPS detection (nginx, load balancers)
if (
	( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] )
	|| ( isset( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && 'on' === $_SERVER['HTTP_X_FORWARDED_SSL'] )
) {
	$_SERVER['HTTPS'] = 'on';
}

// Automatic updates — disable on local by default
if ( ! defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
	define( 'AUTOMATIC_UPDATER_DISABLED', 'local' === WP_ENVIRONMENT_TYPE );
}
