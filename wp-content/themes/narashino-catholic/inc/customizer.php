<?php
/**
 * Customizer settings for parish details, Mass times, and the priest.
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme settings. Each default is a placeholder until the parish replaces it.
 *
 * @return array<string, array{label: string, section: string, control: string, default: string|int}>
 */
function nc_settings() {
	return [
		'nc_announce_ja'     => [ 'label' => 'お知らせバー（日本語）· Bar text', 'section' => 'announce', 'control' => 'text', 'default' => '10月31日（土）の清掃はお休みです' ],
		'nc_announce_en'     => [ 'label' => 'お知らせバー（英語）· Bar text in English', 'section' => 'announce', 'control' => 'text', 'default' => 'No cleaning on October 31' ],
		'nc_address'         => [ 'label' => '住所 · Address', 'section' => 'parish', 'control' => 'textarea', 'default' => '[住所 · ADDRESS]' ],
		'nc_phone'           => [ 'label' => '電話番号 · Phone', 'section' => 'parish', 'control' => 'text', 'default' => '[電話番号 · PHONE]' ],
		'nc_email'           => [ 'label' => 'メールアドレス · Email', 'section' => 'parish', 'control' => 'text', 'default' => '[メールアドレス · EMAIL]' ],
		'nc_directions'      => [ 'label' => '最寄り駅からの道順 · Directions', 'section' => 'parish', 'control' => 'textarea', 'default' => '[最寄り駅からの道順 · DIRECTIONS FROM NEAREST STATION]' ],
		'nc_sunday_mass'     => [ 'label' => '主日のミサ · Sunday Mass times', 'section' => 'parish', 'control' => 'text', 'default' => '[時間 · TIME]' ],
		'nc_weekday_mass'    => [ 'label' => '平日のミサ · Weekday Mass times', 'section' => 'parish', 'control' => 'text', 'default' => '[曜日・時間 · DAYS & TIME]' ],
		'nc_priest_photo'    => [ 'label' => '司祭の写真 · Photo', 'section' => 'priest', 'control' => 'media', 'default' => 0 ],
		'nc_priest_name'     => [ 'label' => '司祭名 · Name', 'section' => 'priest', 'control' => 'text', 'default' => '[司祭名 · NAME]' ],
		'nc_priest_message'  => [ 'label' => '司祭からの言葉 · Message', 'section' => 'priest', 'control' => 'textarea', 'default' => '[司祭のメッセージ · MESSAGE FROM THE PRIEST]' ],
		'nc_priest_url'      => [ 'label' => '「メッセージを読む」のリンク先 · Link', 'section' => 'links', 'control' => 'url', 'default' => 'https://www.narashinocatholic.com/司祭からの言葉/' ],
		'nc_anniversary_url' => [ 'label' => '50周年記念ミサのリンク先 · Link', 'section' => 'links', 'control' => 'url', 'default' => 'https://www.narashinocatholic.com/教会案内/50周年記念ミサ関連/' ],
		'nc_contact_url'     => [ 'label' => 'お問い合わせフォームのリンク先（空欄なら連絡先欄へ） · Contact form link', 'section' => 'links', 'control' => 'url', 'default' => '' ],
	];
}

/**
 * Registers the Customizer sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function nc_customize_register( $wp_customize ) {
	$sections = [
		'announce' => 'お知らせバー · Announcement bar（空欄で非表示）',
		'parish'   => '教会情報・ミサ · Parish details and Mass',
		'priest'   => '司祭 · Priest',
		'links'    => 'リンク · Links',
	];

	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( 'nc_' . $id, [ 'title' => $title, 'priority' => 160 ] );
	}

	$sanitize = [
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'url'      => 'esc_url_raw',
		'media'    => 'absint',
	];

	foreach ( nc_settings() as $key => $field ) {
		$wp_customize->add_setting(
			$key,
			[
				'default'           => $field['default'],
				'sanitize_callback' => $sanitize[ $field['control'] ],
			]
		);

		if ( 'media' === $field['control'] ) {
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$key,
					[
						'label'     => $field['label'],
						'section'   => 'nc_' . $field['section'],
						'mime_type' => 'image',
					]
				)
			);
		} else {
			$wp_customize->add_control(
				$key,
				[
					'label'   => $field['label'],
					'section' => 'nc_' . $field['section'],
					'type'    => $field['control'],
				]
			);
		}
	}
}
add_action( 'customize_register', 'nc_customize_register' );
