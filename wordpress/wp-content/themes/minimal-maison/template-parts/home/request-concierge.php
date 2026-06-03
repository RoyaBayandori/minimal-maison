<?php
/**
 * Homepage — concierge line before request intro.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$whatsapp_url = mm_maison_contact_url( 'whatsapp' );
?>
<div class="mm-request-concierge">
	<p class="mm-request-concierge__line">
		<?php
		if ( $whatsapp_url ) {
			$whatsapp_link = sprintf(
				'<a href="%1$s" class="mm-request-concierge__link"%3$s>%2$s</a>',
				esc_url( $whatsapp_url ),
				esc_html__( 'واتساپ', 'minimal-maison' ),
				mm_maison_contact_link_attrs( $whatsapp_url ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);

			echo wp_kses(
				sprintf(
					/* translators: %s: linked label for WhatsApp */
					__( 'برای شروع، فرم کوتاه زیر را بگذارید — یا از طریق %s با کارگاه در ارتباط باشید.', 'minimal-maison' ),
					$whatsapp_link
				),
				array(
					'a' => array(
						'href'   => array(),
						'class'  => array(),
						'rel'    => array(),
						'target' => array(),
					),
				)
			);
		} else {
			esc_html_e( 'برای شروع، فرم کوتاه زیر را بگذارید — یا از طریق واتساپ با کارگاه در ارتباط باشید.', 'minimal-maison' );
		}
		?>
	</p>
	<p class="mm-request-concierge__line">
		<?php esc_html_e( 'معمولاً ظرف یک تا دو روز کاری هماهنگ می‌کنیم.', 'minimal-maison' ); ?>
	</p>
</div>
