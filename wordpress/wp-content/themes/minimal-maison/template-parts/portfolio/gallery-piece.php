<?php
/**
 * Portfolio — Editorial gallery card.
 *
 * @package Minimal_Maison
 *
 * @var array<string, mixed> $args
 */

defined( 'ABSPATH' ) || exit;

$item  = isset( $args['item'] ) && is_array( $args['item'] ) ? $args['item'] : array();
$index = isset( $args['index'] ) ? (int) $args['index'] : 0;

if ( empty( $item['image_id'] ) ) {
	return;
}

$category_attr  = ! empty( $item['category_slugs'] )
	? implode( ' ', array_map( 'sanitize_html_class', $item['category_slugs'] ) )
	: '';
$category_label = ! empty( $item['category_names'] )
	? (string) $item['category_names'][0]
	: '';
$title   = isset( $item['title'] ) ? (string) $item['title'] : '';
$item_id = isset( $item['id'] ) ? (int) $item['id'] : 0;
?>
<article
	class="mm-portfolio-gallery__piece"
	data-portfolio-piece
	data-portfolio-id="<?php echo esc_attr( (string) $item_id ); ?>"
	data-portfolio-index="<?php echo esc_attr( (string) $index ); ?>"
	<?php if ( '' !== $category_attr ) : ?>
		data-portfolio-categories="<?php echo esc_attr( $category_attr ); ?>"
	<?php endif; ?>
>
	<button
		type="button"
		class="mm-portfolio-gallery__trigger"
		data-portfolio-open
		aria-label="<?php echo esc_attr( sprintf( __( 'مشاهده اثر: %s', 'minimal-maison' ), $title ) ); ?>"
	>
		<div class="mm-portfolio-gallery__frame">
			<?php
			echo wp_get_attachment_image(
				(int) $item['image_id'],
				'large',
				false,
				array(
					'class'    => 'mm-portfolio-gallery__image',
					'loading'  => 'lazy',
					'decoding' => 'async',
					'sizes'    => '(min-width: 1200px) 25vw, (min-width: 768px) 50vw, 100vw',
				)
			);
			?>
			<span class="mm-portfolio-gallery__shade" aria-hidden="true"></span>
		</div>

		<figcaption class="mm-portfolio-gallery__caption">
			<?php if ( '' !== $title ) : ?>
				<span class="mm-portfolio-gallery__piece-title"><?php echo esc_html( $title ); ?></span>
			<?php endif; ?>

			<?php if ( '' !== $category_label ) : ?>
				<span class="mm-portfolio-gallery__piece-category"><?php echo esc_html( $category_label ); ?></span>
			<?php endif; ?>
		</figcaption>
	</button>
</article>
