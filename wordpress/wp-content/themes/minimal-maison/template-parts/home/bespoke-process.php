<?php
/**
 * Homepage — Bespoke Process.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$steps = mm_home_process_steps();
?>
<section class="mm-section bg-ivory-200/40">
	<div class="mm-container">
		<div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-20 items-start">
			<div>
				<div class="mm-editorial">
					<h2 class="text-display-sm md:text-display-md mb-6">
						<?php mm_home_text( 'process_heading' ); ?>
					</h2>
					<p class="max-w-copy text-sm md:text-base mb-8">
						<?php mm_home_text( 'process_description' ); ?>
					</p>
				</div>
				<div class="mm-editorial-frame">
					<?php
					echo mm_render_home_image(
						'atelier',
						'process_image',
						array(
							'class' => 'h-72 w-full object-cover object-center md:h-96',
						)
					);
					?>
				</div>
			</div>

			<ol class="space-y-10 md:space-y-12">
				<?php foreach ( $steps as $step ) : ?>
					<li class="mm-process-step">
						<?php if ( ! empty( $step['number'] ) ) : ?>
							<p class="mm-subheading mb-3 text-gold-500"><?php echo esc_html( $step['number'] ); ?></p>
						<?php endif; ?>
						<h3 class="text-xl md:text-2xl mb-3"><?php echo esc_html( $step['title'] ); ?></h3>
						<p class="text-sm md:text-base max-w-copy"><?php echo esc_html( $step['text'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
