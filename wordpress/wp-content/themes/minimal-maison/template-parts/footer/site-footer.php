<?php
/**
 * Site footer.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$contact_lines = mm_footer_contact_lines();
$has_contact   = mm_footer_has_contact_lines();
$social_links  = mm_footer_social_links();
$has_social    = mm_footer_has_social_links();
$has_nav       = has_nav_menu( 'footer' );
$grid_columns  = mm_footer_grid_column_count();
$grid_classes  = 'site-footer__grid site-footer__grid--lg-' . $grid_columns;

?>
<footer class="site-footer border-t border-neutral-200/80 mt-auto bg-ivory-100">
	<div class="mm-container site-footer__frame">
		<div class="<?php echo esc_attr( $grid_classes ); ?>">
			<div class="site-footer__brand">
				<?php mm_the_site_logo( array( 'footer' => true ) ); ?>
				<?php if ( mm_footer_has_brand_text() ) : ?>
					<p class="site-footer__tagline">
						<?php echo nl2br( esc_html( mm_footer_brand_text() ) ); ?>
					</p>
				<?php endif; ?>
			</div>

			<?php if ( $has_contact ) : ?>
				<div class="site-footer__contact" id="footer-contact" tabindex="-1">
					<h2 class="site-footer__heading">
						<?php esc_html_e( 'تماس با ما', 'minimal-maison' ); ?>
					</h2>
					<ul class="site-footer__list">
						<?php foreach ( $contact_lines as $line ) : ?>
							<li>
								<?php if ( ! empty( $line['multiline'] ) ) : ?>
									<?php echo nl2br( esc_html( $line['label'] ) ); ?>
								<?php else : ?>
									<?php mm_maison_footer_channel( $line['label'], $line['url'] ); ?>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( $has_nav || $has_social ) : ?>
				<div class="site-footer__links">
					<?php if ( $has_nav ) : ?>
						<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'منوی پاورقی', 'minimal-maison' ); ?>">
							<h2 class="site-footer__heading">
								<?php esc_html_e( 'دسترسی سریع', 'minimal-maison' ); ?>
							</h2>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'container'      => false,
									'menu_class'     => 'site-footer__menu',
									'fallback_cb'    => false,
									'depth'          => 1,
								)
							);
							?>
						</nav>
					<?php endif; ?>

					<?php if ( $has_social ) : ?>
						<div class="site-footer__social">
							<h2 class="site-footer__heading">
								<?php esc_html_e( 'شبکه‌های اجتماعی', 'minimal-maison' ); ?>
							</h2>
							<ul class="site-footer__list">
								<?php foreach ( $social_links as $link ) : ?>
									<li>
										<?php mm_maison_footer_channel( $link['label'], $link['url'] ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="site-footer__legal">
			<p class="site-footer__copyright">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'تمامی حقوق محفوظ است.', 'minimal-maison' ); ?>
			</p>
		</div>
	</div>
</footer>
