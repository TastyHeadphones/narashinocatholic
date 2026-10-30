<?php
/**
 * お問い合わせフォームの送信処理（admin-post.php 経由、教会の事務室のメールへ送信）。
 *
 * 投稿内容はデータベースに保存しない。宛先は教会情報のメールアドレスだけで、
 * 未設定のときは送信せず、電話での連絡を案内する（管理者のメールには送らない）。
 * 不正送信対策は、nonce、ハニーポット、送信回数の制限（IPアドレスごとと全体。
 * カウンターは IP のハッシュを鍵にして、10分・1時間だけ保持する）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

const NC_CONTACT_LIMIT        = 5;  // 1つの IP アドレスから10分間に試行できる回数。
const NC_CONTACT_GLOBAL_LIMIT = 60; // サイト全体で1時間に試行できる回数。

add_action( 'admin_post_nopriv_nc_contact', 'nc_handle_contact' );
add_action( 'admin_post_nc_contact', 'nc_handle_contact' );

function nc_handle_contact() {
	check_admin_referer( 'nc_contact', 'nc_contact_nonce' );

	$return_url = nc_url( 'contact' );

	// 人間の訪問者は空欄のままにする隠し欄。入力されていたらボットとみなす。
	if ( ! empty( $_POST['website'] ) ) {
		nc_contact_redirect( $return_url, 'sent' );
	}

	$recipient = nc_parish( 'email' );

	if ( '' === $recipient || ! is_email( $recipient ) ) {
		nc_contact_redirect( $return_url, 'unavailable' );
	}

	$ip_key     = 'nc_contact_' . md5( nc_contact_client_ip() );
	$global_key = 'nc_contact_all';

	if ( (int) get_transient( $ip_key ) >= NC_CONTACT_LIMIT || (int) get_transient( $global_key ) >= NC_CONTACT_GLOBAL_LIMIT ) {
		nc_contact_redirect( $return_url, 'limit' );
	}

	// 試行は結果にかかわらず数える（送信に失敗する場合も回数の制限が効くように）。
	set_transient( $ip_key, (int) get_transient( $ip_key ) + 1, 10 * MINUTE_IN_SECONDS );
	set_transient( $global_key, (int) get_transient( $global_key ) + 1, HOUR_IN_SECONDS );

	$name    = nc_contact_field( 'name', 100 );
	$church  = nc_contact_field( 'church', 100 );
	$email   = is_string( $_POST['email'] ?? null ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = nc_contact_field( 'message', 4000, true );

	if ( '' === $name || '' === $email || '' === $message || ! is_email( $email ) ) {
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

	// 返信先はメールアドレスだけにする（表示名を入れると、宛先を追加される余地が生じるため）。
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $email,
	);

	$sent = wp_mail( $recipient, $subject, $body, $headers );

	nc_contact_redirect( $return_url, $sent ? 'sent' : 'error' );
}

/**
 * 入力欄の値を取り出して整形する。文字列でない値や上限を超える値は空欄として扱う。
 *
 * @param string $key       入力欄の名前。
 * @param int    $max       文字数の上限。
 * @param bool   $multiline 改行を残すか。
 * @return string
 */
function nc_contact_field( $key, $max, $multiline = false ) {
	if ( ! isset( $_POST[ $key ] ) || ! is_string( $_POST[ $key ] ) ) {
		return '';
	}

	$value = wp_unslash( $_POST[ $key ] );
	$value = $multiline ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );

	return mb_strlen( $value ) > $max ? '' : $value;
}

/**
 * 結果を表示するためにリダイレクトする。
 *
 * @param string $url    戻り先のページ。
 * @param string $status sent, invalid, limit, unavailable, error のいずれか。
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
 * 送信結果のメッセージ（表示用）。結果がなければ null。
 *
 * @return array{0: string, 1: string}|null
 */
function nc_contact_notice() {
	$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
	$phone  = nc_parish( 'phone' );

	$messages = array(
		'sent'        => array( 'ok', 'お問い合わせを受け付けました。ありがとうございます。内容を確認のうえ、必要に応じて事務室よりご連絡いたします。' ),
		'invalid'     => array( 'error', '入力内容をご確認ください。お名前、メールアドレス、メッセージは必須です。メールアドレスの形式もご確認ください。' ),
		'limit'       => array( 'error', '短時間に多くの送信がありました。しばらくしてから、もう一度お試しください。' ),
		'unavailable' => array( 'error', '現在、メールでのお問い合わせを受け付けていません。お急ぎの場合は電話（' . $phone . '）にてご連絡ください。' ),
		'error'       => array( 'error', '送信できませんでした。お急ぎの場合は電話（' . $phone . '）にてご連絡ください。' ),
	);

	return isset( $messages[ $status ] ) ? $messages[ $status ] : null;
}
