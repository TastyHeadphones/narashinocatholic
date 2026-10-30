<?php
/**
 * 共通の補助関数：教会情報、名前付きページ、インラインSVG。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

const NC_PARISH_OPTION = 'nc_parish';
const NC_PAGES_OPTION  = 'nc_page_ids';

/**
 * 教会情報の初期値（現在の公式サイトに掲載されている内容）。
 *
 * @return array<string, string>
 */
function nc_parish_defaults() {
	return array(
		'name_ja'            => 'カトリック習志野教会',
		'name_en'            => 'Catholic Narashino Church',
		'postal_address'     => '〒262-0044 千葉市花見川区長作町1385-2',
		'phone'              => '043-216-0035',
		'fax'                => '043-216-0038',
		'email'              => '',
		'office_closed'      => '事務室は水曜日、木曜日はお休みです。',
		'pastor_name'        => '浦野 雄二 師',
		'sunday_mass'        => '7:30 / 10:00',
		'sunday_mass_note'   => 'ポルトガル語のミサ 第4日曜日 12:30 ／ ベトナム語のミサは毎月のお知らせをご覧ください',
		'weekday_mass_label' => '毎金曜日',
		'weekday_mass'       => '10:00',
		'confession'         => '毎週日曜日 7:00〜7:20、9:30〜9:50',
		'cleaning'           => '毎土曜日 10:30〜11:00',
		'cleaning_en'        => 'Every Saturday, 10:30–11:00',
		'directions'         => '京成実籾駅（北口）より、毎週日曜日10時のミサの開始時間に合わせて、9時半頃から数回程度、送迎車の用意があります。駐車場が満車の時は、雲人会館駐車場を第二駐車場として利用可能です。',
		'announcement'       => '',
		'announcement_en'    => '',
	);
}

/**
 * 教会情報の値を取得する。未設定の項目は初期値を返す。
 *
 * @param string $key 項目名（nc_parish_defaults() のキー）。
 * @return string
 */
function nc_parish( $key ) {
	static $values = null;

	if ( null === $values ) {
		$stored = get_option( NC_PARISH_OPTION, array() );
		$values = array_merge( nc_parish_defaults(), is_array( $stored ) ? $stored : array() );
	}

	return isset( $values[ $key ] ) ? (string) $values[ $key ] : '';
}

/**
 * 名前付きページのIDを返す。公開されていなければ 0。
 *
 * @param string $key ページの識別子（例: mass, access, notices）。
 * @return int
 */
function nc_page_id( $key ) {
	$ids = get_option( NC_PAGES_OPTION, array() );
	$id  = isset( $ids[ $key ] ) ? (int) $ids[ $key ] : 0;

	return ( $id && 'publish' === get_post_status( $id ) ) ? $id : 0;
}

/**
 * 名前付きページのURLを返す。ページがなければトップページ。
 *
 * @param string $key ページの識別子。
 * @return string
 */
function nc_url( $key ) {
	$id = nc_page_id( $key );

	return $id ? get_permalink( $id ) : home_url( '/' );
}

/**
 * 英語の副題（_nc_en_title）を返す。
 *
 * @param int $post_id 投稿ID。省略時は現在の投稿。
 * @return string
 */
function nc_page_en( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	return (string) get_post_meta( $post_id, '_nc_en_title', true );
}

/**
 * 告知バーの文言。空欄なら表示しない。
 *
 * @return string
 */
function nc_announcement() {
	return trim( nc_parish( 'announcement' ) );
}

/**
 * テーマ内の SVG ファイルをそのまま出力する（assets/svg/ 内のファイル名のみ許可）。
 *
 * @param string $name 拡張子を除いたファイル名。
 */
function nc_svg( $name ) {
	if ( ! preg_match( '/^[a-z]+$/', $name ) ) {
		return;
	}

	$file = get_theme_file_path( 'assets/svg/' . $name . '.svg' );

	if ( is_readable( $file ) ) {
		readfile( $file );
	}
}

/**
 * 矢印アイコン（インラインSVG）。
 *
 * @return string
 */
function nc_arrow() {
	return '<svg class="arr" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
}

/**
 * 電話番号から tel: リンクを作る。
 *
 * @param string $number 表示用の電話番号。
 * @return string
 */
function nc_tel_href( $number ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $number );
}

/**
 * 本文を HTML のまま出力する。
 *
 * 固定ページの本文はレイアウト用の HTML（カードや一覧）で書かれているため、
 * 段落の自動挿入（wpautop）を止める。
 */
function nc_the_content() {
	remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_content', 'shortcode_unautop' );

	the_content();

	add_filter( 'the_content', 'wpautop' );
	add_filter( 'the_content', 'shortcode_unautop' );
}
