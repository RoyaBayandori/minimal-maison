<?php
/**
 * Footer content helpers — Front Page ACF fields.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Trimmed footer field value from the homepage ACF group.
 *
 * @param string $field_name ACF field name.
 * @return string
 */
function mm_footer_acf_value( string $field_name ): string {
	return trim( (string) mm_home_acf_field( $field_name, '' ) );
}

/**
 * Footer brand description from CMS.
 *
 * @return string
 */
function mm_footer_brand_text(): string {
	return mm_footer_acf_value( 'footer_brand_text' );
}

/**
 * Whether the footer brand description should render.
 *
 * @return bool
 */
function mm_footer_has_brand_text(): bool {
	return '' !== mm_footer_brand_text();
}

/**
 * Build a tel: URL for a footer phone value.
 *
 * @param string $phone Phone number from CMS.
 * @return string
 */
function mm_footer_phone_url( string $phone ): string {
	$normalized = preg_replace( '/\s+/', '', $phone );

	if ( '' === $normalized ) {
		return '';
	}

	return 'tel:' . $normalized;
}

/**
 * Build a mailto: URL for a footer email value.
 *
 * @param string $email Email address from CMS.
 * @return string
 */
function mm_footer_email_url( string $email ): string {
	if ( '' === $email ) {
		return '';
	}

	return 'mailto:' . $email;
}

/**
 * Contact column lines for the footer (address, phone, email).
 *
 * @return array<int, array{label: string, url: string, multiline: bool}>
 */
function mm_footer_contact_lines(): array {
	$lines   = array();
	$address = mm_footer_acf_value( 'footer_address' );

	if ( '' !== $address ) {
		$lines[] = array(
			'label'     => $address,
			'url'       => '',
			'multiline' => true,
		);
	}

	$phone = mm_footer_acf_value( 'footer_phone' );

	if ( '' !== $phone ) {
		$lines[] = array(
			'label'     => $phone,
			'url'       => mm_footer_phone_url( $phone ),
			'multiline' => false,
		);
	}

	$email = mm_footer_acf_value( 'footer_email' );

	if ( '' !== $email ) {
		$lines[] = array(
			'label'     => $email,
			'url'       => mm_footer_email_url( $email ),
			'multiline' => false,
		);
	}

	return $lines;
}

/**
 * Whether the footer contact column should render.
 *
 * @return bool
 */
function mm_footer_has_contact_lines(): bool {
	return ! empty( mm_footer_contact_lines() );
}

/**
 * Social links for the footer from CMS.
 *
 * @return array<int, array{label: string, url: string}>
 */
function mm_footer_social_links(): array {
	$channels = array(
		'footer_instagram' => __( 'اینستاگرام', 'minimal-maison' ),
		'footer_whatsapp'  => __( 'واتساپ', 'minimal-maison' ),
		'footer_telegram'  => __( 'تلگرام', 'minimal-maison' ),
		'footer_linkedin'  => __( 'لینکدین', 'minimal-maison' ),
	);
	$links    = array();

	foreach ( $channels as $field_name => $label ) {
		$url = esc_url( mm_footer_acf_value( $field_name ) );

		if ( '' === $url ) {
			continue;
		}

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $links;
}

/**
 * Whether the footer social column should render.
 *
 * @return bool
 */
function mm_footer_has_social_links(): bool {
	return ! empty( mm_footer_social_links() );
}

/**
 * Large-screen footer grid column count based on visible columns.
 *
 * @return int
 */
function mm_footer_grid_column_count(): int {
	$count = 1;

	if ( mm_footer_has_contact_lines() ) {
		++$count;
	}

	if ( has_nav_menu( 'footer' ) || mm_footer_has_social_links() ) {
		++$count;
	}

	return $count;
}
