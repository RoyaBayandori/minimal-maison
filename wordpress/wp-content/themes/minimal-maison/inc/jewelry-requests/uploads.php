<?php
/**
 * Jewelry request reference image uploads.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Process multiple reference image uploads from the request form.
 *
 * @return int[]|\WP_Error Attachment IDs in upload order.
 */
function mm_jewelry_request_handle_reference_uploads() {
	if ( empty( $_FILES['mm_request_references'] ) || ! is_array( $_FILES['mm_request_references'] ) ) {
		return array();
	}

	$files = mm_jewelry_request_normalize_uploaded_files( $_FILES['mm_request_references'] );

	if ( empty( $files ) ) {
		return array();
	}

	$max_count = mm_jewelry_request_max_reference_count();

	if ( count( $files ) > $max_count ) {
		return new WP_Error( 'too_many', __( 'تعداد تصاویر بیش از حد مجاز است.', 'minimal-maison' ) );
	}

	$attachment_ids = array();

	foreach ( $files as $file ) {
		$upload = mm_jewelry_request_handle_single_reference_upload( $file );

		if ( is_wp_error( $upload ) ) {
			mm_jewelry_request_delete_attachments( $attachment_ids );

			return $upload;
		}

		if ( $upload > 0 ) {
			$attachment_ids[] = $upload;
		}
	}

	return $attachment_ids;
}

/**
 * Normalize a multi-file $_FILES entry into a list of single-file arrays.
 *
 * @param array<string, mixed> $file_entry Raw $_FILES entry.
 * @return array<int, array<string, mixed>>
 */
function mm_jewelry_request_normalize_uploaded_files( array $file_entry ): array {
	if ( empty( $file_entry['name'] ) ) {
		return array();
	}

	if ( ! is_array( $file_entry['name'] ) ) {
		return array( $file_entry );
	}

	$files  = array();
	$names  = $file_entry['name'];
	$types  = $file_entry['type'] ?? array();
	$tmp    = $file_entry['tmp_name'] ?? array();
	$errors = $file_entry['error'] ?? array();
	$sizes  = $file_entry['size'] ?? array();

	foreach ( $names as $index => $name ) {
		if ( '' === (string) $name ) {
			continue;
		}

		$files[] = array(
			'name'     => $name,
			'type'     => $types[ $index ] ?? '',
			'tmp_name' => $tmp[ $index ] ?? '',
			'error'    => $errors[ $index ] ?? UPLOAD_ERR_NO_FILE,
			'size'     => $sizes[ $index ] ?? 0,
		);
	}

	return $files;
}

/**
 * Handle a single reference image upload.
 *
 * @param array<string, mixed> $file Single-file $_FILES shape.
 * @return int|\WP_Error Attachment ID or error.
 */
function mm_jewelry_request_handle_single_reference_upload( array $file ) {
	if ( UPLOAD_ERR_NO_FILE === (int) ( $file['error'] ?? UPLOAD_ERR_NO_FILE ) ) {
		return 0;
	}

	if ( UPLOAD_ERR_OK !== (int) $file['error'] ) {
		return new WP_Error( 'upload_error', __( 'خطا در آپلود فایل.', 'minimal-maison' ) );
	}

	if ( (int) $file['size'] > mm_jewelry_request_max_upload_bytes() ) {
		return new WP_Error( 'too_large', __( 'حجم فایل بیش از حد مجاز است.', 'minimal-maison' ) );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	add_filter( 'upload_mimes', 'mm_jewelry_request_filter_upload_mimes' );

	$overrides = array(
		'test_form' => false,
		'mimes'     => mm_jewelry_request_allowed_mimes(),
	);

	$uploaded = wp_handle_upload( $file, $overrides );

	remove_filter( 'upload_mimes', 'mm_jewelry_request_filter_upload_mimes' );

	if ( isset( $uploaded['error'] ) ) {
		return new WP_Error( 'upload_failed', $uploaded['error'] );
	}

	$filetype = wp_check_filetype( basename( $uploaded['file'] ), mm_jewelry_request_allowed_mimes() );

	if ( empty( $filetype['type'] ) ) {
		wp_delete_file( $uploaded['file'] );

		return new WP_Error( 'invalid_type', __( 'فرمت فایل مجاز نیست.', 'minimal-maison' ) );
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_file_name( basename( $uploaded['file'] ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$uploaded['file']
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		return new WP_Error( 'attachment_failed', __( 'ذخیره تصویر ناموفق بود.', 'minimal-maison' ) );
	}

	wp_generate_attachment_metadata( $attachment_id, $uploaded['file'] );

	return (int) $attachment_id;
}

/**
 * Restrict upload MIME types for reference images.
 *
 * @param array<string, string> $mimes Allowed MIME types.
 * @return array<string, string>
 */
function mm_jewelry_request_filter_upload_mimes( array $mimes ): array {
	return array_merge( $mimes, mm_jewelry_request_allowed_mimes() );
}

/**
 * Delete uploaded attachments (used when submission fails).
 *
 * @param int[] $attachment_ids Attachment IDs.
 */
function mm_jewelry_request_delete_attachments( array $attachment_ids ): void {
	foreach ( $attachment_ids as $attachment_id ) {
		$attachment_id = (int) $attachment_id;

		if ( $attachment_id > 0 ) {
			wp_delete_attachment( $attachment_id, true );
		}
	}
}

/**
 * Link reference attachments to a request post.
 *
 * @param int   $post_id        Request post ID.
 * @param int[] $attachment_ids Attachment IDs.
 */
function mm_jewelry_request_link_attachments_to_request( int $post_id, array $attachment_ids ): void {
	foreach ( $attachment_ids as $attachment_id ) {
		$attachment_id = (int) $attachment_id;

		if ( $attachment_id <= 0 ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'          => $attachment_id,
				'post_parent' => $post_id,
			)
		);
	}
}
