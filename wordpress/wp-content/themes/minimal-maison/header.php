<?php
/**
 * Header template.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'mm-body min-h-screen flex flex-col' ); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/header/site', 'header' ); ?>
