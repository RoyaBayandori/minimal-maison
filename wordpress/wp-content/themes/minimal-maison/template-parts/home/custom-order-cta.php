<?php
/**
 * Homepage — Custom Order CTA teaser.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_should_show_custom_order_cta() ) {
	return;
}

$title_lines = mm_home_custom_order_cta_title_lines();
$description = trim( (string) mm_home_acf_value( 'cta_description' ) );
$button_text = trim( (string) mm_home_acf_value( 'cta_button_text' ) );
$button_url  = mm_home_acf_url( 'cta_button_url' );
$image_id    = mm_home_option_image_id( 'cta_image' );
$has_image   = $image_id > 0;

$split_classes = 'mm-custom-order-cta__split';

if ( ! $has_image ) {
	$split_classes .= ' mm-custom-order-cta__split--no-image';
}

?>
<section
	id="request"
	class="mm-custom-order-cta"
	aria-labelledby="custom-order-cta-heading"
>
	<div class="mm-custom-order-cta__frame">
		<div class="<?php echo esc_attr( $split_classes ); ?>">
			<?php if ( $has_image ) : ?>
				<figure class="mm-custom-order-cta__media">
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						array(
							'class'    => 'mm-custom-order-cta__image',
							'loading'  => 'lazy',
							'decoding' => 'async',
							'sizes'    => '(min-width: 768px) 43rem, 100vw',
						)
					);
					?>
				</figure>
			<?php endif; ?>

			<div class="mm-custom-order-cta__panel mm-editorial" dir="rtl">
				<h2 id="custom-order-cta-heading" class="mm-custom-order-cta__title">
					<?php foreach ( $title_lines as $line ) : ?>
						<span class="mm-custom-order-cta__title-line"><?php echo esc_html( $line ); ?></span>
					<?php endforeach; ?>
				</h2>

				<?php if ( '' !== $description ) : ?>
					<p class="mm-custom-order-cta__description">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>

				<div class="mm-custom-order-cta__actions">
					<a class="mm-button-outline mm-custom-order-cta__button" href="<?php echo esc_url( $button_url ); ?>">
						<?php echo esc_html( $button_text ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
