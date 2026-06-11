<?php
/**
 * Custom Order — Process steps sidebar.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$steps = mm_co_process_steps();

if ( empty( $steps ) ) {
	return;
}
?>
<aside class="mm-custom-order-form-section__process" aria-labelledby="mm-custom-order-process-heading">
	<header class="mm-custom-order-form-section__process-header mm-editorial" dir="rtl">
		<h2 id="mm-custom-order-process-heading" class="mm-custom-order-form-section__process-heading">
			<?php mm_co_text( 'co_process_heading' ); ?>
		</h2>
		<span class="mm-custom-order-form-section__diamond" aria-hidden="true"></span>
	</header>

	<ol class="mm-custom-order-form-section__steps">
		<?php foreach ( $steps as $step ) : ?>
			<li class="mm-custom-order-form-section__step">
				<div class="mm-custom-order-form-section__step-card mm-editorial" dir="rtl">
					<div class="mm-custom-order-form-section__step-icon" aria-hidden="true">
						<?php echo mm_co_render_process_step_icon( $step ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG or attachment image ?>
					</div>
					<div class="mm-custom-order-form-section__step-body">
						<?php if ( '' !== $step['title'] ) : ?>
							<h3 class="mm-custom-order-form-section__step-title">
								<?php echo esc_html( $step['title'] ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( '' !== $step['description'] ) : ?>
							<p class="mm-custom-order-form-section__step-text">
								<?php echo esc_html( $step['description'] ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
</aside>
