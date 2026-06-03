<?php
/**
 * Homepage — How It Works (Craft Process editorial register / image preview).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$steps       = mm_home_craft_steps();
$heading     = trim( (string) mm_home_acf_value( 'craft_heading' ) );
$description = trim( (string) mm_home_acf_value( 'craft_description' ) );

if ( '' === $heading && '' === $description && empty( $steps ) ) {
	return;
}

$has_preview   = mm_home_craft_has_preview_images( $steps );
$default_index = $has_preview ? mm_home_craft_default_image_index( $steps ) : null;
$panel_id      = 'craft-process-preview-panel';

?>
<section
	class="mm-craft-process<?php echo $has_preview ? ' mm-craft-process--preview' : ''; ?>"
	<?php echo '' !== $heading ? 'aria-labelledby="craft-process-heading"' : ''; ?>
	<?php echo $has_preview && null !== $default_index ? ' data-default-index="' . esc_attr( (string) $default_index ) . '"' : ''; ?>
>
	<div class="mm-container">
		<div class="mm-craft-process__frame">
			<?php if ( '' !== $heading || '' !== $description ) : ?>
				<header class="mm-craft-process__header mm-editorial">
					<?php if ( '' !== $heading ) : ?>
						<h2 id="craft-process-heading" class="mm-craft-process__heading">
							<?php echo esc_html( $heading ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( '' !== $description ) : ?>
						<p class="mm-craft-process__intro">
							<?php echo esc_html( $description ); ?>
						</p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<?php if ( ! empty( $steps ) ) : ?>
				<?php if ( $has_preview ) : ?>
					<div class="mm-craft-process__composition">
						<figure class="mm-craft-process__preview">
							<div
								id="<?php echo esc_attr( $panel_id ); ?>"
								class="mm-craft-process__preview-stage"
								role="tabpanel"
								aria-live="polite"
								<?php echo null !== $default_index ? ' aria-labelledby="craft-step-tab-' . esc_attr( (string) $default_index ) . '"' : ''; ?>
							>
								<?php foreach ( $steps as $index => $step ) : ?>
									<?php
									if ( empty( $step['image_id'] ) ) {
										continue;
									}

									$is_default = (int) $index === (int) $default_index;
									$layer_class = 'mm-craft-process__preview-layer';

									if ( $is_default ) {
										$layer_class .= ' is-active';
									}
									?>
									<div
										class="<?php echo esc_attr( $layer_class ); ?>"
										data-craft-index="<?php echo esc_attr( (string) $index ); ?>"
										<?php echo $is_default ? ' data-active="true"' : ''; ?>
									>
										<?php
										echo mm_render_craft_step_image( (int) $step['image_id'], $is_default ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image
										?>
									</div>
								<?php endforeach; ?>
							</div>
						</figure>

						<div class="mm-craft-process__rail" dir="rtl">
							<ol class="mm-craft-process__steps" role="tablist" aria-label="<?php echo esc_attr( $heading ?: __( 'مراحل ساخت', 'minimal-maison' ) ); ?>">
								<?php foreach ( $steps as $index => $step ) : ?>
									<?php
									$tab_id     = 'craft-step-tab-' . $index;
									$is_default = (int) $index === (int) $default_index;
									$step_class = 'mm-craft-process__step';

									if ( $is_default ) {
										$step_class .= ' is-active';
									}
									?>
									<li class="<?php echo esc_attr( $step_class ); ?>" data-craft-index="<?php echo esc_attr( (string) $index ); ?>">
										<button
											type="button"
											id="<?php echo esc_attr( $tab_id ); ?>"
											class="mm-craft-process__trigger"
											role="tab"
											aria-selected="<?php echo $is_default ? 'true' : 'false'; ?>"
											aria-controls="<?php echo esc_attr( $panel_id ); ?>"
											data-craft-index="<?php echo esc_attr( (string) $index ); ?>"
											<?php echo ! empty( $step['image_id'] ) ? ' data-craft-has-image="true"' : ''; ?>
										>
											<?php if ( ! empty( $step['title'] ) ) : ?>
												<span class="mm-craft-process__title"><?php echo esc_html( $step['title'] ); ?></span>
											<?php endif; ?>

											<?php if ( ! empty( $step['text'] ) ) : ?>
												<span class="mm-craft-process__text"><?php echo esc_html( $step['text'] ); ?></span>
											<?php endif; ?>
										</button>
									</li>
								<?php endforeach; ?>
							</ol>
						</div>
					</div>
				<?php else : ?>
					<ol class="mm-craft-process__steps">
						<?php foreach ( $steps as $step ) : ?>
							<li class="mm-craft-process__step">
								<?php if ( ! empty( $step['title'] ) ) : ?>
									<h3 class="mm-craft-process__title"><?php echo esc_html( $step['title'] ); ?></h3>
								<?php endif; ?>

								<?php if ( ! empty( $step['text'] ) ) : ?>
									<p class="mm-craft-process__text"><?php echo esc_html( $step['text'] ); ?></p>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
