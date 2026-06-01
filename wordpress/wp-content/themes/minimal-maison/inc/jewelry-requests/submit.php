<?php
/**
 * Jewelry request form submission handler.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register admin-post handlers for form submission.
 */
function mm_jewelry_request_register_handlers(): void {
	add_action( 'admin_post_nopriv_mm_submit_jewelry_request', 'mm_jewelry_request_handle_submit' );
	add_action( 'admin_post_mm_submit_jewelry_request', 'mm_jewelry_request_handle_submit' );
}
add_action( 'init', 'mm_jewelry_request_register_handlers' );

/**
 * Process a jewelry request form submission.
 */
function mm_jewelry_request_handle_submit(): void {
	if ( ! isset( $_POST['mm_jewelry_request_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mm_jewelry_request_nonce'] ) ), 'mm_jewelry_request' ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'invalid_nonce' ) );
		exit;
	}

	// Honeypot — bots fill hidden fields.
	if ( ! empty( $_POST['mm_request_website'] ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'success' ) );
		exit;
	}

	if ( ! mm_jewelry_request_check_rate_limit() ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'rate_limit' ) );
		exit;
	}

	$name    = isset( $_POST['mm_request_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_request_name'] ) ) : '';
	$phone   = isset( $_POST['mm_request_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_request_phone'] ) ) : '';
	$whatsapp = isset( $_POST['mm_request_whatsapp'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_request_whatsapp'] ) ) : '';
	$type    = isset( $_POST['mm_request_type'] ) ? sanitize_key( wp_unslash( $_POST['mm_request_type'] ) ) : '';
	$budget  = isset( $_POST['mm_request_budget'] ) ? sanitize_key( wp_unslash( $_POST['mm_request_budget'] ) ) : '';
	$details = isset( $_POST['mm_request_details'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mm_request_details'] ) ) : '';

	$order_types = mm_jewelry_request_order_types();
	$budgets     = mm_jewelry_request_budget_ranges();

	if ( '' === $name || '' === $phone || '' === $type || '' === $budget || '' === $details ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'required' ) );
		exit;
	}

	if ( ! isset( $order_types[ $type ] ) || ! isset( $budgets[ $budget ] ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'invalid_fields' ) );
		exit;
	}

	if ( ! mm_jewelry_request_validate_phone( $phone ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'invalid_phone' ) );
		exit;
	}

	if ( '' !== $whatsapp && ! mm_jewelry_request_validate_phone( $whatsapp ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'invalid_whatsapp' ) );
		exit;
	}

	$reference_id = 0;

	if ( ! empty( $_FILES['mm_request_reference']['name'] ) ) {
		$upload = mm_jewelry_request_handle_reference_upload();

		if ( is_wp_error( $upload ) ) {
			wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'upload_' . $upload->get_error_code() ) );
			exit;
		}

		$reference_id = (int) $upload;
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'mm_jewelry_request',
			'post_status' => 'publish',
			'post_title'  => sprintf(
				/* translators: 1: customer name, 2: order type label */
				__( '%1$s — %2$s', 'minimal-maison' ),
				$name,
				mm_jewelry_request_order_type_label( $type )
			),
		),
		true
	);

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'save_failed' ) );
		exit;
	}

	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'name', $name );
	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'phone', $phone );
	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'whatsapp', $whatsapp );
	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'order_type', $type );
	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'budget', $budget );
	update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'details', $details );

	if ( $reference_id ) {
		update_post_meta( $post_id, MM_JEWELRY_REQUEST_META_PREFIX . 'reference_id', $reference_id );
		wp_update_post(
			array(
				'ID'          => $reference_id,
				'post_parent' => $post_id,
			)
		);
	}

	mm_jewelry_request_set_rate_limit();
	mm_jewelry_request_notify_admin( $post_id );

	wp_safe_redirect( mm_jewelry_request_redirect_url( 'success' ) );
	exit;
}

/**
 * Validate Iranian mobile/phone format (digits, optional leading zero).
 *
 * @param string $phone Phone number.
 * @return bool
 */
function mm_jewelry_request_validate_phone( string $phone ): bool {
	$digits = preg_replace( '/\D/', '', $phone );

	return (bool) preg_match( '/^0?9\d{9}$/', $digits );
}

/**
 * Handle reference image upload.
 *
 * @return int|\WP_Error Attachment ID or error.
 */
function mm_jewelry_request_handle_reference_upload() {
	if ( empty( $_FILES['mm_request_reference'] ) || ! is_array( $_FILES['mm_request_reference'] ) ) {
		return new WP_Error( 'no_file', __( 'فایلی ارسال نشده است.', 'minimal-maison' ) );
	}

	$file = $_FILES['mm_request_reference'];

	if ( UPLOAD_ERR_NO_FILE === (int) $file['error'] ) {
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
 * Simple rate limit: one submission per IP per 60 seconds.
 *
 * @return bool
 */
function mm_jewelry_request_check_rate_limit(): bool {
	$ip  = mm_jewelry_request_client_ip();
	$key = 'mm_jr_' . md5( $ip );

	return false === get_transient( $key );
}

/**
 * Set rate limit transient after successful submission.
 */
function mm_jewelry_request_set_rate_limit(): void {
	$ip  = mm_jewelry_request_client_ip();
	$key = 'mm_jr_' . md5( $ip );

	set_transient( $key, 1, MINUTE_IN_SECONDS );
}

/**
 * Get client IP for rate limiting.
 *
 * @return string
 */
function mm_jewelry_request_client_ip(): string {
	$ip = '';

	if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}

	return $ip;
}

/**
 * Send admin email notification for a new request.
 *
 * @param int $post_id Request post ID.
 */
function mm_jewelry_request_notify_admin( int $post_id ): void {
	$admin_email = get_option( 'admin_email' );

	if ( ! $admin_email ) {
		return;
	}

	$name     = mm_jewelry_request_get_meta( $post_id, 'name' );
	$phone    = mm_jewelry_request_get_meta( $post_id, 'phone' );
	$whatsapp = mm_jewelry_request_get_meta( $post_id, 'whatsapp' );
	$type     = mm_jewelry_request_get_meta( $post_id, 'order_type' );
	$budget   = mm_jewelry_request_get_meta( $post_id, 'budget' );
	$details  = mm_jewelry_request_get_meta( $post_id, 'details' );

	$subject = sprintf(
		/* translators: %s: customer name */
		__( 'درخواست سفارش جدید — %s', 'minimal-maison' ),
		$name
	);

	$body  = __( 'درخواست سفارش جدیدی ثبت شد:', 'minimal-maison' ) . "\n\n";
	$body .= __( 'نام:', 'minimal-maison' ) . ' ' . $name . "\n";
	$body .= __( 'تلفن:', 'minimal-maison' ) . ' ' . $phone . "\n";

	if ( $whatsapp ) {
		$body .= __( 'واتساپ:', 'minimal-maison' ) . ' ' . $whatsapp . "\n";
	}

	$body .= __( 'نوع سفارش:', 'minimal-maison' ) . ' ' . mm_jewelry_request_order_type_label( $type ) . "\n";
	$body .= __( 'بودجه:', 'minimal-maison' ) . ' ' . mm_jewelry_request_budget_label( $budget ) . "\n";
	$body .= __( 'توضیحات:', 'minimal-maison' ) . "\n" . $details . "\n\n";
	$body .= admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	wp_mail( $admin_email, $subject, $body );
}

/**
 * User-facing error message for a submission error code.
 *
 * @param string $code Error code from query string.
 * @return string
 */
function mm_jewelry_request_error_message( string $code ): string {
	$messages = array(
		'invalid_nonce'       => __( 'این صفحه کمی قدیمی شده — لطفاً یک‌بار دیگر تلاش کنید.', 'minimal-maison' ),
		'required'            => __( 'چند پرسش باقی مانده — لطفاً موارد ستاره‌دار را تکمیل کنید.', 'minimal-maison' ),
		'invalid_fields'      => __( 'لطفاً گزینه‌ها را دوباره انتخاب کنید.', 'minimal-maison' ),
		'invalid_phone'       => __( 'شماره موبایل ۱۱ رقمی (مثال ۰۹۱۲…) را بررسی کنید.', 'minimal-maison' ),
		'invalid_whatsapp'    => __( 'شماره واتساپ را بررسی کنید.', 'minimal-maison' ),
		'rate_limit'          => __( 'چند لحظه صبر کنید — سپس دوباره ارسال کنید.', 'minimal-maison' ),
		'save_failed'         => __( 'ارسال پیام ناموفق بود. لطفاً دوباره تلاش کنید.', 'minimal-maison' ),
		'upload_too_large'    => __( 'تصویر مرجع کمی بزرگ است — لطفاً تا ۵ مگابایت ارسال کنید.', 'minimal-maison' ),
		'upload_invalid_type' => __( 'لطفاً تصویری با فرمت رایج (مثل JPG) ارسال کنید.', 'minimal-maison' ),
	);

	if ( str_starts_with( $code, 'upload_' ) ) {
		$upload_code = substr( $code, 7 );

		if ( isset( $messages[ 'upload_' . $upload_code ] ) ) {
			return $messages[ 'upload_' . $upload_code ];
		}

		return __( 'افزودن تصویر ممکن نشد — می‌توانید بدون تصویر ادامه دهید و در تماس بفرستید.', 'minimal-maison' );
	}

	return $messages[ $code ] ?? __( 'متأسفیم — لطفاً یک‌بار دیگر ارسال کنید، یا مستقیم با کارگاه تماس بگیرید.', 'minimal-maison' );
}
