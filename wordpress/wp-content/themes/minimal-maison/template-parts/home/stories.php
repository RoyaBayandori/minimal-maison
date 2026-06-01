<?php
/**
 * Homepage — Crafted For Real Stories.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$stories = mm_home_testimonials();
?>
<section class="mm-section">
	<div class="mm-container">
		<div class="mm-section-header">
			<p class="mm-subheading mb-4"><?php mm_home_text( 'testimonials_eyebrow' ); ?></p>
			<h2 class="text-display-sm md:text-display-md mb-5">
				<?php mm_home_text( 'testimonials_heading' ); ?>
			</h2>
			<p class="mx-auto max-w-copy text-sm md:text-base">
				<?php mm_home_text( 'testimonials_description' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 gap-8 md:grid-cols-3">
			<?php foreach ( $stories as $story ) : ?>
				<blockquote class="mm-story-card">
					<p class="text-base md:text-lg text-ink-800 leading-relaxed mb-6">
						<?php echo esc_html( $story['quote'] ); ?>
					</p>
					<footer class="mm-subheading text-neutral-500">
						<?php echo esc_html( $story['author'] ); ?>
					</footer>
				</blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>
