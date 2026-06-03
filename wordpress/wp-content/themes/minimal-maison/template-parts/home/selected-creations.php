<?php
/**
 * Homepage — Recent Custom Orders portfolio.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$items = mm_home_creations();
?>
<section id="creations" class="mm-recent-orders" aria-labelledby="recent-orders-heading">
	<div class="mm-container">
		<header class="mm-recent-orders__header mm-editorial">
			<h2 id="recent-orders-heading" class="mm-recent-orders__title">
				<?php mm_home_text( 'creations_heading' ); ?>
			</h2>
			<p class="mm-recent-orders__subtitle">
				<?php mm_home_text( 'creations_description' ); ?>
			</p>
		</header>

		<div class="mm-recent-orders__grid">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$card_args = array(
					'title'        => '',
					'description'  => '',
					'image_id'     => 0,
					'fallback_key' => '',
				);

				if ( 'creation' === ( $item['type'] ?? '' ) ) {
					$card_args['title']       = ! empty( $item['title'] ) ? (string) $item['title'] : '';
					$card_args['description'] = ! empty( $item['description'] ) ? (string) $item['description'] : '';
					$card_args['image_id']    = ! empty( $item['image_id'] ) ? (int) $item['image_id'] : 0;
					$card_args['fallback_key'] = ! empty( $item['fallback_key'] ) ? (string) $item['fallback_key'] : '';
				} elseif ( 'product' === ( $item['type'] ?? '' ) && ( $item['product'] ?? null ) instanceof WC_Product ) {
					$product                  = $item['product'];
					$card_args['title']       = $product->get_name();
					$card_args['description'] = wp_strip_all_tags( $product->get_short_description() );
					$card_args['image_id']    = (int) $product->get_image_id();
				} elseif ( 'placeholder' === ( $item['type'] ?? '' ) && is_array( $item['placeholder'] ?? null ) ) {
					$placeholder              = $item['placeholder'];
					$card_args['title']       = (string) ( $placeholder['title'] ?? '' );
					$card_args['description'] = (string) ( $placeholder['description'] ?? '' );
					$card_args['fallback_key'] = (string) ( $placeholder['image'] ?? '' );
				}

				get_template_part(
					'template-parts/components/portfolio',
					'card',
					$card_args
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
