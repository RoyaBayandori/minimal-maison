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
require MM_THEME_DIR . '/inc/header-nav.php';
require MM_THEME_DIR . '/inc/contact.php';
require MM_THEME_DIR . '/inc/assets.php';
require MM_THEME_DIR . '/inc/home-images.php';
require MM_THEME_DIR . '/inc/cpt/creations.php';
require MM_THEME_DIR . '/inc/cpt/testimonials.php';
require MM_THEME_DIR . '/inc/acf.php';
require MM_THEME_DIR . '/inc/woocommerce.php';
require MM_THEME_DIR . '/inc/jewelry-requests.php';
