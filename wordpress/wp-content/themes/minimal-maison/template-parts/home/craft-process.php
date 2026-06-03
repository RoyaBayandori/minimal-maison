<?php
/**
 * Homepage — How It Works (Craft Process editorial register).
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

?>
<section class="mm-craft-process" <?php echo '' !== $heading ? 'aria-labelledby="craft-process-heading"' : ''; ?>>
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
		</div>
	</div>
</section>
