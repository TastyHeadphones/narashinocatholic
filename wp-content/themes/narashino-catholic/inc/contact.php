<?php
/**
 * お問い合わせフォームの送信処理（admin-post.php 経由、メールで送信）。
 *
 * 投稿内容はデータベースに保存しない。不正送信対策は、nonce、ハニーポット、
 * IPアドレスごとの送信回数制限（ハッシュ化して10分間のみ保持）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

const NC_CONTACT_LIMIT = 5;

add_action( 'admin_post_nopriv_nc_contact', 'nc_handle_contact' );
add_action( 'admin_post_nc_contact', 'nc_handle_contact' );

function nc_handle_contact() {
	check_admin_referer( 'nc_contact', 'nc_contact_nonce' );

	$return_url = nc_url( 'contact' );

	// 人間の訪問者は空欄のままにする隠し欄。入力されていたらボットとみなす。
	if ( ! empty( $_POST['website'] ) ) {
		nc_contact_redirect( $return_url, 'sent' );
	}

	$limit_key = 'nc_contact_' . md5( nc_contact_client_ip() );
	if ( (int) get_transient( $limit_key ) >= NC_CONTACT_LIMIT ) {
		nc_contact_redirect( $return_url, 'limit' );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$church  = isset( $_POST['church'] ) ? sanitize_text_field( wp_unslash( $_POST['church'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if (
		'' === $name || '' === $email || '' === $message
		|| ! is_email( $email )
		|| mb_strlen( $name ) > 100 || mb_strlen( $church ) > 100
		|| mb_strlen( $message ) > 4000
	) {
		nc_contact_redirect( $return_url, 'invalid' );
	}

	$site_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$subject   = '[' . $site_name . '] お問い合わせ';
	$body      = implode(
		"\n",
		array(
			'お名前：' . $name,
			'所属教会：' . ( '' !== $church ? $church : '（未記入）' ),
			'メールアドレス：' . $email,
			'',
			$message,
		)
	);
	$headers   = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . nc_contact_header_name( $name ) . ' <' . $email . '>',
	);

	$recipient = nc_parish( 'email' ) ? nc_parish( 'email' ) : get_option( 'admin_email' );
	$sent      = wp_mail( $recipient, $subject, $body, $headers );

	if ( $sent ) {
		set_transient( $limit_key, (int) get_transient( $limit_key ) + 1, 10 * MINUTE_IN_SECONDS );
	}

	nc_contact_redirect( $return_url, $sent ? 'sent' : 'error' );
}

/**
 * 結果を表示するためにリダイレクトする。
 *
 * @param string $url    戻り先のページ。
 * @param string $status sent, invalid, limit, error のいずれか。
 */
function nc_contact_redirect( $url, $status ) {
	wp_safe_redirect( add_query_arg( 'contact', $status, $url ) );
	exit;
}

/**
 * 送信元IPアドレス（ハッシュ化する前の値）。
 *
 * @return string
 */
function nc_contact_client_ip() {
	return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
}

/**
 * メールヘッダーに入れる名前から改行などを取り除く。
 *
 * @param string $name 差出人の名前。
 * @return string
 */
function nc_contact_header_name( $name ) {
	return trim( str_replace( array( "\r", "\n", '<', '>' ), '', $name ) );
}

/**
 * 送信結果のメッセージ（表示用）。結果がなければ null。
 *
 * @return array{0: string, 1: string}|null
 */
function nc_contact_notice() {
	$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
	$phone  = nc_parish( 'phone' );

	$messages = array(
		'sent'    => array( 'ok', 'お問い合わせを受け付けました。ありがとうございます。内容を確認のうえ、必要に応じて事務室よりご連絡いたします。' ),
		'invalid' => array( 'error', '入力内容をご確認ください。お名前、メールアドレス、メッセージは必須です。メールアドレスの形式もご確認ください。' ),
		'limit'   => array( 'error', '短時間に多くの送信がありました。しばらくしてから、もう一度お試しください。' ),
		'error'   => array( 'error', '送信できませんでした。お急ぎの場合は電話（' . $phone . '）にてご連絡ください。' ),
	);

	return isset( $messages[ $status ] ) ? $messages[ $status ] : null;
}
