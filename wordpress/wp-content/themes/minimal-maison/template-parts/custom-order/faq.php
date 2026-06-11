<?php
/**
 * Custom Order — FAQ accordion section.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_co_should_show_faq() ) {
	return;
}

$items = mm_co_faq_items();
?>
<section class="mm-custom-order-faq" aria-labelledby="mm-custom-order-faq-heading">
	<div class="mm-custom-order-faq__frame mm-container">
		<header class="mm-custom-order-faq__header mm-editorial" dir="rtl">
			<h2 id="mm-custom-order-faq-heading" class="mm-custom-order-faq__heading">
				<?php mm_co_text( 'co_faq_heading' ); ?>
			</h2>
		</header>

		<div class="mm-custom-order-faq__list">
			<?php foreach ( $items as $index => $item ) : ?>
				<?php
				$panel_id  = 'mm-custom-order-faq-panel-' . (int) $index;
				$trigger_id = 'mm-custom-order-faq-trigger-' . (int) $index;
				?>
				<div class="mm-custom-order-faq__item">
					<h3 class="mm-custom-order-faq__question-wrap">
						<button
							type="button"
							class="mm-custom-order-faq__trigger"
							id="<?php echo esc_attr( $trigger_id ); ?>"
							aria-expanded="false"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>"
						>
							<span class="mm-custom-order-faq__question"><?php echo esc_html( $item['question'] ); ?></span>
							<span class="mm-custom-order-faq__icon" aria-hidden="true"></span>
						</button>
					</h3>
					<div
						class="mm-custom-order-faq__panel"
						id="<?php echo esc_attr( $panel_id ); ?>"
						role="region"
						aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>"
						hidden
					>
						<div class="mm-custom-order-faq__answer mm-editorial" dir="rtl">
							<?php echo nl2br( esc_html( $item['answer'] ) ); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
