<?php
/**
 * 教会情報の設定画面（設定 > 教会情報）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

/**
 * 設定項目: キー => [ラベル, 入力の種類]。
 *
 * @return array<string, array{0: string, 1: string}>
 */
function nc_parish_fields() {
	return array(
		'name_ja'            => array( '教会名（日本語）', 'text' ),
		'name_en'            => array( '教会名（英語）', 'text' ),
		'postal_address'     => array( '住所', 'text' ),
		'phone'              => array( '電話番号', 'text' ),
		'fax'                => array( 'FAX', 'text' ),
		'email'              => array( 'メールアドレス（公開・任意。空欄なら非表示）', 'email' ),
		'office_closed'      => array( '事務室の休室日', 'text' ),
		'pastor_name'        => array( '主任司祭', 'text' ),
		'sunday_mass'        => array( '主日のミサ（時間）', 'text' ),
		'sunday_mass_note'   => array( '主日のミサの補足', 'textarea' ),
		'weekday_mass_label' => array( '平日のミサ（曜日）', 'text' ),
		'weekday_mass'       => array( '平日のミサ（時間）', 'text' ),
		'confession'         => array( 'ゆるしの秘跡（告解）', 'text' ),
		'cleaning'           => array( '教会の清掃（日時）', 'text' ),
		'directions'         => array( '最寄り駅からの道順', 'textarea' ),
		'announcement'       => array( 'お知らせバーの文言（空欄で非表示）', 'text' ),
		'announcement_en'    => array( 'お知らせバーの英語文言', 'text' ),
	);
}

add_action( 'admin_menu', 'nc_parish_menu' );

function nc_parish_menu() {
	add_options_page( '教会情報', '教会情報', 'manage_options', 'nc-parish', 'nc_parish_render_page' );
}

add_action( 'admin_init', 'nc_parish_register' );

function nc_parish_register() {
	register_setting(
		'nc_parish',
		NC_PARISH_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'nc_parish_sanitize',
			'default'           => nc_parish_defaults(),
		)
	);

	add_settings_section( 'nc_parish_main', '表示する教会情報', '__return_false', 'nc-parish' );

	foreach ( nc_parish_fields() as $key => $field ) {
		add_settings_field(
			$key,
			$field[0],
			'nc_parish_render_field',
			'nc-parish',
			'nc_parish_main',
			array(
				'key'       => $key,
				'type'      => $field[1],
				'label_for' => 'nc-parish-' . $key,
			)
		);
	}
}

/**
 * 入力値を項目ごとに検証・整形する。
 *
 * @param mixed $input 送信された値。
 * @return array<string, string>
 */
function nc_parish_sanitize( $input ) {
	$input  = is_array( $input ) ? $input : array();
	$output = array();

	foreach ( nc_parish_fields() as $key => $field ) {
		$raw = isset( $input[ $key ] ) && is_scalar( $input[ $key ] ) ? (string) $input[ $key ] : '';

		if ( 'email' === $field[1] ) {
			$output[ $key ] = sanitize_email( $raw );
		} elseif ( 'textarea' === $field[1] ) {
			$output[ $key ] = sanitize_textarea_field( $raw );
		} else {
			$output[ $key ] = sanitize_text_field( $raw );
		}
	}

	return $output;
}

/**
 * 設定項目の入力欄を出力する。
 *
 * @param array $args 項目情報。
 */
function nc_parish_render_field( $args ) {
	$key   = $args['key'];
	$value = nc_parish( $key );
	$name  = NC_PARISH_OPTION . '[' . $key . ']';
	$id    = 'nc-parish-' . $key;

	if ( 'textarea' === $args['type'] ) {
		printf(
			'<textarea class="large-text" rows="3" id="%1$s" name="%2$s">%3$s</textarea>',
			esc_attr( $id ),
			esc_attr( $name ),
			esc_textarea( $value )
		);
		return;
	}

	printf(
		'<input type="%1$s" class="regular-text" id="%2$s" name="%3$s" value="%4$s">',
		'email' === $args['type'] ? 'email' : 'text',
		esc_attr( $id ),
		esc_attr( $name ),
		esc_attr( $value )
	);
}

function nc_parish_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1>教会情報</h1>
		<p>トップページ・ミサ案内・フッターに表示される情報です。ミサの時間は毎月変わることがあるため、お知らせに合わせて更新してください。</p>
		<form method="post" action="options.php">
			<?php
			settings_fields( 'nc_parish' );
			do_settings_sections( 'nc-parish' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}
