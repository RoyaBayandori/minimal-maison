<?php
/**
 * Homepage — Selected Creations.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$items = mm_home_creations();
?>
<section id="creations" class="mm-section border-t border-neutral-200/60">
	<div class="mm-container">
		<div class="mm-section-header">
			<p class="mm-subheading mb-4"><?php mm_home_text( 'creations_eyebrow' ); ?></p>
			<h2 class="text-display-sm md:text-display-md mb-5">
				<?php mm_home_text( 'creations_heading' ); ?>
			</h2>
			<p class="mx-auto max-w-copy text-sm md:text-base">
				<?php mm_home_text( 'creations_description' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
			<?php foreach ( $items as $item ) : ?>
				<?php
				if ( 'product' === ( $item['type'] ?? '' ) ) {
					get_template_part(
						'template-parts/components/product',
						'card',
						array( 'product' => $item['product'] )
					);
				} elseif ( 'creation' === ( $item['type'] ?? '' ) ) {
					get_template_part(
						'template-parts/components/product',
						'card',
						array( 'creation' => $item )
					);
				} else {
					get_template_part(
						'template-parts/components/product',
						'card',
						array( 'placeholder' => $item['placeholder'] ?? array() )
					);
				}
				?>
			<?php endforeach; ?>
		</div>

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<div class="mt-14 text-center">
				<a class="mm-button-outline" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
					<?php esc_html_e( 'مشاهده همه نمونه کارها', 'minimal-maison' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
