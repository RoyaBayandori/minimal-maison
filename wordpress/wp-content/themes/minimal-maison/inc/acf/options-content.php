<?php
/**
 * Homepage ACF helpers — business contact and verified customer quote (Front Page).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get a front-page ACF field without copy defaults fallback.
 *
 * @param string $field_name Field name.
 * @param mixed  $default    Default when empty or ACF unavailable.
 * @return mixed
 */
function mm_home_acf_field( string $field_name, $default = '' ) {
	if ( ! mm_acf_available() ) {
		return $default;
	}

	$post_id = mm_homepage_post_id();

	if ( ! $post_id ) {
		return $default;
	}

	$value = get_field( $field_name, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Whether the verified customer quote should render on the homepage.
 *
 * @return bool
 */
function mm_should_show_customer_quote(): bool {
	if ( ! mm_acf_available() ) {
		return false;
	}

	if ( ! (bool) mm_home_acf_field( 'customer_quote_verified', false ) ) {
		return false;
	}

	$quote = trim( (string) mm_home_acf_field( 'customer_quote', '' ) );
	$attr  = trim( (string) mm_home_acf_field( 'customer_quote_attribution', '' ) );

	return '' !== $quote && '' !== $attr;
}

/**
 * Customer quote text for homepage.
 *
 * @return string
 */
function mm_customer_quote_text(): string {
	return trim( (string) mm_home_acf_field( 'customer_quote', '' ) );
}

/**
 * Customer quote attribution for homepage.
 *
 * @return string
 */
function mm_customer_quote_attribution(): string {
	return trim( (string) mm_home_acf_field( 'customer_quote_attribution', '' ) );
}

/**
 * Business contact values from the Front Page (may be empty).
 *
 * @return array{instagram: string, whatsapp: string, email: string, phone: string}
 */
function mm_home_contact_field_values(): array {
	return array(
		'instagram' => trim( (string) mm_home_acf_field( 'instagram_url', '' ) ),
		'whatsapp'  => trim( (string) mm_home_acf_field( 'whatsapp_url', '' ) ),
		'email'     => trim( (string) mm_home_acf_field( 'email', '' ) ),
		'phone'     => trim( (string) mm_home_acf_field( 'phone_number', '' ) ),
	);
}
