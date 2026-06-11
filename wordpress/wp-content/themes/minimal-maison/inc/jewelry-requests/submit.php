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

	$name     = isset( $_POST['mm_request_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_request_name'] ) ) : '';
	$phone    = isset( $_POST['mm_request_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_request_phone'] ) ) : '';
	$email    = isset( $_POST['mm_request_email'] ) ? sanitize_email( wp_unslash( $_POST['mm_request_email'] ) ) : '';
	$type     = isset( $_POST['mm_request_type'] ) ? sanitize_key( wp_unslash( $_POST['mm_request_type'] ) ) : '';
	$budget   = isset( $_POST['mm_request_budget'] ) ? sanitize_key( wp_unslash( $_POST['mm_request_budget'] ) ) : '';
	$details  = isset( $_POST['mm_request_details'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mm_request_details'] ) ) : '';

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

	if ( ! mm_jewelry_request_validate_email( $email ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'invalid_email' ) );
		exit;
	}

	$reference_ids = mm_jewelry_request_handle_reference_uploads();

	if ( is_wp_error( $reference_ids ) ) {
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'upload_' . $reference_ids->get_error_code() ) );
		exit;
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
		mm_jewelry_request_delete_attachments( $reference_ids );
		wp_safe_redirect( mm_jewelry_request_redirect_url( 'error', 'save_failed' ) );
		exit;
	}

	mm_jewelry_request_update_meta( $post_id, 'name', $name );
	mm_jewelry_request_update_meta( $post_id, 'phone', $phone );
	mm_jewelry_request_update_meta( $post_id, 'email', $email );
	mm_jewelry_request_update_meta( $post_id, 'order_type', $type );
	mm_jewelry_request_update_meta( $post_id, 'budget', $budget );
	mm_jewelry_request_update_meta( $post_id, 'details', $details );

	mm_jewelry_request_assign_piece_type( $post_id, $type );
	mm_jewelry_request_assign_budget_range( $post_id, $budget );
	mm_jewelry_request_set_status( $post_id, mm_jewelry_request_default_status() );

	if ( ! empty( $reference_ids ) ) {
		mm_jewelry_request_set_reference_ids( $post_id, $reference_ids );
		mm_jewelry_request_link_attachments_to_request( $post_id, $reference_ids );
	}

	mm_jewelry_request_set_rate_limit();
	mm_jewelry_request_notify_admin( $post_id );
	mm_jewelry_request_fire_created( $post_id, $reference_ids );

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

	$name    = mm_jewelry_request_get_meta( $post_id, 'name' );
	$phone   = mm_jewelry_request_get_meta( $post_id, 'phone' );
	$email   = mm_jewelry_request_get_meta( $post_id, 'email' );
	$type    = mm_jewelry_request_get_piece_type_slug( $post_id );
	$budget  = mm_jewelry_request_get_budget_slug( $post_id );
	$details = mm_jewelry_request_get_meta( $post_id, 'details' );

	$subject = sprintf(
		/* translators: %s: customer name */
		__( 'درخواست سفارش جدید — %s', 'minimal-maison' ),
		$name
	);

	$body  = __( 'درخواست سفارش جدیدی ثبت شد:', 'minimal-maison' ) . "\n\n";
	$body .= __( 'نام:', 'minimal-maison' ) . ' ' . $name . "\n";
	$body .= __( 'تلفن:', 'minimal-maison' ) . ' ' . $phone . "\n";

	if ( '' !== $email ) {
		$body .= __( 'ایمیل:', 'minimal-maison' ) . ' ' . $email . "\n";
	}

	$body .= __( 'نوع سفارش:', 'minimal-maison' ) . ' ' . mm_jewelry_request_order_type_label( $type ) . "\n";
	$body .= __( 'بودجه:', 'minimal-maison' ) . ' ' . mm_jewelry_request_budget_label( $budget ) . "\n";
	$body .= __( 'توضیحات:', 'minimal-maison' ) . "\n" . $details . "\n\n";
	$body .= admin_url( 'post.php?post=' . $post_id . '&action=edit' );

	wp_mail( $admin_email, $subject, $body );

	/**
	 * Fires after the admin notification email is sent for a new request.
	 *
	 * @param int $post_id Request post ID.
	 */
	do_action( 'mm_jewelry_request_notification_sent', $post_id );
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
		'invalid_email'       => __( 'لطفاً یک آدرس ایمیل معتبر وارد کنید.', 'minimal-maison' ),
		'rate_limit'          => __( 'چند لحظه صبر کنید — سپس دوباره ارسال کنید.', 'minimal-maison' ),
		'save_failed'         => __( 'ارسال پیام ناموفق بود. لطفاً دوباره تلاش کنید.', 'minimal-maison' ),
		'upload_too_large'    => __( 'تصویر مرجع کمی بزرگ است — لطفاً تا ۵ مگابایت ارسال کنید.', 'minimal-maison' ),
		'upload_too_many'     => __( 'حداکثر ۵ تصویر مرجع می‌توانید ارسال کنید.', 'minimal-maison' ),
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
