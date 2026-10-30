<?php
/**
 * 固定ページの英語の副題（_nc_en_title）を編集する欄。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes_page', 'nc_pages_add_meta_box' );

function nc_pages_add_meta_box() {
	add_meta_box( 'nc-page-en', '英語の副題', 'nc_pages_render_meta_box', 'page', 'side', 'default' );
}

function nc_pages_render_meta_box( $post ) {
	wp_nonce_field( 'nc_page_en_save', 'nc_page_en_nonce' );
	printf(
		'<input type="text" class="widefat" id="nc_en_title" name="nc_en_title" value="%s">',
		esc_attr( (string) get_post_meta( $post->ID, '_nc_en_title', true ) )
	);
	echo '<p class="description">ページ上部に表示される英語の見出しです（例：Mass times）。</p>';
}

add_action( 'save_post_page', 'nc_pages_save_meta_box', 10, 2 );

function nc_pages_save_meta_box( $post_id, $post ) {
	if ( ! isset( $_POST['nc_page_en_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['nc_page_en_nonce'] ) );

	if ( ! wp_verify_nonce( $nonce, 'nc_page_en_save' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}

	$en = isset( $_POST['nc_en_title'] ) ? sanitize_text_field( wp_unslash( $_POST['nc_en_title'] ) ) : '';

	if ( '' === $en ) {
		delete_post_meta( $post_id, '_nc_en_title' );
	} else {
		update_post_meta( $post_id, '_nc_en_title', $en );
	}
}
