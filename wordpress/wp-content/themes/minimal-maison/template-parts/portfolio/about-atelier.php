<?php
/**
 * Portfolio — About Atelier Minimal section.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_pf_should_show_about() ) {
	return;
}

$paragraphs = mm_pf_about_paragraphs();
$image_id   = mm_pf_image_id( 'pf_about_image' );
$cta_label  = trim( mm_pf_option( 'pf_about_cta_label' ) );
$cta_url    = mm_pf_url( 'pf_about_cta_url' );
?>
<section class="mm-portfolio-about" aria-labelledby="mm-portfolio-about-heading">
	<div class="mm-container">
		<div class="mm-portfolio-about__grid">
			<?php if ( $image_id > 0 ) : ?>
				<div class="mm-portfolio-about__media mm-editorial-frame">
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						array(
							'class'    => 'mm-portfolio-about__image',
							'loading'  => 'lazy',
							'decoding' => 'async',
							'sizes'    => '(min-width: 1200px) 42vw, 100vw',
						)
					);
					?>
				</div>
			<?php endif; ?>

			<div class="mm-portfolio-about__content mm-editorial" dir="rtl">
				<p class="mm-portfolio-about__eyebrow"><?php mm_pf_text( 'pf_about_eyebrow' ); ?></p>
				<h2 id="mm-portfolio-about-heading" class="mm-portfolio-about__heading">
					<?php mm_pf_text( 'pf_about_heading' ); ?>
				</h2>

				<div class="mm-portfolio-about__body">
					<?php foreach ( $paragraphs as $paragraph ) : ?>
						<p><?php echo esc_html( $paragraph ); ?></p>
					<?php endforeach; ?>
				</div>

				<?php if ( '' !== $cta_label ) : ?>
					<div class="mm-portfolio-about__actions">
						<a class="mm-button-outline" href="<?php echo esc_url( $cta_url ); ?>">
							<?php echo esc_html( $cta_label ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
