<?php
/**
 * Template Name: Portfolio / Gallery
 * Template Post Type: page
 *
 * Portfolio / Gallery page.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main mm-portfolio-page">
	<?php
	get_template_part( 'template-parts/portfolio/hero' );
	get_template_part( 'template-parts/portfolio/gallery' );
	get_template_part( 'template-parts/portfolio/about', 'atelier' );
	get_template_part( 'template-parts/portfolio/final', 'cta' );
	?>
</main>

<?php
get_footer();
