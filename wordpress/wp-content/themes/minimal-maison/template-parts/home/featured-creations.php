<?php
/**
 * Homepage — Featured Creations editorial gallery.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$creations = mm_home_featured_creations();

if ( empty( $creations ) ) {
	return;
}

$title       = trim( (string) mm_home_acf_value( 'featured_creations_title' ) );
$description = trim( (string) mm_home_acf_value( 'featured_creations_description' ) );

?>
<section
	id="creations"
	class="mm-featured-creations"
	<?php echo '' !== $title ? 'aria-labelledby="featured-creations-heading"' : ''; ?>
>
	<div class="mm-featured-creations__frame">
		<?php if ( '' !== $title || '' !== $description ) : ?>
			<header class="mm-featured-creations__header mm-editorial">
				<?php if ( '' !== $title ) : ?>
					<h2 id="featured-creations-heading" class="mm-featured-creations__heading">
						<?php echo esc_html( $title ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( '' !== $description ) : ?>
					<p class="mm-featured-creations__intro">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<div class="mm-featured-creations__gallery">
			<?php foreach ( $creations as $index => $creation ) : ?>
				<article class="mm-featured-creations__piece">
					<div class="mm-featured-creations__media">
						<?php
						echo wp_get_attachment_image(
							(int) $creation['image_id'],
							'full',
							false,
							array(
								'class'   => 'mm-featured-creations__image',
								'loading' => 0 === $index ? 'eager' : 'lazy',
								'sizes'   => '(min-width: 1280px) 30vw, (min-width: 1024px) 31vw, 100vw',
								'alt'     => $creation['title'],
							)
						);
						?>
					</div>

					<?php if ( ! empty( $creation['title'] ) ) : ?>
						<h3 class="mm-featured-creations__title"><?php echo esc_html( $creation['title'] ); ?></h3>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
