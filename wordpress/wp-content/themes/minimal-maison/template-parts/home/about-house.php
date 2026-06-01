<?php
/**
 * Homepage — About The House.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$paragraphs = mm_home_about_paragraphs();
?>
<section class="mm-section mm-about border-t border-neutral-200/60">
	<div class="mm-container">
		<div class="mm-about__grid grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-24 xl:gap-28 items-center">
			<div class="mm-about__media mm-editorial-frame order-2">
				<?php
				echo mm_render_home_image(
					'about',
					'about_image',
					array(
						'class' => 'h-[22rem] w-full object-cover object-center md:h-[28rem]',
					)
				);
				?>
			</div>

			<div class="mm-about__content mm-editorial order-1">
				<p class="mm-about__eyebrow mb-5"><?php mm_home_text( 'about_eyebrow' ); ?></p>
				<h2 class="mm-about__heading text-display-sm md:text-display-md mb-8">
					<?php mm_home_text( 'about_heading' ); ?>
				</h2>
				<div class="mm-about__body space-y-6 text-sm md:text-base leading-relaxed">
					<?php foreach ( $paragraphs as $paragraph ) : ?>
						<p><?php echo esc_html( $paragraph ); ?></p>
					<?php endforeach; ?>
				</div>
				<div class="mm-about__actions mt-12">
					<a class="mm-button-outline" href="<?php echo esc_url( mm_home_url( 'about_cta_url' ) ); ?>">
						<?php mm_home_text( 'about_cta_label' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
