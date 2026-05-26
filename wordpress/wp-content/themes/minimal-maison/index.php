<?php
/**
 * Main template fallback.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main flex-1 mx-auto max-w-3xl px-6 py-16">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
		<?php endwhile; ?>

		<nav class="mt-12 text-sm text-neutral-500" aria-label="<?php esc_attr_e( 'Posts navigation', 'minimal-maison' ); ?>">
			<?php the_posts_navigation(); ?>
		</nav>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</main>

<?php
get_footer();
