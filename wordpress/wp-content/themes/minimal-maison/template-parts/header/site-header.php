<?php
/**
 * Site header.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;
?>
<header class="site-header border-b border-neutral-200/80 bg-white/80 backdrop-blur-sm sticky top-0 z-50">
	<div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-6 py-5">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-sm font-medium tracking-[0.2em] uppercase text-neutral-900">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="site-nav hidden md:block" aria-label="<?php esc_attr_e( 'Primary', 'minimal-maison' ); ?>">
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

		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<a
				href="<?php echo esc_url( wc_get_cart_url() ); ?>"
				class="text-sm tracking-wide text-neutral-700 hover:text-neutral-900"
				aria-label="<?php esc_attr_e( 'Cart', 'minimal-maison' ); ?>"
			>
				<?php esc_html_e( 'Cart', 'minimal-maison' ); ?>
				<span class="ms-1 text-neutral-400">(<?php echo esc_html( (string) WC()->cart->get_cart_contents_count() ); ?>)</span>
			</a>
		<?php endif; ?>
	</div>
</header>
