<?php
/**
 * Homepage — cinematic full-bleed hero.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$eyebrow              = trim( (string) mm_home_acf_value( 'hero_eyebrow' ) );
$heading              = trim( (string) mm_home_acf_value( 'hero_heading' ) );
$lede                 = trim( (string) mm_home_acf_value( 'hero_banner_text' ) );
$primary_cta_label    = trim( (string) mm_home_acf_value( 'hero_primary_cta_label' ) );
$primary_cta_url      = mm_home_acf_url( 'hero_primary_cta_url' );
$secondary_cta_label  = trim( (string) mm_home_acf_value( 'hero_secondary_cta_label' ) );
$secondary_cta_url    = mm_home_acf_url( 'hero_secondary_cta_url' );
$hero_image           = mm_render_home_option_image(
	'hero_image',
	array(
		'class'         => 'mm-hero-cinematic__image',
		'loading'       => 'eager',
		'fetchpriority' => 'high',
		'decoding'      => 'async',
	),
	'full',
	'100vw'
);
$has_primary_cta   = '' !== $primary_cta_label && '' !== $primary_cta_url;
$has_secondary_cta = '' !== $secondary_cta_label && '' !== $secondary_cta_url;
?>
<section class="mm-hero-cinematic" aria-label="<?php esc_attr_e( 'مینیمال', 'minimal-maison' ); ?>">
	<?php if ( '' !== $hero_image ) : ?>
		<div class="mm-hero-cinematic__media">
			<?php echo $hero_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image ?>
		</div>
	<?php endif; ?>

	<div class="mm-container mm-hero-cinematic__frame">
		<div class="mm-hero-cinematic__content mm-editorial" dir="rtl">
			<?php if ( '' !== $eyebrow ) : ?>
				<p class="mm-hero-cinematic__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<?php if ( '' !== $heading ) : ?>
				<h1 class="mm-hero-cinematic__heading">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( '' !== $lede ) : ?>
				<p class="mm-hero-cinematic__lede">
					<?php echo esc_html( $lede ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $has_primary_cta || $has_secondary_cta ) : ?>
				<div class="mm-hero-cinematic__actions">
					<?php if ( $has_primary_cta ) : ?>
						<a
							class="mm-hero-cinematic__cta-primary"
							href="<?php echo esc_url( $primary_cta_url ); ?>"
						>
							<?php echo esc_html( $primary_cta_label ); ?>
						</a>
					<?php endif; ?>

					<?php if ( $has_secondary_cta ) : ?>
						<a
							class="mm-hero-cinematic__cta-secondary"
							href="<?php echo esc_url( $secondary_cta_url ); ?>"
						>
							<?php echo esc_html( $secondary_cta_label ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
