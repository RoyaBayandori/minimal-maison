<?php
/**
 * Homepage — Craft Process editorial timeline.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$steps       = mm_home_craft_steps();
$eyebrow     = trim( (string) mm_home_acf_value( 'craft_eyebrow' ) );
$heading     = trim( (string) mm_home_acf_value( 'craft_heading' ) );
$description = trim( (string) mm_home_acf_value( 'craft_description' ) );
?>
<section class="mm-craft-process" <?php echo '' !== $heading ? 'aria-labelledby="craft-process-heading"' : ''; ?>>
	<div class="mm-container">
		<?php if ( '' !== $eyebrow || '' !== $heading || '' !== $description ) : ?>
			<header class="mm-craft-process__header mm-editorial">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="mm-craft-process__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

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
			<ol class="mm-craft-process__timeline">
				<?php foreach ( $steps as $step ) : ?>
					<li class="mm-craft-process__step">
						<div class="mm-craft-process__marker" aria-hidden="true">
							<?php if ( ! empty( $step['number'] ) ) : ?>
								<span class="mm-craft-process__number"><?php echo esc_html( $step['number'] ); ?></span>
							<?php endif; ?>
						</div>

						<div class="mm-craft-process__content mm-editorial">
							<?php if ( ! empty( $step['title'] ) ) : ?>
								<h3 class="mm-craft-process__title"><?php echo esc_html( $step['title'] ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $step['text'] ) ) : ?>
								<p class="mm-craft-process__text"><?php echo esc_html( $step['text'] ); ?></p>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	</div>
</section>
