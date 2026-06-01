<?php
/**
 * Jewelry request admin list and detail views.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register admin hooks.
 */
function mm_jewelry_request_admin_init(): void {
	add_filter( 'manage_mm_jewelry_request_posts_columns', 'mm_jewelry_request_admin_columns' );
	add_action( 'manage_mm_jewelry_request_posts_custom_column', 'mm_jewelry_request_admin_column_content', 10, 2 );
	add_filter( 'manage_edit-mm_jewelry_request_sortable_columns', 'mm_jewelry_request_admin_sortable_columns' );
	add_action( 'add_meta_boxes', 'mm_jewelry_request_register_meta_boxes' );
	add_action( 'admin_head', 'mm_jewelry_request_admin_styles' );
}
add_action( 'admin_init', 'mm_jewelry_request_admin_init' );

/**
 * List table columns.
 *
 * @param string[] $columns Default columns.
 * @return string[]
 */
function mm_jewelry_request_admin_columns( array $columns ): array {
	$new = array();

	if ( isset( $columns['cb'] ) ) {
		$new['cb'] = $columns['cb'];
	}

	$new['title']       = __( 'مشتری', 'minimal-maison' );
	$new['mm_phone']    = __( 'تماس', 'minimal-maison' );
	$new['mm_type']     = __( 'نوع سفارش', 'minimal-maison' );
	$new['mm_budget']   = __( 'بودجه', 'minimal-maison' );
	$new['mm_reference'] = __( 'تصویر', 'minimal-maison' );
	$new['date']        = __( 'تاریخ', 'minimal-maison' );

	return $new;
}

/**
 * Render custom column content.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function mm_jewelry_request_admin_column_content( string $column, int $post_id ): void {
	switch ( $column ) {
		case 'mm_phone':
			$phone    = mm_jewelry_request_get_meta( $post_id, 'phone' );
			$whatsapp = mm_jewelry_request_get_meta( $post_id, 'whatsapp' );

			echo esc_html( $phone );

			if ( $whatsapp && $whatsapp !== $phone ) {
				echo '<br><span class="description">' . esc_html__( 'واتساپ:', 'minimal-maison' ) . ' ' . esc_html( $whatsapp ) . '</span>';
			}
			break;

		case 'mm_type':
			$type = mm_jewelry_request_get_meta( $post_id, 'order_type' );
			echo esc_html( mm_jewelry_request_order_type_label( $type ) );
			break;

		case 'mm_budget':
			$budget = mm_jewelry_request_get_meta( $post_id, 'budget' );
			echo esc_html( mm_jewelry_request_budget_label( $budget ) );
			break;

		case 'mm_reference':
			$ref_id = (int) mm_jewelry_request_get_meta( $post_id, 'reference_id' );

			if ( $ref_id ) {
				$url = wp_get_attachment_image_url( $ref_id, 'thumbnail' );

				if ( $url ) {
					printf(
						'<a href="%1$s" target="_blank" rel="noopener"><img src="%2$s" alt="" width="48" height="48" style="object-fit:cover;border-radius:2px;"></a>',
						esc_url( wp_get_attachment_url( $ref_id ) ),
						esc_url( $url )
					);
				} else {
					esc_html_e( 'دارد', 'minimal-maison' );
				}
			} else {
				echo '<span class="description">—</span>';
			}
			break;
	}
}

/**
 * Sortable columns.
 *
 * @param string[] $columns Sortable columns.
 * @return string[]
 */
function mm_jewelry_request_admin_sortable_columns( array $columns ): array {
	$columns['date'] = 'date';

	return $columns;
}

/**
 * Register detail meta box on request edit screen.
 */
function mm_jewelry_request_register_meta_boxes(): void {
	add_meta_box(
		'mm_jewelry_request_details',
		__( 'جزئیات درخواست', 'minimal-maison' ),
		'mm_jewelry_request_render_details_meta_box',
		'mm_jewelry_request',
		'normal',
		'high'
	);

	remove_meta_box( 'submitdiv', 'mm_jewelry_request', 'side' );
}

/**
 * Render request details meta box.
 *
 * @param WP_Post $post Request post.
 */
function mm_jewelry_request_render_details_meta_box( WP_Post $post ): void {
	$name        = mm_jewelry_request_get_meta( $post->ID, 'name' );
	$phone       = mm_jewelry_request_get_meta( $post->ID, 'phone' );
	$whatsapp    = mm_jewelry_request_get_meta( $post->ID, 'whatsapp' );
	$order_type  = mm_jewelry_request_get_meta( $post->ID, 'order_type' );
	$budget      = mm_jewelry_request_get_meta( $post->ID, 'budget' );
	$details     = mm_jewelry_request_get_meta( $post->ID, 'details' );
	$reference_id = (int) mm_jewelry_request_get_meta( $post->ID, 'reference_id' );

	$rows = array(
		array( __( 'نام و نام خانوادگی', 'minimal-maison' ), $name ),
		array( __( 'شماره تماس', 'minimal-maison' ), $phone ),
		array( __( 'واتساپ', 'minimal-maison' ), $whatsapp ?: '—' ),
		array( __( 'نوع سفارش', 'minimal-maison' ), mm_jewelry_request_order_type_label( $order_type ) ),
		array( __( 'بودجه تقریبی', 'minimal-maison' ), mm_jewelry_request_budget_label( $budget ) ),
	);

	?>
	<table class="widefat striped mm-jewelry-request-table">
		<tbody>
			<?php foreach ( $rows as $row ) : ?>
				<tr>
					<th scope="row" style="width:180px;"><?php echo esc_html( $row[0] ); ?></th>
					<td><?php echo esc_html( $row[1] ); ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<th scope="row"><?php esc_html_e( 'توضیحات سفارش', 'minimal-maison' ); ?></th>
				<td><?php echo nl2br( esc_html( $details ) ); ?></td>
			</tr>
			<?php if ( $reference_id ) : ?>
				<tr>
					<th scope="row"><?php esc_html_e( 'تصویر مرجع', 'minimal-maison' ); ?></th>
					<td>
						<?php
						$full_url = wp_get_attachment_url( $reference_id );

						if ( $full_url ) {
							echo wp_get_attachment_image( $reference_id, 'medium', false, array( 'style' => 'max-width:320px;height:auto;' ) );
							echo '<p><a href="' . esc_url( $full_url ) . '" target="_blank" rel="noopener">' . esc_html__( 'مشاهده اندازه اصلی', 'minimal-maison' ) . '</a></p>';
						}
						?>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<p class="description">
		<?php
		printf(
			/* translators: %s: submission datetime */
			esc_html__( 'ثبت شده در %s', 'minimal-maison' ),
			esc_html( get_the_date( 'Y/m/d H:i', $post ) )
		);
		?>
	</p>
	<?php
}

/**
 * Inline admin styles for list and detail views.
 */
function mm_jewelry_request_admin_styles(): void {
	$screen = get_current_screen();

	if ( ! $screen || 'mm_jewelry_request' !== $screen->post_type ) {
		return;
	}

	?>
	<style>
		.mm-jewelry-request-table th {
			font-weight: 600;
		}
		.post-type-mm_jewelry_request .page-title-action {
			display: none;
		}
	</style>
	<?php
}

/**
 * Hide "Add New" submenu — requests come from the front-end form only.
 */
function mm_jewelry_request_hide_add_new(): void {
	global $submenu;

	if ( isset( $submenu['edit.php?post_type=mm_jewelry_request'] ) ) {
		foreach ( $submenu['edit.php?post_type=mm_jewelry_request'] as $key => $item ) {
			if ( 'post-new.php?post_type=mm_jewelry_request' === $item[2] ) {
				unset( $submenu['edit.php?post_type=mm_jewelry_request'][ $key ] );
			}
		}
	}
}
add_action( 'admin_menu', 'mm_jewelry_request_hide_add_new', 999 );

/**
 * Block direct creation of request posts in admin.
 */
function mm_jewelry_request_block_admin_create(): void {
	global $pagenow;

	if ( 'post-new.php' === $pagenow && isset( $_GET['post_type'] ) && 'mm_jewelry_request' === $_GET['post_type'] ) {
		wp_safe_redirect( admin_url( 'edit.php?post_type=mm_jewelry_request' ) );
		exit;
	}
}
add_action( 'admin_init', 'mm_jewelry_request_block_admin_create' );
