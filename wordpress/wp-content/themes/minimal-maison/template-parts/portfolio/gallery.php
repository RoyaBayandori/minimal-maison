<?php
/**
 * Portfolio — Editorial gallery with batched loading.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_pf_should_show_gallery() ) {
	return;
}

$batch_size    = mm_portfolio_gallery_page_size();
$total_items   = mm_portfolio_gallery_items_count( 'all' );
$initial_items = mm_portfolio_gallery_items_batch( 0, $batch_size, 'all' );
$has_items     = $total_items > 0;
$categories    = mm_portfolio_categories();
$eyebrow       = trim( mm_pf_option( 'pf_gallery_eyebrow' ) );
$heading       = trim( mm_pf_option( 'pf_gallery_heading' ) );
$description   = trim( mm_pf_option( 'pf_gallery_description' ) );
$all_label     = trim( mm_pf_option( 'pf_gallery_filter_all_label' ) );
$load_label    = mm_pf_gallery_load_more_label();
$empty_message = mm_pf_gallery_empty_message();
$has_filters   = $has_items && count( $categories ) > 0 && '' !== $all_label;
$has_header    = '' !== $eyebrow || '' !== $heading || '' !== $description;
$has_more      = count( $initial_items ) < $total_items;
$manifest      = $has_items ? mm_portfolio_gallery_manifest() : array();
?>
<section
	id="gallery"
	class="mm-portfolio-gallery<?php echo $has_items ? '' : ' mm-portfolio-gallery--empty'; ?>"
	<?php echo $has_header ? 'aria-labelledby="mm-portfolio-gallery-heading"' : ''; ?>
	data-portfolio-gallery
	data-portfolio-batch="<?php echo esc_attr( (string) $batch_size ); ?>"
	data-portfolio-total="<?php echo esc_attr( (string) $total_items ); ?>"
	data-portfolio-offset="<?php echo esc_attr( (string) count( $initial_items ) ); ?>"
>
	<?php if ( $has_items ) : ?>
		<script type="application/json" data-portfolio-manifest><?php echo wp_json_encode( $manifest, JSON_UNESCAPED_UNICODE ); ?></script>
	<?php endif; ?>

	<div class="mm-container">
		<?php if ( $has_header ) : ?>
			<header class="mm-portfolio-gallery__header mm-editorial" dir="rtl">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="mm-portfolio-gallery__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

				<?php if ( '' !== $heading ) : ?>
					<h2 id="mm-portfolio-gallery-heading" class="mm-portfolio-gallery__heading">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( '' !== $description ) : ?>
					<p class="mm-portfolio-gallery__description">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php if ( $has_filters ) : ?>
			<nav class="mm-portfolio-gallery__filters" aria-label="<?php esc_attr_e( 'فیلتر دسته‌بندی', 'minimal-maison' ); ?>">
				<div class="mm-portfolio-gallery__filters-track">
					<ul class="mm-portfolio-gallery__filter-list" role="list">
						<li class="mm-portfolio-gallery__filter-item">
							<button
								type="button"
								class="mm-portfolio-gallery__filter is-active"
								data-portfolio-filter="all"
								aria-pressed="true"
							>
								<span class="mm-portfolio-gallery__filter-label"><?php echo esc_html( $all_label ); ?></span>
								<span class="mm-portfolio-gallery__filter-mark" aria-hidden="true"></span>
							</button>
						</li>
						<?php foreach ( $categories as $term ) : ?>
							<?php if ( ! $term instanceof WP_Term ) : ?>
								<?php continue; ?>
							<?php endif; ?>
							<li class="mm-portfolio-gallery__filter-item">
								<button
									type="button"
									class="mm-portfolio-gallery__filter"
									data-portfolio-filter="<?php echo esc_attr( $term->slug ); ?>"
									aria-pressed="false"
								>
									<span class="mm-portfolio-gallery__filter-label"><?php echo esc_html( $term->name ); ?></span>
									<span class="mm-portfolio-gallery__filter-mark" aria-hidden="true"></span>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</nav>
		<?php endif; ?>

		<?php if ( $has_items ) : ?>
			<div class="mm-portfolio-gallery__grid" data-portfolio-grid>
				<?php echo mm_portfolio_render_gallery_pieces_html( $initial_items, 0 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<div class="mm-portfolio-gallery__actions" data-portfolio-actions<?php echo $has_more ? '' : ' hidden'; ?>>
				<button type="button" class="mm-portfolio-gallery__load-more" data-portfolio-load-more>
					<span class="mm-portfolio-gallery__load-more-label"><?php echo esc_html( $load_label ); ?></span>
				</button>
			</div>

			<p class="mm-portfolio-gallery__empty mm-portfolio-gallery__empty--filter" data-portfolio-empty hidden>
				<?php esc_html_e( 'در این دسته‌بندی نمونه کاری یافت نشد.', 'minimal-maison' ); ?>
			</p>
		<?php else : ?>
			<p class="mm-portfolio-gallery__empty mm-portfolio-gallery__empty--initial">
				<?php echo esc_html( $empty_message ); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( $has_items ) : ?>
		<div
			class="mm-portfolio-lightbox"
			data-portfolio-lightbox
			role="dialog"
			aria-modal="true"
			aria-hidden="true"
			aria-labelledby="mm-portfolio-lightbox-title"
			hidden
		>
			<div class="mm-portfolio-lightbox__backdrop" data-portfolio-lightbox-close></div>

			<div class="mm-portfolio-lightbox__dialog">
				<div class="mm-portfolio-lightbox__layout">
					<button
						type="button"
						class="mm-portfolio-lightbox__close"
						data-portfolio-lightbox-close
						aria-label="<?php esc_attr_e( 'بستن', 'minimal-maison' ); ?>"
					>
						<span aria-hidden="true">&times;</span>
					</button>

					<aside class="mm-portfolio-lightbox__panel mm-editorial" dir="rtl">
						<div class="mm-portfolio-lightbox__panel-content">
							<div class="mm-portfolio-lightbox__label-group">
								<h2 id="mm-portfolio-lightbox-title" class="mm-portfolio-lightbox__title" data-portfolio-lightbox-title></h2>

								<hr class="mm-portfolio-lightbox__rule" aria-hidden="true" />

								<p class="mm-portfolio-lightbox__category" data-portfolio-lightbox-category hidden></p>

								<p class="mm-portfolio-lightbox__year" data-portfolio-lightbox-year hidden></p>
							</div>
						</div>

						<nav class="mm-portfolio-lightbox__nav" aria-label="<?php esc_attr_e( 'پیمایش گالری', 'minimal-maison' ); ?>">
							<button type="button" class="mm-portfolio-lightbox__nav-btn mm-portfolio-lightbox__nav-btn--prev" data-portfolio-lightbox-prev>
								<span class="mm-portfolio-lightbox__nav-arrow" aria-hidden="true">&#8594;</span>
								<span class="mm-portfolio-lightbox__nav-label"><?php esc_html_e( 'قبلی', 'minimal-maison' ); ?></span>
							</button>
							<button type="button" class="mm-portfolio-lightbox__nav-btn mm-portfolio-lightbox__nav-btn--next" data-portfolio-lightbox-next>
								<span class="mm-portfolio-lightbox__nav-label"><?php esc_html_e( 'بعدی', 'minimal-maison' ); ?></span>
								<span class="mm-portfolio-lightbox__nav-arrow" aria-hidden="true">&#8592;</span>
							</button>
						</nav>
					</aside>

					<div class="mm-portfolio-lightbox__media">
						<div class="mm-portfolio-lightbox__image-wrap">
							<img
								class="mm-portfolio-lightbox__image"
								data-portfolio-lightbox-image
								alt=""
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
