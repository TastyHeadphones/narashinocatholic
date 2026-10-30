<?php
/**
 * English text for notices (blog posts), shown on the homepage cards.
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the English text meta box on posts.
 */
function nc_notice_meta_box() {
	add_meta_box( 'nc-notice-en', 'English text（英語表記）', 'nc_notice_meta_box_html', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'nc_notice_meta_box' );

/**
 * Outputs the English text meta box.
 *
 * @param WP_Post $post Current post.
 */
function nc_notice_meta_box_html( $post ) {
	wp_nonce_field( 'nc_notice_en', 'nc_notice_en_nonce' );

	$fields = [
		'nc_en_title'   => 'English title（英語の見出し）',
		'nc_en_excerpt' => 'English summary（英語の概要）',
	];

	foreach ( $fields as $key => $label ) {
		printf(
			'<p><label for="%1$s"><strong>%2$s</strong></label><br><input type="text" id="%1$s" name="%1$s" value="%3$s" class="widefat"></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( get_post_meta( $post->ID, $key, true ) )
		);
	}
}

/**
 * Saves the English text meta box.
 *
 * @param int $post_id Post ID.
 */
function nc_save_notice_meta( $post_id ) {
	if ( ! isset( $_POST['nc_notice_en_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['nc_notice_en_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'nc_notice_en' ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( [ 'nc_en_title', 'nc_en_excerpt' ] as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_post', 'nc_save_notice_meta' );
