<?php
/**
 * Custom Order — Hero section.
 *
 * Visual system mirrors template-parts/home/hero-cinematic.php.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_co_should_show_hero() ) {
	return;
}

$heading      = trim( mm_co_option( 'co_hero_heading' ) );
$description  = trim( mm_co_option( 'co_hero_description' ) );
$eyebrow      = trim( mm_co_option( 'co_hero_eyebrow' ) );
$cta_label    = trim( mm_co_option( 'co_hero_cta_label' ) );
$cta_url      = mm_co_url( 'co_hero_cta_url' );
$image_markup = mm_co_render_image( 'co_hero_image' );
$has_image    = '' !== $image_markup;
?>
<section
	class="mm-custom-order-hero<?php echo $has_image ? '' : ' mm-custom-order-hero--no-image'; ?>"
	aria-labelledby="mm-custom-order-hero-heading"
>
	<?php if ( $has_image ) : ?>
		<div class="mm-custom-order-hero__media">
			<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image ?>
		</div>
	<?php endif; ?>

	<div class="mm-container mm-custom-order-hero__frame">
		<div class="mm-custom-order-hero__content mm-editorial" dir="rtl">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="mm-custom-order-hero__eyebrow"><?php mm_co_text( 'co_hero_eyebrow' ); ?></p>
			<?php endif; ?>

			<?php if ( '' !== $heading ) : ?>
				<h1 id="mm-custom-order-hero-heading" class="mm-custom-order-hero__heading">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( '' !== $description ) : ?>
				<p class="mm-custom-order-hero__description">
					<?php echo esc_html( $description ); ?>
				</p>
			<?php endif; ?>

			<?php if ( '' !== $cta_label ) : ?>
				<div class="mm-custom-order-hero__actions">
					<a class="mm-custom-order-hero__cta" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
