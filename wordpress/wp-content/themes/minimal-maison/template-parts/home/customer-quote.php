<?php
/**
 * Homepage — single customer quote (process → request interlude).
 *
 * Rendered only when the Home page has a verified, client-approved quote.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

if ( ! mm_should_show_customer_quote() ) {
	return;
}

$quote_text  = mm_customer_quote_text();
$attribution = mm_customer_quote_attribution();
?>
<div class="mm-customer-quote">
	<div class="mm-container">
		<figure class="mm-customer-quote__inner mm-editorial">
			<blockquote class="mm-customer-quote__text">
				<p><?php echo esc_html( $quote_text ); ?></p>
			</blockquote>
			<figcaption class="mm-customer-quote__attribution">
				<?php echo esc_html( $attribution ); ?>
			</figcaption>
		</figure>
	</div>
</div>
