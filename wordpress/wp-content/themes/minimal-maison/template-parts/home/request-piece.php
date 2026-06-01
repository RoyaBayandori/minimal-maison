<?php
/**
 * Homepage — Request A Custom Piece.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$request_status = isset( $_GET['mm_request'] ) ? sanitize_key( wp_unslash( $_GET['mm_request'] ) ) : '';
$error_code     = isset( $_GET['mm_error'] ) ? sanitize_key( wp_unslash( $_GET['mm_error'] ) ) : '';
?>
<section id="request" class="mm-section pb-30 md:pb-34">
	<div class="mm-container">
		<div class="mm-cta-panel">
			<?php get_template_part( 'template-parts/home/request', 'concierge' ); ?>

			<div class="mm-section-header">
				<p class="mm-subheading mb-5 text-gold-400"><?php mm_home_text( 'cta_eyebrow' ); ?></p>
				<h2 class="text-display-sm md:text-display-md text-ivory-50 mb-6">
					<?php mm_home_text( 'cta_heading' ); ?>
				</h2>
				<p class="text-sm md:text-base text-ivory-200/75 leading-relaxed">
					<?php mm_home_text( 'cta_description' ); ?>
				</p>
			</div>

			<?php if ( 'success' === $request_status ) : ?>
				<div class="mm-form-notice mm-form-notice--success" role="status">
					<p><?php esc_html_e( 'پیام شما به کارگاه رسید. معمولاً ظرف یک تا دو روز کاری برای هماهنگی گفت‌وگو با شما تماس می‌گیریم.', 'minimal-maison' ); ?></p>
				</div>
			<?php elseif ( 'error' === $request_status ) : ?>
				<div class="mm-form-notice mm-form-notice--error" role="alert">
					<p><?php echo esc_html( mm_jewelry_request_error_message( $error_code ) ); ?></p>
				</div>
			<?php endif; ?>

			<div class="mm-request-form__body">
				<?php get_template_part( 'template-parts/components/jewelry', 'request-form' ); ?>
			</div>
		</div>
	</div>
</section>
