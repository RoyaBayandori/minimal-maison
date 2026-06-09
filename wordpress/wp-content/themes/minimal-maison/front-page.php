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
	get_template_part( 'template-parts/home/brand', 'philosophy' );

	get_template_part( 'template-parts/home/craft', 'process' );

	get_template_part( 'template-parts/home/featured', 'creations' );

	// REVIEW: Homepage cutoff — restore sections below after Featured Creations review.
	// Homepage narrative rebuild — legacy portfolio grid removed (template preserved).
	// get_template_part( 'template-parts/home/selected', 'creations' );

	// get_template_part( 'template-parts/home/maison', 'note' );

	// Legacy process layout — replaced by craft-process timeline (template preserved).
	// get_template_part( 'template-parts/home/bespoke', 'process' );

	// if ( mm_should_show_customer_quote() ) {
	// 	get_template_part( 'template-parts/home/customer', 'quote' );
	// }

	// Homepage simplification review — temporarily disabled (templates preserved).
	// get_template_part( 'template-parts/home/stories' );
	// get_template_part( 'template-parts/home/about', 'house' );

	get_template_part( 'template-parts/home/custom', 'order-cta' );
	?>
</main>

<?php
get_footer();
