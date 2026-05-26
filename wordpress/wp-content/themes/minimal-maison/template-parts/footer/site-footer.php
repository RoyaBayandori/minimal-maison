<?php
/**
 * Site footer.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer border-t border-neutral-200/80 mt-auto">
	<div class="mx-auto max-w-6xl px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6 text-sm text-neutral-500">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Footer', 'minimal-maison' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'flex flex-wrap items-center gap-6',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</footer>
