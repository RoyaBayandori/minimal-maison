<?php
/**
 * Front page template.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">
	<section class="mm-section">
		<div class="mm-container">
			<div class="mx-auto max-w-copy text-center">
				<p class="mm-subheading mb-6">
					<?php esc_html_e( 'Maison Minimal', 'minimal-maison' ); ?>
				</p>

				<h1 class="mm-heading mb-8">
					<?php esc_html_e( 'Timeless Jewelry, Quietly Composed', 'minimal-maison' ); ?>
				</h1>

				<p class="mx-auto max-w-copy text-base md:text-lg mb-12">
					<?php esc_html_e( 'A modern Persian jewelry house where refined craftsmanship meets editorial restraint.', 'minimal-maison' ); ?>
				</p>

				<div class="flex flex-wrap items-center justify-center gap-4">
					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a class="mm-button" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
							<?php esc_html_e( 'Explore Collection', 'minimal-maison' ); ?>
						</a>
					<?php endif; ?>

					<a class="mm-button-outline" href="<?php echo esc_url( home_url( '/about' ) ); ?>">
						<?php esc_html_e( 'Our Story', 'minimal-maison' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="pb-22 md:pb-30">
		<div class="mm-container">
			<div class="relative overflow-hidden rounded-sm border border-neutral-200/80 bg-ink-900 shadow-mm-soft">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>"
					alt="<?php esc_attr_e( 'Minimal Maison editorial visual', 'minimal-maison' ); ?>"
					class="h-[26rem] w-full object-cover object-center md:h-[34rem]"
					loading="lazy"
				>
				<div class="absolute inset-0 bg-ink-900/35"></div>
				<div class="absolute inset-x-0 bottom-0 p-8 md:p-12">
					<p class="mm-subheading mb-4 text-ivory-200/90">
						<?php esc_html_e( 'Editorial Vision', 'minimal-maison' ); ?>
					</p>
					<h2 class="text-3xl md:text-display-md text-ivory-50 max-w-copy">
						<?php esc_html_e( 'Quiet statements shaped in light, proportion, and precision.', 'minimal-maison' ); ?>
					</h2>
				</div>
			</div>
		</div>
	</section>

	<section class="pb-22 md:pb-30">
		<div class="mm-container">
			<div class="mb-12 text-center">
				<p class="mm-subheading mb-4"><?php esc_html_e( 'Collections', 'minimal-maison' ); ?></p>
				<h2 class="text-display-sm md:text-display-md mb-4">
					<?php esc_html_e( 'Three Signatures of the House', 'minimal-maison' ); ?>
				</h2>
				<p class="mx-auto max-w-copy text-sm md:text-base">
					<?php esc_html_e( 'Designed for daily permanence, ceremonial elegance, and heirloom craftsmanship.', 'minimal-maison' ); ?>
				</p>
			</div>

			<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
				<article class="mm-collection-card">
					<div class="mm-collection-image" aria-hidden="true"></div>
					<div class="p-6 md:p-8">
						<p class="mm-subheading mb-3"><?php esc_html_e( '01', 'minimal-maison' ); ?></p>
						<h3 class="text-2xl mb-3"><?php esc_html_e( 'Atelier Core', 'minimal-maison' ); ?></h3>
						<p class="text-sm"><?php esc_html_e( 'Everyday fine pieces in warm precious tones.', 'minimal-maison' ); ?></p>
					</div>
				</article>

				<article class="mm-collection-card">
					<div class="mm-collection-image" aria-hidden="true"></div>
					<div class="p-6 md:p-8">
						<p class="mm-subheading mb-3"><?php esc_html_e( '02', 'minimal-maison' ); ?></p>
						<h3 class="text-2xl mb-3"><?php esc_html_e( 'Occasion', 'minimal-maison' ); ?></h3>
						<p class="text-sm"><?php esc_html_e( 'Refined silhouettes for evening and ceremony.', 'minimal-maison' ); ?></p>
					</div>
				</article>

				<article class="mm-collection-card">
					<div class="mm-collection-image" aria-hidden="true"></div>
					<div class="p-6 md:p-8">
						<p class="mm-subheading mb-3"><?php esc_html_e( '03', 'minimal-maison' ); ?></p>
						<h3 class="text-2xl mb-3"><?php esc_html_e( 'Heirloom', 'minimal-maison' ); ?></h3>
						<p class="text-sm"><?php esc_html_e( 'Future classics crafted to be passed forward.', 'minimal-maison' ); ?></p>
					</div>
				</article>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
