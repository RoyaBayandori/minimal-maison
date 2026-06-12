<?php
/**
 * Date helpers — Jalali display for Persian UI.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Convert Western digits to Persian digits.
 */
function mm_to_persian_digits( string $value ): string {
	$western = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );

	return str_replace( $western, $persian, $value );
}

/**
 * Convert a Gregorian date to Jalali [year, month, day].
 *
 * @return array{0: int, 1: int, 2: int}
 */
function mm_gregorian_to_jalali( int $gy, int $gm, int $gd ): array {
	$g_d_m = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
	$gy2   = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;
	$days  = 355666 + ( 365 * $gy ) + intdiv( $gy2 + 3, 4 ) - intdiv( $gy2 + 99, 100 ) + intdiv( $gy2 + 399, 400 ) + $gd + $g_d_m[ $gm - 1 ];
	$jy    = -1595 + ( 33 * intdiv( $days, 12053 ) );
	$days %= 12053;
	$jy   += 4 * intdiv( $days, 1461 );
	$days %= 1461;

	if ( $days > 365 ) {
		$jy   += intdiv( $days - 1, 365 );
		$days  = ( $days - 1 ) % 365;
	}

	if ( $days < 186 ) {
		$jm = 1 + intdiv( $days, 31 );
		$jd = 1 + ( $days % 31 );
	} else {
		$jm = 7 + intdiv( $days - 186, 30 );
		$jd = 1 + ( ( $days - 186 ) % 30 );
	}

	return array( $jy, $jm, $jd );
}

/**
 * Jalali creation year for display from a post date.
 */
function mm_jalali_year_from_post( WP_Post $post ): string {
	$timestamp = get_post_timestamp( $post );

	if ( false === $timestamp ) {
		return '';
	}

	$gy = (int) gmdate( 'Y', $timestamp );
	$gm = (int) gmdate( 'n', $timestamp );
	$gd = (int) gmdate( 'j', $timestamp );

	$jalali = mm_gregorian_to_jalali( $gy, $gm, $gd );

	return mm_to_persian_digits( (string) (int) $jalali[0] );
}
