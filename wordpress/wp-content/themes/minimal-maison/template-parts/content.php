<?php
/**
 * Default post content.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-16' ); ?>>
	<header class="mb-6">
		<h2 class="text-2xl font-light tracking-tight text-neutral-900">
			<a href="<?php the_permalink(); ?>" class="hover:opacity-70">
				<?php the_title(); ?>
			</a>
		</h2>
		<time class="text-sm text-neutral-500" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	</header>

	<div class="prose prose-neutral max-w-none text-neutral-700 leading-relaxed">
		<?php the_excerpt(); ?>
	</div>
</article>
