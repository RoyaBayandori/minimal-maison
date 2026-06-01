<?php
/**
 * Luxury product card — WooCommerce product or placeholder.
 *
 * @package Minimal_Maison
 *
 * @var array<string, mixed> $args
 */

defined( 'ABSPATH' ) || exit;

$product     = $args['product'] ?? null;
$placeholder = $args['placeholder'] ?? null;
$creation    = $args['creation'] ?? null;

if ( is_array( $creation ) && ! empty( $creation['post'] ) && $creation['post'] instanceof WP_Post ) {
	$post     = $creation['post'];
	$subtitle = ! empty( $creation['subtitle'] ) ? (string) $creation['subtitle'] : '';
	$title    = ! empty( $creation['title'] ) ? (string) $creation['title'] : get_the_title( $post );
	$price    = ! empty( $creation['price'] ) ? (string) $creation['price'] : __( 'قیمت پس از مشاوره', 'minimal-maison' );
	$image_id = ! empty( $creation['image_id'] ) ? (int) $creation['image_id'] : 0;
	?>
	<article class="mm-product-card group">
		<div class="block">
			<div class="mm-product-image">
				<?php
				if ( $image_id ) {
					echo wp_get_attachment_image(
						$image_id,
						'mm-product-card',
						false,
						array(
							'class'   => 'h-full w-full object-cover object-center transition duration-500 group-hover:scale-[1.02]',
							'loading' => 'lazy',
						)
					);
				} elseif ( ! empty( $creation['fallback_key'] ) && mm_home_image( (string) $creation['fallback_key'] ) ) {
					echo mm_home_image_tag(
						(string) $creation['fallback_key'],
						array(
							'class' => 'h-full w-full object-cover object-center transition duration-500 group-hover:scale-[1.02]',
						)
					);
				} else {
					echo '<div class="h-full w-full bg-neutral-200/70" aria-hidden="true"></div>';
				}
				?>
			</div>
			<div class="p-5 md:p-6">
				<?php if ( $subtitle ) : ?>
					<p class="mm-subheading mb-2"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<h3 class="text-lg md:text-xl mb-2 text-ink-900"><?php echo esc_html( $title ); ?></h3>
				<?php if ( $price ) : ?>
					<p class="text-sm text-neutral-600"><?php echo esc_html( $price ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</article>
	<?php
	return;
}

if ( $product instanceof WC_Product ) {
	$permalink = $product->get_permalink();
	$title     = $product->get_name();
	$price     = $product->get_price_html();
	$terms     = get_the_terms( $product->get_id(), 'product_cat' );
	$subtitle  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
	$image_id  = $product->get_image_id();
	?>
	<article class="mm-product-card group">
		<a href="<?php echo esc_url( $permalink ); ?>" class="block">
			<div class="mm-product-image">
				<?php
				if ( $image_id ) {
					echo wp_get_attachment_image(
						$image_id,
						'mm-product-card',
						false,
						array(
							'class'   => 'h-full w-full object-cover object-center transition duration-500 group-hover:scale-[1.02]',
							'loading' => 'lazy',
						)
					);
				} else {
					echo '<div class="h-full w-full bg-neutral-200/70" aria-hidden="true"></div>';
				}
				?>
			</div>
			<div class="p-5 md:p-6">
				<?php if ( $subtitle ) : ?>
					<p class="mm-subheading mb-2"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<h3 class="text-lg md:text-xl mb-2 text-ink-900"><?php echo esc_html( $title ); ?></h3>
				<?php if ( $price ) : ?>
					<p class="text-sm text-neutral-600"><?php echo wp_kses_post( $price ); ?></p>
				<?php endif; ?>
			</div>
		</a>
	</article>
	<?php
	return;
}

if ( is_array( $placeholder ) ) {
	$image_key = ! empty( $placeholder['image'] ) ? (string) $placeholder['image'] : '';
	?>
	<article class="mm-product-card group">
		<div class="block">
			<div class="mm-product-image">
				<?php
				if ( $image_key && mm_home_image( $image_key ) ) {
					echo mm_home_image_tag(
						$image_key,
						array(
							'class' => 'h-full w-full object-cover object-center transition duration-500 group-hover:scale-[1.02]',
						)
					);
				} else {
					echo '<div class="h-full w-full bg-neutral-200/70" aria-hidden="true"></div>';
				}
				?>
			</div>
			<div class="p-5 md:p-6">
				<?php if ( ! empty( $placeholder['subtitle'] ) ) : ?>
					<p class="mm-subheading mb-2"><?php echo esc_html( $placeholder['subtitle'] ); ?></p>
				<?php endif; ?>
				<h3 class="text-lg md:text-xl mb-2 text-ink-900"><?php echo esc_html( $placeholder['title'] ); ?></h3>
				<?php if ( ! empty( $placeholder['price'] ) ) : ?>
					<p class="text-sm text-neutral-600"><?php echo esc_html( $placeholder['price'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</article>
	<?php
}
