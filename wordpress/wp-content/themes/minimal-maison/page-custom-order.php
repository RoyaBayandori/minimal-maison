<?php
/**
 * Template Name: Custom Order
 * Template Post Type: page
 *
 * Custom Order landing page.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main mm-custom-order-page">
	<?php
	get_template_part( 'template-parts/custom-order/hero' );
	get_template_part( 'template-parts/custom-order/benefits' );
	get_template_part( 'template-parts/custom-order/form', 'section' );
	get_template_part( 'template-parts/custom-order/faq' );
	get_template_part( 'template-parts/custom-order/final', 'cta' );
	?>
</main>

<?php
get_footer();
