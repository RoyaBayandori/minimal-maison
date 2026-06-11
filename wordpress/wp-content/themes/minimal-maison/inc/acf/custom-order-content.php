<?php
/**
 * Custom Order landing page content helpers.
 *
 * @package Minimal_Maison
 */

defined( 'ABSPATH' ) || exit;

require MM_THEME_DIR . '/inc/acf/custom-order-defaults.php';
require MM_THEME_DIR . '/inc/acf/co-benefit-fields.php';
require MM_THEME_DIR . '/inc/acf/co-process-step-fields.php';

/**
 * Whether the current request uses the Custom Order page template.
 *
 * @return bool
 */
function mm_is_custom_order_page(): bool {
	return is_page_template( 'page-custom-order.php' );
}

/**
 * Post ID for Custom Order page ACF fields.
 *
 * @return int
 */
function mm_custom_order_page_id(): int {
	static $post_id = null;

	if ( null !== $post_id ) {
		return $post_id;
	}

	if ( mm_is_custom_order_page() ) {
		$post_id = (int) get_queried_object_id();
		return $post_id;
	}

	$post_id = (int) get_the_ID();

	if ( $post_id > 0 && 'page-custom-order.php' === get_page_template_slug( $post_id ) ) {
		return $post_id;
	}

	$post_id = 0;

	return $post_id;
}

/**
 * Read a Custom Order ACF field without PHP defaults.
 *
 * @param string $field_name Field name.
 * @return mixed
 */
function mm_co_acf_value( string $field_name ) {
	if ( ! mm_acf_available() ) {
		return '';
	}

	$post_id = mm_custom_order_page_id();

	if ( ! $post_id ) {
		return '';
	}

	$value = get_field( $field_name, $post_id );

	if ( null === $value || false === $value ) {
		return '';
	}

	return $value;
}

/**
 * Scalar Custom Order field with PHP default fallback.
 *
 * @param string $field_name Field name.
 * @return string
 */
function mm_co_option( string $field_name ): string {
	$defaults = mm_co_default_strings();
	$default  = $defaults[ $field_name ] ?? '';

	if ( ! mm_acf_available() ) {
		return $default;
	}

	$post_id = mm_custom_order_page_id();

	if ( ! $post_id ) {
		return $default;
	}

	$value = get_field( $field_name, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return is_string( $value ) ? $value : (string) $value;
}

/**
 * Echo escaped Custom Order text.
 *
 * @param string $field_name Field name.
 */
function mm_co_text( string $field_name ): void {
	echo esc_html( mm_co_option( $field_name ) );
}

/**
 * Custom Order URL field with internal path support.
 *
 * @param string $field_name Field name.
 * @return string
 */
function mm_co_url( string $field_name ): string {
	$url = trim( mm_co_option( $field_name ) );

	if ( '' === $url ) {
		return '#';
	}

	if ( str_starts_with( $url, '#' ) || str_contains( $url, '://' ) ) {
		return $url;
	}

	return home_url( $url );
}

/**
 * Split a textarea field into non-empty lines.
 *
 * @param string $field_name Field name.
 * @return string[]
 */
function mm_co_textarea_lines( string $field_name ): array {
	$text = trim( mm_co_option( $field_name ) );

	if ( '' === $text ) {
		return array();
	}

	return array_values(
		array_filter(
			array_map(
				'trim',
				preg_split( '/\r\n|\r|\n/', $text )
			)
		)
	);
}

/**
 * Custom Order image attachment ID.
 *
 * @param string $field_name Field name.
 * @return int
 */
function mm_co_image_id( string $field_name ): int {
	if ( ! mm_acf_available() ) {
		return 0;
	}

	$post_id = mm_custom_order_page_id();

	if ( ! $post_id ) {
		return 0;
	}

	$value = get_field( $field_name, $post_id );

	return mm_acf_image_to_id( $value );
}

/**
 * Benefit rows from six fixed group fields.
 *
 * @return array<int, array{image_id: int, title: string, description: string}>
 */
function mm_co_benefits(): array {
	if ( ! mm_acf_available() || ! mm_custom_order_page_id() ) {
		return array();
	}

	$benefits = array();

	foreach ( mm_co_benefit_field_names() as $field_name ) {
		$group = mm_co_acf_value( $field_name );

		if ( ! is_array( $group ) ) {
			continue;
		}

		$image_id    = isset( $group['image'] ) ? mm_acf_image_to_id( $group['image'] ) : 0;
		$title       = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		$description = isset( $group['description'] ) ? trim( (string) $group['description'] ) : '';

		if ( $image_id <= 0 ) {
			continue;
		}

		$benefits[] = array(
			'image_id'    => $image_id,
			'title'       => $title,
			'description' => $description,
		);
	}

	return $benefits;
}

/**
 * Render a benefit card image.
 *
 * @param int    $image_id Attachment ID.
 * @param string $class    Image class.
 * @return string
 */
function mm_co_render_benefit_image( int $image_id, string $class = 'mm-custom-order-benefits__image' ): string {
	if ( $image_id <= 0 ) {
		return '';
	}

	return wp_get_attachment_image(
		$image_id,
		'medium',
		false,
		array(
			'class'    => $class,
			'loading'  => 'lazy',
			'decoding' => 'async',
			'sizes'    => '160px',
		)
	);
}

/**
 * FAQ answer for a CPT entry.
 *
 * @param int $post_id FAQ post ID.
 * @return string
 */
function mm_co_faq_get_answer( int $post_id ): string {
	if ( $post_id <= 0 ) {
		return '';
	}

	if ( mm_acf_available() ) {
		$answer = get_field( 'faq_answer', $post_id );

		if ( is_string( $answer ) && '' !== trim( $answer ) ) {
			return trim( $answer );
		}
	}

	$meta = get_post_meta( $post_id, MM_CO_FAQ_ANSWER_META, true );

	return is_string( $meta ) ? trim( $meta ) : '';
}

/**
 * FAQ items from Relationship field.
 *
 * @return array<int, array{question: string, answer: string}>
 */
function mm_co_faq_items(): array {
	if ( ! mm_acf_available() ) {
		return mm_co_faq_items_from_query();
	}

	$post_id = mm_custom_order_page_id();

	if ( ! $post_id ) {
		return array();
	}

	$posts = get_field( 'co_faq_items', $post_id );

	if ( ! is_array( $posts ) || empty( $posts ) ) {
		return array();
	}

	$items = array();

	foreach ( $posts as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}

		$question = trim( get_the_title( $post ) );
		$answer   = mm_co_faq_get_answer( (int) $post->ID );

		if ( '' === $question || '' === $answer ) {
			continue;
		}

		$items[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}

	return $items;
}

/**
 * FAQ items from CPT query when ACF is unavailable.
 *
 * @return array<int, array{question: string, answer: string}>
 */
function mm_co_faq_items_from_query(): array {
	$posts = get_posts(
		array(
			'post_type'      => 'mm_co_faq',
			'posts_per_page' => 12,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'post_status'    => 'publish',
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	$items = array();

	foreach ( $posts as $post ) {
		$question = trim( get_the_title( $post ) );
		$answer   = mm_co_faq_get_answer( (int) $post->ID );

		if ( '' === $question || '' === $answer ) {
			continue;
		}

		$items[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}

	return $items;
}

/**
 * Process steps for the form sidebar.
 *
 * @return array<int, array{icon: string, icon_id: int, title: string, description: string}>
 */
function mm_co_process_steps(): array {
	$defaults = mm_co_default_process_steps();
	$steps    = array();

	foreach ( mm_co_process_step_field_names() as $index => $field_name ) {
		$default = $defaults[ $index ] ?? array(
			'icon'        => 'phone',
			'icon_id'     => 0,
			'title'       => '',
			'description' => '',
		);

		$group = mm_co_acf_value( $field_name );

		if ( ! is_array( $group ) ) {
			if ( '' !== $default['title'] ) {
				$steps[] = $default;
			}
			continue;
		}

		$icon_id     = isset( $group['icon'] ) ? mm_acf_image_to_id( $group['icon'] ) : 0;
		$title       = isset( $group['title'] ) ? trim( (string) $group['title'] ) : '';
		$description = isset( $group['description'] ) ? trim( (string) $group['description'] ) : '';

		if ( '' === $title ) {
			$title       = $default['title'];
			$description = '' !== $description ? $description : $default['description'];
		}

		if ( '' === $title ) {
			continue;
		}

		$steps[] = array(
			'icon'        => $default['icon'],
			'icon_id'     => $icon_id,
			'title'       => $title,
			'description' => '' !== $description ? $description : $default['description'],
		);
	}

	return $steps;
}

/**
 * Render a process step icon from CMS image or built-in SVG.
 *
 * @param array{icon: string, icon_id: int} $step Step data.
 * @return string
 */
function mm_co_render_process_step_icon( array $step ): string {
	$icon_id = (int) ( $step['icon_id'] ?? 0 );

	if ( $icon_id > 0 ) {
		return wp_get_attachment_image(
			$icon_id,
			'thumbnail',
			false,
			array(
				'class'    => 'mm-custom-order-form-section__step-icon-image',
				'loading'  => 'lazy',
				'decoding' => 'async',
			)
		);
	}

	$icons = array(
		'phone'    => '<svg class="mm-custom-order-form-section__step-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M10.5 6.5h3l1.5 6-2.25 1.5a13.5 13.5 0 006.75 6.75L21 18.5l6 1.5v3a2 2 0 01-2 2.15A17.5 17.5 0 016.35 8.5 2 2 0 018.5 6.5z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'idea'     => '<svg class="mm-custom-order-form-section__step-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 22h8M13 25h6M16 7a6 6 0 00-3 11.2V20h6v-1.8A6 6 0 0016 7z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'document' => '<svg class="mm-custom-order-form-section__step-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M11 7h7l5 5v13a1.5 1.5 0 01-1.5 1.5h-10A1.5 1.5 0 0110 25V8.5A1.5 1.5 0 0111.5 7H11z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/><path d="M18 7v5h5M13 17h6M13 21h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
		'delivery' => '<svg class="mm-custom-order-form-section__step-icon-svg" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8 11h11v12H8V11zM19 15h4l3 4v4h-7V15z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/><circle cx="12" cy="24.5" r="1.5" stroke="currentColor" stroke-width="1.2"/><circle cx="23" cy="24.5" r="1.5" stroke="currentColor" stroke-width="1.2"/></svg>',
	);

	$icon_key = isset( $step['icon'] ) ? (string) $step['icon'] : 'phone';

	return $icons[ $icon_key ] ?? $icons['phone'];
}

/**
 * Whether the hero section should render.
 */
function mm_co_should_show_hero(): bool {
	return '' !== trim( mm_co_option( 'co_hero_heading' ) )
		|| '' !== trim( mm_co_option( 'co_hero_description' ) );
}

/**
 * Whether the benefits section should render.
 */
function mm_co_should_show_benefits(): bool {
	if ( '' === trim( mm_co_option( 'co_benefits_heading' ) ) ) {
		return false;
	}

	return ! empty( mm_co_benefits() );
}

/**
 * Whether the FAQ section should render.
 */
function mm_co_should_show_faq(): bool {
	if ( '' === trim( mm_co_option( 'co_faq_heading' ) ) ) {
		return false;
	}

	return ! empty( mm_co_faq_items() );
}

/**
 * Whether the final CTA section should render.
 */
function mm_co_should_show_final_cta(): bool {
	$heading = trim( mm_co_option( 'co_final_cta_heading' ) );
	$label   = trim( mm_co_option( 'co_final_cta_button_label' ) );
	$url     = trim( mm_co_url( 'co_final_cta_button_url' ) );

	return '' !== $heading && '' !== $label && '#' !== $url && '' !== $url;
}

/**
 * Render Custom Order hero image markup.
 *
 * @param string $field_name Image field name.
 * @param string $class      Image class.
 * @return string
 */
function mm_co_render_image( string $field_name, string $class = 'mm-custom-order-hero__image' ): string {
	$image_id = mm_co_image_id( $field_name );

	if ( $image_id <= 0 ) {
		return '';
	}

	return wp_get_attachment_image(
		$image_id,
		'large',
		false,
		array(
			'class'   => $class,
			'loading' => 'eager',
			'sizes'   => '(min-width: 1024px) 50vw, 100vw',
		)
	);
}
