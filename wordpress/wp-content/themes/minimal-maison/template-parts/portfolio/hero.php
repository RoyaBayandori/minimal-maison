<?php
/**
 * Portfolio — Hero section.
 *
 * Visual system mirrors template-parts/custom-order/hero.php.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_pf_should_show_hero() ) {
	return;
}

$heading      = trim( mm_pf_option( 'pf_hero_heading' ) );
$description  = trim( mm_pf_option( 'pf_hero_description' ) );
$eyebrow      = trim( mm_pf_option( 'pf_hero_eyebrow' ) );
$cta_label    = trim( mm_pf_option( 'pf_hero_cta_label' ) );
$cta_url      = mm_custom_order_form_url();
$image_markup = mm_pf_render_image( 'pf_hero_image' );
$has_image    = '' !== $image_markup;
?>
<section
	class="mm-portfolio-hero<?php echo $has_image ? '' : ' mm-portfolio-hero--no-image'; ?>"
	aria-labelledby="mm-portfolio-hero-heading"
>
	<?php if ( $has_image ) : ?>
		<div class="mm-portfolio-hero__media">
			<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image ?>
		</div>
	<?php endif; ?>

	<div class="mm-container mm-portfolio-hero__frame">
		<div class="mm-portfolio-hero__content mm-editorial" dir="rtl">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="mm-portfolio-hero__eyebrow"><?php mm_pf_text( 'pf_hero_eyebrow' ); ?></p>
			<?php endif; ?>

			<?php if ( '' !== $heading ) : ?>
				<h1 id="mm-portfolio-hero-heading" class="mm-portfolio-hero__heading">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( '' !== $description ) : ?>
				<p class="mm-portfolio-hero__description">
					<?php echo esc_html( $description ); ?>
				</p>
			<?php endif; ?>

			<?php if ( '' !== $cta_label ) : ?>
				<div class="mm-portfolio-hero__actions">
					<a class="mm-portfolio-hero__cta" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html( $cta_label ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
