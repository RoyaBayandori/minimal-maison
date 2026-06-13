<?php
/**
 * Site header.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$is_home_header   = is_front_page();
$header_class     = 'site-header z-50';
$has_primary_menu = has_nav_menu( 'primary' );
$nav_items        = mm_primary_nav_items();
$nav_split        = mm_split_header_nav_items( $nav_items );

if ( $is_home_header ) {
	$header_class .= ' site-header--home';
} else {
	$header_class .= ' border-b border-neutral-200/80 bg-ivory-50 sticky top-0';
}
?>
<header class="<?php echo esc_attr( $header_class ); ?>">
	<div class="mm-container site-header__container">
		<?php // Mobile — hamburger + centered logo (<768px). ?>
		<div class="site-header__layout site-header__layout--mobile">
			<div class="site-header__mobile-start">
				<?php if ( $has_primary_menu ) : ?>
					<button
						type="button"
						class="site-header__menu-toggle"
						aria-controls="site-mobile-nav"
						aria-expanded="false"
						aria-label="<?php esc_attr_e( 'باز کردن منو', 'minimal-maison' ); ?>"
					>
						<span class="site-header__menu-bar" aria-hidden="true"></span>
						<span class="site-header__menu-bar" aria-hidden="true"></span>
					</button>
				<?php endif; ?>
			</div>

			<div class="site-header__brand">
				<?php mm_the_site_logo( array( 'header' => true ) ); ?>
			</div>

			<div class="site-header__mobile-end" aria-hidden="true"></div>
		</div>

		<?php // Tablet — dominant logo + visible navigation (768px–1199px). ?>
		<div class="site-header__layout site-header__layout--tablet">
			<div class="site-header__brand site-header__brand--tablet">
				<?php mm_the_site_logo( array( 'header' => true ) ); ?>
			</div>

			<?php if ( ! empty( $nav_items ) ) : ?>
				<?php
				mm_render_header_nav_list(
					$nav_items,
					'site-nav__list site-nav__list--tablet',
					__( 'منوی اصلی', 'minimal-maison' )
				);
				?>
			<?php endif; ?>
		</div>

		<?php // Desktop — symmetrical maison layout (1200px+). ?>
		<div class="site-header__layout site-header__layout--desktop">
			<div class="site-header__zone site-header__zone--start">
				<?php
				if ( ! empty( $nav_split['start'] ) ) {
					mm_render_header_nav_list(
						$nav_split['start'],
						'site-nav__list site-nav__list--start',
						__( 'منوی چپ', 'minimal-maison' )
					);
				}
				?>
			</div>

			<div class="site-header__brand site-header__brand--desktop">
				<?php mm_the_site_logo( array( 'header' => true ) ); ?>
			</div>

			<div class="site-header__zone site-header__zone--end">
				<?php
				if ( ! empty( $nav_split['end'] ) ) {
					mm_render_header_nav_list(
						$nav_split['end'],
						'site-nav__list site-nav__list--end',
						__( 'منوی راست', 'minimal-maison' )
					);
				}
				?>
			</div>
		</div>
	</div>

	<?php if ( $has_primary_menu ) : ?>
		<div id="site-mobile-nav" class="site-mobile-nav" hidden>
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
