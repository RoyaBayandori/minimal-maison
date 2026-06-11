<?php
/**
 * Jewelry request lifecycle hooks.
 *
 * Available actions (implemented in later phases unless noted):
 *
 * - mm_jewelry_request_before_validate (array $posted)
 * - mm_jewelry_request_validated (array $validated)
 * - mm_jewelry_request_created (int $post_id)
 * - mm_jewelry_request_attachments_added (int $post_id, int[] $attachment_ids)
 * - mm_jewelry_request_status_changed (int $post_id, string $old_status, string $new_status) — active
 * - mm_jewelry_request_notification_sent (int $post_id)
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fire the status-changed action when a request status updates.
 *
 * @param int    $post_id    Request post ID.
 * @param string $old_status Previous status slug.
 * @param string $new_status New status slug.
 */
function mm_jewelry_request_fire_status_changed( int $post_id, string $old_status, string $new_status ): void {
	if ( $old_status === $new_status ) {
		return;
	}

	/**
	 * Fires after a jewelry request status changes.
	 *
	 * @param int    $post_id    Request post ID.
	 * @param string $old_status Previous status slug.
	 * @param string $new_status New status slug.
	 */
	do_action( 'mm_jewelry_request_status_changed', $post_id, $old_status, $new_status );
}

/**
 * Fire the created action when a request is stored successfully.
 *
 * @param int   $post_id        Request post ID.
 * @param int[] $attachment_ids Reference attachment IDs.
 */
function mm_jewelry_request_fire_created( int $post_id, array $attachment_ids ): void {
	/**
	 * Fires after a jewelry request is created from the front-end form.
	 *
	 * @param int   $post_id        Request post ID.
	 * @param int[] $attachment_ids Reference attachment IDs.
	 */
	do_action( 'mm_jewelry_request_created', $post_id, $attachment_ids );

	if ( ! empty( $attachment_ids ) ) {
		/**
		 * Fires after reference attachments are linked to a request.
		 *
		 * @param int   $post_id        Request post ID.
		 * @param int[] $attachment_ids Reference attachment IDs.
		 */
		do_action( 'mm_jewelry_request_attachments_added', $post_id, $attachment_ids );
	}
}
