<?php
/**
 * Custom Order — Form intro and request form.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$heading     = trim( mm_co_option( 'co_form_heading' ) );
$description = trim( mm_co_option( 'co_form_description' ) );
$note        = trim( mm_co_option( 'co_form_note' ) );

$request_status = isset( $_GET['mm_request'] ) ? sanitize_key( wp_unslash( $_GET['mm_request'] ) ) : '';
$error_code     = isset( $_GET['mm_error'] ) ? sanitize_key( wp_unslash( $_GET['mm_error'] ) ) : '';
?>
<section id="request-form" class="mm-custom-order-form-section">
	<div class="mm-custom-order-form-section__frame mm-container">
		<div class="mm-custom-order-form-section__panel">
			<header class="mm-custom-order-form-section__header mm-editorial" dir="rtl">
				<?php if ( '' !== $heading ) : ?>
					<h2 class="mm-custom-order-form-section__heading">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( '' !== $description ) : ?>
					<p class="mm-custom-order-form-section__description">
						<?php echo esc_html( $description ); ?>
					</p>
				<?php endif; ?>

				<?php if ( '' !== $note ) : ?>
					<p class="mm-custom-order-form-section__note">
						<?php echo esc_html( $note ); ?>
					</p>
				<?php endif; ?>
			</header>

			<?php if ( 'success' === $request_status ) : ?>
				<div class="mm-custom-order-form-section__notice mm-custom-order-form-section__notice--success" role="status">
					<p><?php esc_html_e( 'پیام شما به کارگاه رسید. معمولاً ظرف یک تا دو روز کاری برای هماهنگی گفت‌وگو با شما تماس می‌گیریم.', 'minimal-maison' ); ?></p>
				</div>
			<?php elseif ( 'error' === $request_status ) : ?>
				<div class="mm-custom-order-form-section__notice mm-custom-order-form-section__notice--error" role="alert">
					<p><?php echo esc_html( mm_jewelry_request_error_message( $error_code ) ); ?></p>
				</div>
			<?php endif; ?>

			<div class="mm-custom-order-form">
				<?php get_template_part( 'template-parts/components/jewelry', 'request-form' ); ?>
			</div>
		</div>
	</div>
</section>
