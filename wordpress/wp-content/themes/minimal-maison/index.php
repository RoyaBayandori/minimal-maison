<?php
/**
 * Minimal Maison theme placeholder.
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
<body <?php body_class(); ?>>
	<main id="primary" class="site-main">
		<p><?php esc_html_e( 'Minimal Maison theme — development in progress.', 'minimal-maison' ); ?></p>
	</main>
	<?php wp_footer(); ?>
</body>
</html>
