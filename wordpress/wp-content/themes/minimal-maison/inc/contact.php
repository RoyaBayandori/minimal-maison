<?php
/**
 * Maison contact channel URLs for trust links (footer, concierge).
 *
 * Filter keys: instagram, whatsapp, email, phone.
 * Example: add_filter( 'minimal_maison_contact_urls', fn( $u ) => array_merge( $u, [ 'whatsapp' => 'https://wa.me/989...' ] ) );
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Contact channel URLs.
 *
 * @return array<string, string>
 */
function mm_maison_contact_urls(): array {
	$defaults = array(
		'instagram' => '',
		'whatsapp'  => '',
		'email'     => '',
		'phone'     => '',
	);

	return apply_filters( 'minimal_maison_contact_urls', $defaults );
}

/**
 * URL for a single contact channel.
 *
 * @param string $channel instagram|whatsapp|email|phone
 * @return string Escaped URL or empty.
 */
function mm_maison_contact_url( string $channel ): string {
	$urls = mm_maison_contact_urls();
	$url  = isset( $urls[ $channel ] ) ? trim( (string) $urls[ $channel ] ) : '';

	if ( '' === $url ) {
		return '';
	}

	if ( 'email' === $channel && ! str_contains( $url, '://' ) ) {
		$url = 'mailto:' . $url;
	}

	if ( 'phone' === $channel && ! str_contains( $url, '://' ) ) {
		$url = 'tel:' . preg_replace( '/\s+/', '', $url );
	}

	return esc_url( $url );
}

/**
 * Echo a footer channel label as link or plain text.
 *
 * @param string $label Visible label.
 * @param string $url   Channel URL (empty = plain text).
 */
function mm_maison_footer_channel( string $label, string $url ): void {
	if ( $url ) {
		printf(
			'<a href="%1$s" rel="noopener noreferrer">%2$s</a>',
			esc_url( $url ),
			esc_html( $label )
		);
		return;
	}

	echo esc_html( $label );
}
