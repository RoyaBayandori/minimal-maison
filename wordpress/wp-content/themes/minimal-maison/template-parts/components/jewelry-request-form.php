<?php
/**
 * Custom jewelry request form.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

$order_types = mm_jewelry_request_order_types();
$budgets     = mm_jewelry_request_budget_ranges();
?>
<form
	class="mm-request-form"
	method="post"
	action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
	enctype="multipart/form-data"
	novalidate
>
	<input type="hidden" name="action" value="mm_submit_jewelry_request">
	<?php wp_nonce_field( 'mm_jewelry_request', 'mm_jewelry_request_nonce' ); ?>

	<div class="mm-form-honeypot" aria-hidden="true">
		<label for="mm_request_website"><?php esc_html_e( 'وب‌سایت', 'minimal-maison' ); ?></label>
		<input type="text" name="mm_request_website" id="mm_request_website" tabindex="-1" autocomplete="off">
	</div>

	<div class="mm-request-form__sections">
		<div class="mm-request-form__section">
			<div class="mm-request-form__fields">
				<div class="mm-form-field">
					<label class="mm-form-label" for="mm_request_name">
						<?php esc_html_e( 'نام شما', 'minimal-maison' ); ?>
						<span class="mm-form-required" aria-hidden="true">*</span>
					</label>
					<input
						class="mm-form-input"
						type="text"
						name="mm_request_name"
						id="mm_request_name"
						required
						autocomplete="name"
					>
				</div>

				<div class="mm-request-form__row">
					<div class="mm-form-field">
						<label class="mm-form-label" for="mm_request_phone">
							<?php esc_html_e( 'شماره تماس / واتساپ', 'minimal-maison' ); ?>
							<span class="mm-form-required" aria-hidden="true">*</span>
						</label>
						<input
							class="mm-form-input mm-form-input--ltr"
							type="tel"
							name="mm_request_phone"
							id="mm_request_phone"
							required
							inputmode="tel"
							autocomplete="tel"
							placeholder="09123456789"
							dir="ltr"
						>
					</div>

					<div class="mm-form-field">
						<label class="mm-form-label" for="mm_request_email">
							<?php esc_html_e( 'ایمیل', 'minimal-maison' ); ?>
							<span class="mm-form-optional"><?php esc_html_e( 'اختیاری', 'minimal-maison' ); ?></span>
						</label>
						<input
							class="mm-form-input mm-form-input--ltr"
							type="email"
							name="mm_request_email"
							id="mm_request_email"
							inputmode="email"
							autocomplete="email"
							dir="ltr"
						>
					</div>
				</div>
			</div>
		</div>

		<div class="mm-request-form__section">
			<fieldset class="mm-form-fieldset">
				<legend class="mm-form-label mm-form-label--legend">
					<?php esc_html_e( 'به دنبال چه نوع اثری هستید؟', 'minimal-maison' ); ?>
					<span class="mm-form-required" aria-hidden="true">*</span>
				</legend>
				<div class="mm-form-type-grid">
					<?php
					$is_first_type = true;
					foreach ( $order_types as $slug => $label ) :
						?>
						<label class="mm-form-type-card">
							<input
								type="radio"
								name="mm_request_type"
								value="<?php echo esc_attr( $slug ); ?>"
								<?php echo $is_first_type ? 'required' : ''; ?>
							>
							<span class="mm-form-type-card__surface">
								<span class="mm-form-type-card__label"><?php echo esc_html( $label ); ?></span>
							</span>
						</label>
						<?php
						$is_first_type = false;
					endforeach;
					?>
				</div>
			</fieldset>
		</div>

		<div class="mm-request-form__section">
			<div class="mm-request-form__fields">
				<div class="mm-form-field">
					<label class="mm-form-label" for="mm_request_budget">
						<?php esc_html_e( 'محدوده تقریبی سرمایه‌گذاری (برای راهنمایی طراحی)', 'minimal-maison' ); ?>
						<span class="mm-form-required" aria-hidden="true">*</span>
					</label>
					<select class="mm-form-select" name="mm_request_budget" id="mm_request_budget" required>
						<option value=""><?php esc_html_e( 'انتخاب کنید', 'minimal-maison' ); ?></option>
						<?php foreach ( $budgets as $slug => $label ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="mm-form-field">
					<label class="mm-form-label" for="mm_request_details">
						<?php esc_html_e( 'آنچه برای ما مهم است بدانیم', 'minimal-maison' ); ?>
						<span class="mm-form-required" aria-hidden="true">*</span>
					</label>
					<textarea
						class="mm-form-textarea"
						name="mm_request_details"
						id="mm_request_details"
						rows="6"
						required
						placeholder="<?php esc_attr_e( 'نوع طلا، سنگ، اندازه، مناسبت و هر جزئیاتی که برای طراحی مهم است…', 'minimal-maison' ); ?>"
					></textarea>
				</div>

				<div class="mm-form-field mm-form-field--file">
					<span class="mm-form-label">
						<?php esc_html_e( 'الهام یا تصویر مرجع', 'minimal-maison' ); ?>
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
							<span class="mm-form-file-trigger__title"><?php esc_html_e( 'انتخاب فایل', 'minimal-maison' ); ?></span>
							<span class="mm-form-file-trigger__hint"><?php esc_html_e( 'JPG، PNG یا WebP — حداکثر ۵ تصویر، هر کدام تا ۵ مگابایت', 'minimal-maison' ); ?></span>
							<span class="mm-form-file-name" data-empty="<?php esc_attr_e( 'فایلی انتخاب نشده', 'minimal-maison' ); ?>">
								<?php esc_html_e( 'فایلی انتخاب نشده', 'minimal-maison' ); ?>
							</span>
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="mm-request-form__actions">
		<button type="submit" class="mm-button mm-request-form__submit">
			<?php esc_html_e( 'درخواست تماس برای مشاوره', 'minimal-maison' ); ?>
		</button>
	</div>
</form>
