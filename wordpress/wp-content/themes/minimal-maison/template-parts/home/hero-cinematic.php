<?php
/**
 * Homepage — cinematic full-bleed hero.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="mm-hero-cinematic" aria-label="<?php esc_attr_e( 'مینیمال', 'minimal-maison' ); ?>">
	<div class="mm-hero-cinematic__media">
		<?php
		echo mm_render_home_image(
			'hero',
			'hero_image',
			array(
				'class'         => 'mm-hero-cinematic__image',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'decoding'      => 'async',
			)
		);
		?>
	</div>

	<div class="mm-hero-cinematic__overlay" aria-hidden="true"></div>

	<div class="mm-container mm-hero-cinematic__frame">
		<div class="mm-hero-cinematic__content mm-editorial">
			<p class="mm-hero-cinematic__eyebrow"><?php mm_home_text( 'hero_eyebrow' ); ?></p>

			<h1 class="mm-hero-cinematic__heading">
				<?php mm_home_text( 'hero_heading' ); ?>
			</h1>

			<p class="mm-hero-cinematic__lede">
				<?php mm_home_text( 'hero_banner_text' ); ?>
			</p>

			<div class="flex flex-wrap items-center gap-4">
				<a
					class="mm-hero-cinematic__cta"
					href="<?php echo esc_url( mm_home_url( 'hero_primary_cta_url' ) ); ?>"
				>
					<?php mm_home_text( 'hero_primary_cta_label' ); ?>
				</a>
				<a
					class="mm-hero-cinematic__cta"
					href="<?php echo esc_url( mm_home_url( 'hero_secondary_cta_url' ) ); ?>"
				>
					<?php mm_home_text( 'hero_secondary_cta_label' ); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="mm-hero-cinematic__scroll" aria-hidden="true">
		<span class="mm-hero-cinematic__scroll-line"></span>
	</div>
</section>
