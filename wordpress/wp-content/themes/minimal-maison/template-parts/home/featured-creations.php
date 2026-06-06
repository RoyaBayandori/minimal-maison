<?php
/**
 * Homepage — Featured Creations collection.
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
$has_cta     = mm_featured_creations_has_cta();
$rail_label  = '' !== $title ? $title : __( 'Featured creations', 'minimal-maison' );

?>
<section
	id="creations"
	class="mm-featured-creations"
	<?php echo '' !== $title ? 'aria-labelledby="featured-creations-heading"' : ''; ?>
>
	<div class="mm-featured-creations__frame">
		<?php if ( '' !== $title || '' !== $description ) : ?>
			<header class="mm-featured-creations__header">
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

		<div class="mm-featured-creations__strip">
			<div
				class="mm-featured-creations__rail"
				tabindex="0"
				role="region"
				aria-label="<?php echo esc_attr( $rail_label ); ?>"
			>
				<div class="mm-featured-creations__gallery">
					<?php foreach ( $creations as $index => $creation ) : ?>
						<?php
						mm_render_featured_creation_piece(
							$creation,
							$index,
							'(min-width: 1200px) 11rem, (min-width: 768px) 33vw, 44vw'
						);
						?>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if ( $has_cta ) : ?>
				<div class="mm-featured-creations__actions">
					<a
						class="mm-featured-creations__cta"
						href="<?php echo esc_url( mm_home_acf_url( 'featured_creations_cta_url' ) ); ?>"
					>
						<?php echo esc_html( mm_featured_creations_cta_label() ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
