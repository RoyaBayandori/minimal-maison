<?php
/**
 * Custom Order — Final CTA section.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_co_should_show_final_cta() ) {
	return;
}

$heading_lines = mm_co_textarea_lines( 'co_final_cta_heading' );
$description   = trim( mm_co_option( 'co_final_cta_description' ) );
$button_label  = trim( mm_co_option( 'co_final_cta_button_label' ) );
$button_url    = mm_co_url( 'co_final_cta_button_url' );
$image_id      = mm_co_image_id( 'co_final_cta_image' );
$has_image     = $image_id > 0;

if ( empty( $heading_lines ) ) {
	$heading_lines = array( trim( mm_co_option( 'co_final_cta_heading' ) ) );
}

$split_classes = 'mm-custom-order-final-cta__split';

if ( ! $has_image ) {
	$split_classes .= ' mm-custom-order-final-cta__split--no-image';
}
?>
<section class="mm-custom-order-final-cta" aria-labelledby="mm-custom-order-final-cta-heading">
	<div class="<?php echo esc_attr( $split_classes ); ?>">
		<?php if ( $has_image ) : ?>
			<figure class="mm-custom-order-final-cta__media">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					array(
						'class'    => 'mm-custom-order-final-cta__image',
						'loading'  => 'lazy',
						'decoding' => 'async',
						'sizes'    => '(min-width: 1200px) 50vw, 100vw',
					)
				);
				?>
			</figure>
		<?php endif; ?>

		<div class="mm-custom-order-final-cta__panel mm-editorial" dir="rtl">
			<div class="mm-custom-order-final-cta__content">
				<h2 id="mm-custom-order-final-cta-heading" class="mm-custom-order-final-cta__heading">
					<?php foreach ( $heading_lines as $line ) : ?>
						<?php if ( '' !== $line ) : ?>
							<span class="mm-custom-order-final-cta__heading-line"><?php echo esc_html( $line ); ?></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</h2>

				<?php if ( '' !== $description ) : ?>
					<p class="mm-custom-order-final-cta__description">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>

				<div class="mm-custom-order-final-cta__actions">
					<a class="mm-custom-order-final-cta__button" href="<?php echo esc_url( $button_url ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
