<?php
/**
 * Homepage — Brand Philosophy manifesto section.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_should_show_philosophy() ) {
	return;
}

$paragraphs   = mm_home_philosophy_paragraphs();
$heading      = trim( (string) mm_home_acf_value( 'philosophy_heading' ) );
$eyebrow      = trim( (string) mm_home_acf_value( 'philosophy_eyebrow' ) );
$image_markup = mm_render_home_option_image(
	'philosophy_image',
	array(
		'class' => 'mm-philosophy__image',
	),
	'full',
	'(min-width: 1024px) 62vw, 100vw'
);

$section_labelledby = '' !== $heading ? 'philosophy-heading' : '';
?>
<section
	class="mm-philosophy mm-philosophy--manifesto"
	<?php echo '' !== $section_labelledby ? 'aria-labelledby="' . esc_attr( $section_labelledby ) . '"' : ''; ?>
>
	<div class="mm-container">
		<div class="mm-philosophy__composition mm-editorial">
			<div class="mm-philosophy__content">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="mm-philosophy__eyebrow"><?php mm_home_acf_text( 'philosophy_eyebrow' ); ?></p>
				<?php endif; ?>

				<?php if ( '' !== $heading ) : ?>
					<h2 id="philosophy-heading" class="mm-philosophy__heading">
						<?php mm_home_acf_text( 'philosophy_heading' ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( ! empty( $paragraphs ) ) : ?>
					<div class="mm-philosophy__body">
						<?php foreach ( $paragraphs as $paragraph ) : ?>
							<p><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( '' !== $image_markup ) : ?>
				<figure class="mm-philosophy__figure">
					<?php echo $image_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image ?>
				</figure>
			<?php endif; ?>
		</div>
	</div>
</section>
