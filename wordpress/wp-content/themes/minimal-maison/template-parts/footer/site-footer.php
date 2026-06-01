<?php
/**
 * Site footer.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer border-t border-neutral-200/80 mt-auto bg-ivory-100">
	<div class="mm-container py-14 md:py-16">
		<div class="flex flex-col gap-10 md:flex-row md:items-start md:justify-between">
			<div class="max-w-copy">
				<?php mm_the_site_logo( array( 'footer' => true ) ); ?>
				<p class="text-sm text-neutral-600">
					<?php esc_html_e( 'کارگاه ساخت طلا و جواهر اختصاصی. سفارش با وقت قبلی.', 'minimal-maison' ); ?>
				</p>
			</div>

			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav aria-label="<?php esc_attr_e( 'منوی پاورقی', 'minimal-maison' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'flex flex-wrap items-center gap-6 text-sm text-neutral-600',
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				</nav>
			<?php endif; ?>
		</div>

		<div class="mt-12 pt-8 border-t border-neutral-200/80 flex flex-col gap-4 md:flex-row md:items-center md:justify-between text-xs text-neutral-500">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'تمامی حقوق محفوظ است.', 'minimal-maison' ); ?></p>
			<p class="site-footer__channels">
				<?php
				mm_maison_footer_channel(
					__( 'اینستاگرام', 'minimal-maison' ),
					mm_maison_contact_url( 'instagram' )
				);
				?>
				<span aria-hidden="true"> · </span>
				<?php
				mm_maison_footer_channel(
					__( 'واتساپ', 'minimal-maison' ),
					mm_maison_contact_url( 'whatsapp' )
				);
				?>
				<span aria-hidden="true"> · </span>
				<?php
				$contact_url = mm_maison_contact_url( 'phone' );
				if ( '' === $contact_url ) {
					$contact_url = mm_maison_contact_url( 'email' );
				}
				mm_maison_footer_channel(
					__( 'تماس', 'minimal-maison' ),
					$contact_url
				);
				?>
			</p>
		</div>
	</div>
</footer>
