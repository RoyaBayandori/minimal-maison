<?php
/**
 * Custom Order — Request form (mockup layout).
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$order_types = mm_jewelry_request_order_types();
$budgets     = mm_jewelry_request_budget_ranges();
?>
<form
	class="mm-request-form mm-custom-order-request-form"
	method="post"
	action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
	enctype="multipart/form-data"
	dir="rtl"
	novalidate
>
	<input type="hidden" name="action" value="mm_submit_jewelry_request">
	<?php wp_nonce_field( 'mm_jewelry_request', 'mm_jewelry_request_nonce' ); ?>

	<div class="mm-form-honeypot" aria-hidden="true">
		<label for="mm_request_website"><?php esc_html_e( 'وب‌سایت', 'minimal-maison' ); ?></label>
		<input type="text" name="mm_request_website" id="mm_request_website" tabindex="-1" autocomplete="off">
	</div>

	<div class="mm-custom-order-request-form__fields">
		<div class="mm-custom-order-request-form__row">
			<div class="mm-form-field">
				<label class="mm-form-label sr-only" for="mm_request_name">
					<?php esc_html_e( 'نام و نام خانوادگی', 'minimal-maison' ); ?>
					<span class="mm-form-required" aria-hidden="true">*</span>
				</label>
				<input
					class="mm-form-input"
					type="text"
					name="mm_request_name"
					id="mm_request_name"
					required
					autocomplete="name"
					placeholder="<?php esc_attr_e( 'نام و نام خانوادگی', 'minimal-maison' ); ?>"
				>
			</div>

			<div class="mm-form-field">
				<label class="mm-form-label sr-only" for="mm_request_phone">
					<?php esc_html_e( 'شماره واتساپ', 'minimal-maison' ); ?>
					<span class="mm-form-required" aria-hidden="true">*</span>
				</label>
				<input
					class="mm-form-input"
					type="tel"
					name="mm_request_phone"
					id="mm_request_phone"
					required
					inputmode="tel"
					autocomplete="tel"
					placeholder="<?php esc_attr_e( 'شماره واتساپ', 'minimal-maison' ); ?>"
				>
			</div>
		</div>

		<div class="mm-custom-order-request-form__row">
			<div class="mm-form-field">
				<label class="mm-form-label sr-only" for="mm_request_type">
					<?php esc_html_e( 'نوع قطعه', 'minimal-maison' ); ?>
					<span class="mm-form-required" aria-hidden="true">*</span>
				</label>
				<select class="mm-form-select" name="mm_request_type" id="mm_request_type" required>
					<option value=""><?php esc_html_e( 'نوع قطعه', 'minimal-maison' ); ?></option>
					<?php foreach ( $order_types as $slug => $label ) : ?>
						<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="mm-form-field">
				<label class="mm-form-label sr-only" for="mm_request_budget">
					<?php esc_html_e( 'بودجه تقریبی', 'minimal-maison' ); ?>
					<span class="mm-form-required" aria-hidden="true">*</span>
				</label>
				<select class="mm-form-select" name="mm_request_budget" id="mm_request_budget" required>
					<option value=""><?php esc_html_e( 'بودجه تقریبی', 'minimal-maison' ); ?></option>
					<?php foreach ( $budgets as $slug => $label ) : ?>
						<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="mm-form-field">
			<label class="mm-form-label sr-only" for="mm_request_details">
				<?php esc_html_e( 'توضیحات', 'minimal-maison' ); ?>
				<span class="mm-form-required" aria-hidden="true">*</span>
			</label>
			<textarea
				class="mm-form-textarea"
				name="mm_request_details"
				id="mm_request_details"
				rows="5"
				required
				placeholder="<?php esc_attr_e( 'توضیحات و جزئیات بیشتر', 'minimal-maison' ); ?>"
			></textarea>
		</div>

		<div class="mm-form-field mm-form-field--file">
			<span class="mm-form-label sr-only">
				<?php esc_html_e( 'آپلود تصویر مرجع', 'minimal-maison' ); ?>
				<span class="mm-form-optional"><?php esc_html_e( 'اختیاری', 'minimal-maison' ); ?></span>
			</span>
			<div class="mm-form-file-wrap">
				<input
					class="mm-form-file-input"
					type="file"
					name="mm_request_references[]"
					id="mm_request_reference"
					accept="image/jpeg,image/png,image/webp"
					multiple
				>
				<label class="mm-form-file-trigger" for="mm_request_reference">
					<span class="mm-form-file-trigger__icon" aria-hidden="true">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect x="4" y="6" width="20" height="16" rx="1.5" stroke="currentColor" stroke-width="1.2"/>
							<circle cx="10" cy="12" r="2" stroke="currentColor" stroke-width="1.2"/>
							<path d="M4 19L10 13L14 17L18 13L24 19" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<span class="mm-form-file-trigger__copy">
						<span class="mm-form-file-trigger__title"><?php esc_html_e( 'آپلود تصویر مرجع', 'minimal-maison' ); ?></span>
						<span class="mm-form-file-trigger__hint"><?php esc_html_e( 'فایل خود را انتخاب کنید', 'minimal-maison' ); ?></span>
					</span>
					<span class="mm-form-file-name" data-empty="<?php esc_attr_e( 'فایلی انتخاب نشده', 'minimal-maison' ); ?>" hidden>
						<?php esc_html_e( 'فایلی انتخاب نشده', 'minimal-maison' ); ?>
					</span>
				</label>
			</div>
		</div>
	</div>

	<div class="mm-custom-order-request-form__actions">
		<button type="submit" class="mm-button mm-custom-order-request-form__submit">
			<?php echo esc_html( mm_co_option( 'co_form_submit_label' ) ); ?>
		</button>
	</div>
</form>
