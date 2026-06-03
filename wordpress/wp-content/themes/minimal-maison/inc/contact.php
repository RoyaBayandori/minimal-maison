<?php
/**
 * Maison contact channel URLs for trust links (footer, concierge).
 *
 * Priority: Front Page ACF fields → environment variables → filter `minimal_maison_contact_urls`.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Read a trimmed environment variable.
 *
 * @param string $name Environment variable name.
 * @return string
 */
function mm_maison_env_string( string $name ): string {
	$value = getenv( $name );

	if ( false === $value || ! is_string( $value ) ) {
		return '';
	}

	return trim( $value );
}

/**
 * Build a WhatsApp deep link from a URL or phone string.
 *
 * @param string $value Full wa.me URL or phone number.
 * @return string
 */
function mm_maison_whatsapp_url_from_value( string $value ): string {
	$value = trim( $value );

	if ( '' === $value ) {
		return '';
	}

	if ( str_contains( $value, 'wa.me' ) || str_contains( $value, 'whatsapp.com' ) ) {
		return esc_url( $value );
	}

	if ( preg_match( '#^https?://#i', $value ) ) {
		return esc_url( $value );
	}

	$digits = preg_replace( '/\D+/', '', $value );

	if ( '' === $digits ) {
		return '';
	}

	if ( str_starts_with( $digits, '0' ) ) {
		$digits = '98' . substr( $digits, 1 );
	}

	return 'https://wa.me/' . $digits;
}

/**
 * Build a WhatsApp deep link from MM_WHATSAPP_URL or MM_WHATSAPP_PHONE.
 *
 * @return string
 */
function mm_maison_whatsapp_url_from_env(): string {
	$url = mm_maison_env_string( 'MM_WHATSAPP_URL' );

	if ( '' !== $url ) {
		return mm_maison_whatsapp_url_from_value( $url );
	}

	return mm_maison_whatsapp_url_from_value( mm_maison_env_string( 'MM_WHATSAPP_PHONE' ) );
}

/**
 * Contact channel URLs from environment variables only.
 *
 * @return array<string, string>
 */
function mm_maison_contact_urls_from_env(): array {
	$urls = array(
		'instagram' => '',
		'whatsapp'  => mm_maison_whatsapp_url_from_env(),
		'email'     => '',
		'phone'     => '',
	);

	$env_map = array(
		'instagram' => 'MM_INSTAGRAM_URL',
		'whatsapp'  => 'MM_WHATSAPP_URL',
		'email'     => 'MM_CONTACT_EMAIL',
		'phone'     => 'MM_CONTACT_PHONE',
	);

	foreach ( $env_map as $channel => $env_key ) {
		$env_value = mm_maison_env_string( $env_key );

		if ( '' === $env_value ) {
			continue;
		}

		if ( 'whatsapp' === $channel ) {
			$urls['whatsapp'] = mm_maison_whatsapp_url_from_value( $env_value );
			continue;
		}

		$urls[ $channel ] = $env_value;
	}

	if ( '' === $urls['whatsapp'] ) {
		$urls['whatsapp'] = mm_maison_whatsapp_url_from_env();
	}

	return $urls;
}

/**
 * Merge non-empty contact values into the target array.
 *
 * @param array<string, string> $target Target URLs.
 * @param array<string, string> $source Source URLs.
 * @return array<string, string>
 */
function mm_maison_merge_contact_urls( array $target, array $source ): array {
	foreach ( $source as $channel => $value ) {
		$value = trim( (string) $value );

		if ( '' !== $value ) {
			$target[ $channel ] = $value;
		}
	}

	return $target;
}

/**
 * Contact channel URLs from Front Page ACF (Business Information).
 *
 * @return array<string, string>
 */
function mm_maison_contact_urls_from_acf(): array {
	$urls = array(
		'instagram' => '',
		'whatsapp'  => '',
		'email'     => '',
		'phone'     => '',
	);

	if ( ! mm_acf_available() ) {
		return $urls;
	}

	$options = mm_home_contact_field_values();

	if ( '' !== $options['instagram'] ) {
		$urls['instagram'] = esc_url( $options['instagram'] );
	}

	if ( '' !== $options['whatsapp'] ) {
		$urls['whatsapp'] = mm_maison_whatsapp_url_from_value( $options['whatsapp'] );
	}

	if ( '' !== $options['email'] ) {
		$urls['email'] = sanitize_email( $options['email'] );
	}

	if ( '' !== $options['phone'] ) {
		$urls['phone'] = $options['phone'];
	}

	return $urls;
}

/**
 * Contact channel URLs.
 *
 * @return array<string, string>
 */
function mm_maison_contact_urls(): array {
	$urls = mm_maison_contact_urls_from_env();
	$urls = mm_maison_merge_contact_urls( $urls, mm_maison_contact_urls_from_acf() );

	return apply_filters( 'minimal_maison_contact_urls', $urls );
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
 * Whether a contact URL should open in a new tab.
 *
 * @param string $url Resolved channel URL.
 * @return bool
 */
function mm_maison_contact_opens_externally( string $url ): bool {
	return str_starts_with( $url, 'http://' ) || str_starts_with( $url, 'https://' );
}

/**
 * target/rel attributes for external contact links.
 *
 * @param string $url Resolved channel URL.
 * @return string HTML attribute fragment (leading space) or empty.
 */
function mm_maison_contact_link_attrs( string $url ): string {
	if ( ! mm_maison_contact_opens_externally( $url ) ) {
		return '';
	}

	return ' target="_blank" rel="noopener noreferrer"';
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
			'<a href="%1$s"%2$s>%3$s</a>',
			esc_url( $url ),
			mm_maison_contact_link_attrs( $url ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_html( $label )
		);
		return;
	}

	echo esc_html( $label );
}
