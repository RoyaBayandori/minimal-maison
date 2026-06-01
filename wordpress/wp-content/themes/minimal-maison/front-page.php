<?php
/**
 * Front page — luxury bespoke jewelry maison.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<?php get_template_part( 'template-parts/home/hero', 'cinematic' ); ?>

	<?php
	get_template_part( 'template-parts/home/selected', 'creations' );

	get_template_part( 'template-parts/home/maison', 'note' );

	get_template_part( 'template-parts/home/bespoke', 'process' );

	// Homepage simplification review — temporarily disabled (templates preserved).
	// get_template_part( 'template-parts/home/stories' );
	// get_template_part( 'template-parts/home/about', 'house' );

	get_template_part( 'template-parts/home/request', 'piece' );
	?>
</main>

<?php
get_footer();
