<?php
/**
 * Site header.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$is_home_header = is_front_page();
$header_class   = 'site-header z-50';

if ( $is_home_header ) {
	$header_class .= ' site-header--home';
} else {
	$header_class .= ' border-b border-neutral-200/80 bg-ivory-50 sticky top-0';
}

$has_primary_menu = has_nav_menu( 'primary' );
?>
<header class="<?php echo esc_attr( $header_class ); ?>">
	<div class="mm-container site-header__container">
		<div class="site-header__inner grid grid-cols-[1fr_auto_1fr] items-center gap-4 md:gap-6">
			<div class="site-header__start flex items-center justify-start">
				<?php if ( $has_primary_menu ) : ?>
					<button
						type="button"
						class="site-header__menu-toggle md:hidden"
						aria-controls="site-mobile-nav"
						aria-expanded="false"
						aria-label="<?php esc_attr_e( 'باز کردن منو', 'minimal-maison' ); ?>"
					>
						<span class="site-header__menu-bar" aria-hidden="true"></span>
						<span class="site-header__menu-bar" aria-hidden="true"></span>
					</button>

					<nav class="site-nav hidden md:block" aria-label="<?php esc_attr_e( 'منوی اصلی', 'minimal-maison' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'flex items-center gap-8 text-sm text-neutral-600',
								'fallback_cb'    => false,
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>
			</div>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-wordmark" rel="home">مینیمال</a>

			<div class="site-header__end flex items-center justify-end">
				<?php if ( class_exists( 'WooCommerce' ) && ! is_front_page() ) : ?>
					<a
						href="<?php echo esc_url( wc_get_cart_url() ); ?>"
						class="text-sm tracking-wide text-neutral-700 hover:text-neutral-900"
						aria-label="<?php esc_attr_e( 'سبد خرید', 'minimal-maison' ); ?>"
					>
						<?php esc_html_e( 'سبد', 'minimal-maison' ); ?>
						<span class="ms-1 text-neutral-400">(<?php echo esc_html( (string) WC()->cart->get_cart_contents_count() ); ?>)</span>
					</a>
				<?php elseif ( $is_home_header ) : ?>
					<span class="site-header__icon md:hidden" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="8" cy="8" r="5.25" stroke="currentColor" stroke-width="1.1"/>
							<path d="M12.5 12.5L16 16" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/>
						</svg>
					</span>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php if ( $has_primary_menu ) : ?>
		<div id="site-mobile-nav" class="site-mobile-nav md:hidden" hidden>
			<nav class="site-mobile-nav__panel" aria-label="<?php esc_attr_e( 'منوی موبایل', 'minimal-maison' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'site-mobile-nav__list',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
		</div>
	<?php endif; ?>
</header>
