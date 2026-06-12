<?php
/**
 * Portfolio — Final CTA section (consultation conversion).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_pf_should_show_final_cta() ) {
	return;
}

$heading_lines = mm_pf_textarea_lines( 'pf_final_cta_heading' );
$description   = trim( mm_pf_option( 'pf_final_cta_description' ) );
$button_label  = trim( mm_pf_option( 'pf_final_cta_button_label' ) );
$button_url    = mm_pf_url( 'pf_final_cta_button_url' );
$image_id      = mm_pf_image_id( 'pf_final_cta_image' );
$has_image     = $image_id > 0;

if ( empty( $heading_lines ) ) {
	$heading_lines = array( trim( mm_pf_option( 'pf_final_cta_heading' ) ) );
}

$split_classes = 'mm-portfolio-final-cta__split';

if ( ! $has_image ) {
	$split_classes .= ' mm-portfolio-final-cta__split--no-image';
}
?>
<section class="mm-portfolio-final-cta" aria-labelledby="mm-portfolio-final-cta-heading">
	<div class="<?php echo esc_attr( $split_classes ); ?>">
		<?php if ( $has_image ) : ?>
			<figure class="mm-portfolio-final-cta__media">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					array(
						'class'    => 'mm-portfolio-final-cta__image',
						'loading'  => 'lazy',
						'decoding' => 'async',
						'sizes'    => '(min-width: 1200px) 50vw, 100vw',
					)
				);
				?>
			</figure>
		<?php endif; ?>

		<div class="mm-portfolio-final-cta__panel mm-editorial" dir="rtl">
			<div class="mm-portfolio-final-cta__content">
				<h2 id="mm-portfolio-final-cta-heading" class="mm-portfolio-final-cta__heading">
					<?php foreach ( $heading_lines as $line ) : ?>
						<?php if ( '' !== $line ) : ?>
							<span class="mm-portfolio-final-cta__heading-line"><?php echo esc_html( $line ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</h2>

				<?php if ( '' !== $description ) : ?>
					<p class="mm-portfolio-final-cta__description">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>

				<div class="mm-portfolio-final-cta__actions">
					<a class="mm-portfolio-final-cta__button" href="<?php echo esc_url( $button_url ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
