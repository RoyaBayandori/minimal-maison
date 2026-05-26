<?php
/**
 * Minimal Maison — theme bootstrap.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

define( 'MM_THEME_VERSION', '1.0.0' );
define( 'MM_THEME_DIR', get_template_directory() );
define( 'MM_THEME_URI', get_template_directory_uri() );

require MM_THEME_DIR . '/inc/setup.php';
require MM_THEME_DIR . '/inc/assets.php';
require MM_THEME_DIR . '/inc/woocommerce.php';
