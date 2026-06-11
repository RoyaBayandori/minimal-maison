<?php
/**
 * Custom Order — Benefits section (horizontal editorial blocks).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_co_should_show_benefits() ) {
	return;
}

$benefits    = mm_co_benefits();
$description = trim( mm_co_option( 'co_benefits_description' ) );
?>
<section class="mm-custom-order-benefits" aria-labelledby="mm-custom-order-benefits-heading">
	<div class="mm-custom-order-benefits__frame mm-container">
		<header class="mm-custom-order-benefits__header mm-editorial" dir="rtl">
			<h2 id="mm-custom-order-benefits-heading" class="mm-custom-order-benefits__heading">
				<?php mm_co_text( 'co_benefits_heading' ); ?>
			</h2>
			<span class="mm-custom-order-benefits__diamond" aria-hidden="true"></span>
			<?php if ( '' !== $description ) : ?>
				<p class="mm-custom-order-benefits__description">
					<?php echo esc_html( $description ); ?>
				</p>
			<?php endif; ?>
		</header>

		<ul class="mm-custom-order-benefits__list">
			<?php foreach ( $benefits as $benefit ) : ?>
				<?php
				$image_markup = mm_co_render_benefit_image( (int) $benefit['image_id'] );

				if ( '' === $image_markup ) {
					continue;
				}
				?>
				<li class="mm-custom-order-benefits__item">
					<article class="mm-custom-order-benefits__card mm-editorial" dir="rtl">
						<figure class="mm-custom-order-benefits__media">
							<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image ?>
						</figure>

						<div class="mm-custom-order-benefits__body">
							<?php if ( '' !== $benefit['title'] ) : ?>
								<h3 class="mm-custom-order-benefits__title">
									<?php echo esc_html( $benefit['title'] ); ?>
								</h3>
							<?php endif; ?>

							<?php if ( '' !== $benefit['description'] ) : ?>
								<p class="mm-custom-order-benefits__text">
									<?php echo esc_html( $benefit['description'] ); ?>
								</p>
							<?php endif; ?>
						</div>
					</article>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
