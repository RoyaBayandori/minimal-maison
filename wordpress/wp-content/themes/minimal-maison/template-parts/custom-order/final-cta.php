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

if ( empty( $heading_lines ) ) {
	$heading_lines = array( trim( mm_co_option( 'co_final_cta_heading' ) ) );
}
?>
<section class="mm-custom-order-final-cta" aria-labelledby="mm-custom-order-final-cta-heading">
	<div class="mm-custom-order-final-cta__frame mm-container">
		<div class="mm-custom-order-final-cta__content mm-editorial" dir="rtl">
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
				<a class="mm-button-outline mm-custom-order-final-cta__button" href="<?php echo esc_url( $button_url ); ?>">
					<?php echo esc_html( $button_label ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
