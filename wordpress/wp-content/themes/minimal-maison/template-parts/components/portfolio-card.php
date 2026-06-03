<?php
/**
 * Luxury portfolio card — recent custom order.
 *
 * @package Minimal_Maison
 *
 * @var array<string, mixed> $args
 */

defined( 'ABSPATH' ) || exit;

$title       = isset( $args['title'] ) ? (string) $args['title'] : '';
$description = isset( $args['description'] ) ? (string) $args['description'] : '';
$image_id    = ! empty( $args['image_id'] ) ? (int) $args['image_id'] : 0;
$fallback_key = ! empty( $args['fallback_key'] ) ? (string) $args['fallback_key'] : '';

if ( '' === $title && '' === $description ) {
	return;
}
?>
<article class="mm-portfolio-card group">
	<figure class="mm-portfolio-card__media">
		<?php
		if ( $image_id ) {
			echo wp_get_attachment_image(
				$image_id,
				'mm-product-card',
				false,
				array(
					'class'   => 'mm-portfolio-card__image',
					'loading' => 'lazy',
					'alt'     => $title ? $title : '',
				)
			);
		} elseif ( $fallback_key && mm_home_image( $fallback_key ) ) {
			echo mm_home_image_tag(
				$fallback_key,
				array(
					'class' => 'mm-portfolio-card__image',
				)
			);
		} else {
			echo '<div class="mm-portfolio-card__image mm-portfolio-card__image--placeholder" aria-hidden="true"></div>';
		}
		?>
	</figure>

	<div class="mm-portfolio-card__body mm-editorial">
		<?php if ( $title ) : ?>
			<h3 class="mm-portfolio-card__name"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="mm-portfolio-card__description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
	</div>
</article>
