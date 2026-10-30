<?php
/**
 * 教会サイトの初期データを投入する（固定ページ、写真、お知らせ、メニュー）。
 *
 * 実行方法（テーマを有効化してから）:
 *   wp eval-file /seed/seed.php
 *
 * 既定では、まだ無いものだけを作成する。管理画面で編集した内容は上書きしない。
 * NC_SEED_FORCE=1 を付けると、固定ページ・お知らせ・メニューを初期内容に戻す。
 * 同時に、サイト名・キャッチフレーズ・トップページの設定も初期値に戻す（教会情報の設定は残す）。
 *
 * 本文は seed/pages/*.html（レイアウト用の HTML）をそのまま使う。
 * 写真は seed/photos/ のファイルを取り込む（外部のサイトからは取得しない）。
 * 地図は本文の [nc_map] ショートコードで Google マップを表示する。
 *
 * @package NarashinoCatholic
 */

if ( ! function_exists( 'nc_parish_defaults' ) ) {
	nc_seed_message( 'narashino-catholic テーマを有効化してから実行してください。', true );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

// 初期データは信頼できる内容なので、保存時に HTML を書き換えない（カードや属性を保つため）。
kses_remove_filters();

/**
 * 初期データのファイルを読む。必須のファイルが読めなければ止める。
 * 本文のファイルが無い場合は、警告を出して空の本文にする（ページには「準備中」の案内が出る）。
 *
 * @param string $path     ファイルのパス。
 * @param bool   $required 必須か。
 * @return string
 */
function nc_seed_read( $path, $required = true ) {
	$contents = file_get_contents( $path );

	if ( false === $contents ) {
		if ( $required ) {
			nc_seed_message( '初期データを読み込めません: ' . $path, true );
		}

		nc_seed_message( '警告: 本文のファイルがありません（空の本文で作成します）: ' . $path );
		return '';
	}

	return $contents;
}

/**
 * 固定ページの定義。親を先に並べること。
 *
 * slug は公式サイトのURLと同じにしてある（旧URLからの移行を簡単にするため）。
 */
$nc_seed_pages = array(
	'home'          => array( 'title' => 'ホーム', 'slug' => 'home', 'en' => '' ),
	'parish'        => array( 'title' => '教会案内', 'slug' => '教会案内', 'en' => 'About the parish' ),
	'mass'          => array( 'title' => 'ミサのご案内', 'slug' => 'ミサのご案内', 'parent' => 'parish', 'en' => 'Mass times', 'content' => 'mass.html' ),
	'monthly'       => array( 'title' => '毎月のお知らせ', 'slug' => '毎月のお知らせ', 'parent' => 'parish', 'en' => 'Monthly notices', 'content' => 'monthly.html' ),
	'sacraments'    => array( 'title' => '秘跡（SACRAMENTS）', 'slug' => '秘跡-sacraments', 'parent' => 'parish', 'en' => 'Sacraments', 'content' => 'sacraments.html' ),
	'courses'       => array( 'title' => '各講座の案内', 'slug' => '各講座の案内', 'parent' => 'parish', 'en' => 'Classes and courses', 'content' => 'courses.html' ),
	'movable'       => array( 'title' => '年間移動祝日一覧', 'slug' => '年間移動祝日一覧', 'parent' => 'parish', 'en' => 'Movable feasts', 'content' => 'movable.html' ),
	'calendar'      => array( 'title' => '年間典礼行事予定', 'slug' => '年間典礼行事予定', 'parent' => 'parish', 'en' => 'Liturgical calendar', 'content' => 'calendar.html' ),
	'anniversary'   => array( 'title' => '50周年記念ミサ関連', 'slug' => '50周年記念ミサ関連', 'parent' => 'parish', 'en' => '50th anniversary', 'content' => 'anniversary.html' ),
	'gallery'       => array( 'title' => '50周年記念ミサギャラリー', 'slug' => '50周年記念ミサギャラリー', 'parent' => 'anniversary', 'en' => 'Anniversary Mass gallery', 'content' => 'gallery.html' ),
	'priest'        => array( 'title' => '司祭の紹介', 'slug' => '司祭の紹介', 'en' => 'Our priest', 'content' => 'priest.html', 'image' => 'priest-portrait' ),
	'message'       => array( 'title' => '司祭からの言葉', 'slug' => '司祭からの言葉', 'en' => 'A word from our priest', 'content' => 'message.html', 'excerpt' => '「二本の映画」（習志野教会ニュース77号より）' ),
	'map'           => array( 'title' => '教会地図', 'slug' => '教会地図', 'en' => 'Church map', 'content' => 'map.html' ),
	'bible'         => array( 'title' => '聖書講座', 'slug' => '聖書講座', 'en' => 'Bible class', 'content' => 'bible.html' ),
	'notices'       => array( 'title' => 'お知らせ一覧', 'slug' => 'お知らせ一覧', 'en' => 'Notices', 'template' => 'page-notices.php' ),
	'cleaning'      => array( 'title' => '教会の清掃の奉仕者・協力者募集', 'slug' => '教会の清掃の奉仕者-協力者募集', 'parent' => 'notices', 'en' => 'Cleaning volunteers', 'content' => 'cleaning.html' ),
	'contact'       => array( 'title' => 'お問い合わせ', 'slug' => 'お問い合せ', 'en' => 'Contact', 'template' => 'page-contact.php', 'content' => 'contact.html' ),
	'links'         => array( 'title' => '外部リンク', 'slug' => '外部リンク', 'en' => 'Links', 'content' => 'links.html' ),
	'link-list'     => array( 'title' => 'リンク集', 'slug' => 'リンク集', 'parent' => 'links', 'en' => 'Useful links', 'content' => 'link-list.html' ),
	'english'       => array( 'title' => 'English Page', 'slug' => 'english-page', 'en' => 'English' ),
	'english-guide' => array( 'title' => 'English Guide', 'slug' => 'english-guide', 'parent' => 'english', 'en' => 'Church guide', 'content' => 'english-guide.html' ),
	'english-map'   => array( 'title' => 'Map', 'slug' => 'map', 'parent' => 'english', 'en' => 'Directions', 'content' => 'english-map.html' ),
	'access'        => array( 'title' => 'アクセス（ACCESS）', 'slug' => 'アクセス-access', 'en' => 'Access', 'content' => 'access.html' ),
	'privacy'       => array( 'title' => 'プライバシーポリシー', 'slug' => 'プライバシーポリシー', 'en' => 'Privacy policy', 'content' => 'privacy.html' ),
	'sitemap'       => array( 'title' => 'サイトマップ', 'slug' => 'sitemap', 'en' => 'Sitemap', 'template' => 'page-sitemap.php' ),
);

$nc_seed_force = '1' === getenv( 'NC_SEED_FORCE' );
$nc_seed_first = ! get_option( 'nc_seeded_at' );

/**
 * 出力（WP-CLI があれば WP_CLI を使う）。
 *
 * @param string $message 表示する文字列。
 * @param bool   $fatal   true なら終了する。
 */
function nc_seed_message( $message, $fatal = false ) {
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		if ( $fatal ) {
			WP_CLI::error( $message );
		}
		WP_CLI::log( $message );
		return;
	}

	echo $message . PHP_EOL;

	if ( $fatal ) {
		exit( 1 );
	}
}

/**
 * 集計を記録し、現在の集計を返す（作成・更新・変更なし）。
 *
 * @param string $type    種類（pages, notices, menus）。
 * @param string $outcome created, updated, kept のいずれか。
 * @return array<string, array<string, int>>
 */
function nc_seed_tally( $type = '', $outcome = '' ) {
	static $tally = array();

	if ( '' !== $type ) {
		$tally[ $type ][ $outcome ] = ( $tally[ $type ][ $outcome ] ?? 0 ) + 1;
	}

	return $tally;
}

/**
 * ローカルの写真をメディアライブラリに取り込む。失敗したら 0 を返す。
 *
 * @param string $file  写真のパス。
 * @param string $title 添付ファイルの見出し。
 * @param string $alt   代替テキスト。
 * @return int 添付ファイルのID。
 */
function nc_seed_import_photo( $file, $title, $alt ) {
	if ( ! is_readable( $file ) ) {
		return 0;
	}

	$tmp = wp_tempnam( basename( $file ) );

	if ( ! $tmp || ! copy( $file, $tmp ) ) {
		return 0;
	}

	$id = media_handle_sideload(
		array(
			'name'     => basename( $file ),
			'tmp_name' => $tmp,
		),
		0,
		$title,
		array( 'post_title' => $title )
	);

	if ( is_wp_error( $id ) ) {
		if ( file_exists( $tmp ) ) {
			wp_delete_file( $tmp );
		}
		return 0;
	}

	update_post_meta( $id, '_wp_attachment_image_alt', $alt );

	return (int) $id;
}

/**
 * 写真をまとめて取り込む（取り込み済みのものは再利用）。
 *
 * @param string $seed_dir シードのディレクトリ。
 * @return array{ids: array<string, int>, manifest: array<string, array{file: string, title: string, alt: string}>}
 */
function nc_seed_photos( $seed_dir ) {
	$manifest = json_decode( nc_seed_read( $seed_dir . '/photos.json' ), true );
	$stored   = get_option( 'nc_photo_ids', array() );
	$ids      = array();

	foreach ( $manifest as $key => $item ) {
		$id = isset( $stored[ $key ] ) ? (int) $stored[ $key ] : 0;

		if ( ! $id || ! get_post( $id ) ) {
			$id = nc_seed_import_photo( $seed_dir . '/' . $item['file'], $item['title'], $item['alt'] );
		}

		if ( $id ) {
			$ids[ $key ] = $id;
		} else {
			nc_seed_message( '写真を取り込めませんでした: ' . $item['file'] );
		}
	}

	update_option( 'nc_photo_ids', $ids );

	return array(
		'ids'      => $ids,
		'manifest' => $manifest,
	);
}

/**
 * 本文の {{photo:key}} を取り込んだ写真のURLに置き換える。
 *
 * @param string $html   本文。
 * @param array  $photos 取り込み済みの写真ID。
 * @return string
 */
function nc_seed_fill_photos( $html, $photos ) {
	return (string) preg_replace_callback(
		'/\{\{photo:([a-z0-9-]+)\}\}/',
		static function ( $match ) use ( $photos ) {
			return isset( $photos[ $match[1] ] ) ? (string) wp_get_attachment_url( $photos[ $match[1] ] ) : '';
		},
		$html
	);
}

/**
 * 固定ページを作成する（既存のページは $force のときだけ初期内容に戻す）。
 *
 * @param array  $pages    固定ページの定義。
 * @param array  $photos   取り込み済みの写真ID。
 * @param string $seed_dir シードのディレクトリ。
 * @param bool   $force    既存の内容を上書きするか。
 * @return array<string, int> 識別子 => ページID。
 */
function nc_seed_pages( $pages, $photos, $seed_dir, $force ) {
	$ids   = get_option( NC_PAGES_OPTION, array() );
	$order = 0;

	foreach ( $pages as $key => $spec ) {
		++$order;

		$parent_id = ! empty( $spec['parent'] ) ? (int) ( $ids[ $spec['parent'] ] ?? 0 ) : 0;
		$existing  = ! empty( $ids[ $key ] ) && get_post( $ids[ $key ] ) ? (int) $ids[ $key ] : 0;

		if ( $existing && ! $force ) {
			nc_seed_tally( 'pages', 'kept' );
			continue;
		}

		$content = '';

		if ( ! empty( $spec['content'] ) ) {
			$content = nc_seed_fill_photos(
				nc_seed_read( $seed_dir . '/pages/' . $spec['content'], false ),
				$photos
			);
		}

		$postarr = array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $spec['title'],
			'post_name'    => $spec['slug'],
			'post_parent'  => $parent_id,
			'post_content' => $content,
			'post_excerpt' => $spec['excerpt'] ?? '',
			'menu_order'   => $order,
		);

		if ( $existing ) {
			$postarr['ID'] = $existing;
		}

		$id = wp_insert_post( wp_slash( $postarr ), true );

		if ( is_wp_error( $id ) ) {
			nc_seed_message( 'ページを保存できませんでした: ' . $spec['title'] . ' / ' . $id->get_error_message(), true );
		}

		update_post_meta( $id, '_wp_page_template', $spec['template'] ?? 'default' );

		if ( ! empty( $spec['en'] ) ) {
			update_post_meta( $id, '_nc_en_title', $spec['en'] );
		}

		if ( ! empty( $spec['image'] ) && isset( $photos[ $spec['image'] ] ) ) {
			set_post_thumbnail( $id, $photos[ $spec['image'] ] );
		}

		nc_seed_tally( 'pages', $existing ? 'updated' : 'created' );
		$ids[ $key ] = $id;
	}

	update_option( NC_PAGES_OPTION, $ids );

	return $ids;
}

/**
 * 本文の {{page:key}} を固定ページのURLに置き換える（全ページ作成後に行う）。
 *
 * @param array $pages シードの定義。
 * @param array $ids   ページID。
 */
function nc_seed_link_pages( $pages, $ids ) {
	foreach ( $pages as $key => $spec ) {
		if ( empty( $spec['content'] ) || empty( $ids[ $key ] ) ) {
			continue;
		}

		$post    = get_post( $ids[ $key ] );
		$content = (string) preg_replace_callback(
			'/\{\{page:([a-z0-9-]+)\}\}/',
			static function ( $match ) use ( $ids ) {
				return isset( $ids[ $match[1] ] ) ? (string) get_permalink( $ids[ $match[1] ] ) : '#';
			},
			$post->post_content
		);

		if ( $content !== $post->post_content ) {
			wp_update_post( wp_slash( array( 'ID' => $post->ID, 'post_content' => $content ) ) );
		}
	}
}

/**
 * お知らせを作成する。既存のお知らせは識別子（_nc_seed_key）で探し、$force のときだけ更新する。
 * 更新するときも、公開日と投稿者は既存の値を保つ（再実行で並び順や投稿者が変わらないように）。
 *
 * @param string $seed_dir シードのディレクトリ。
 * @param bool   $force    既存の内容を上書きするか。
 */
function nc_seed_notices( $seed_dir, $force ) {
	$notices = json_decode( nc_seed_read( $seed_dir . '/notices.json' ), true );

	foreach ( $notices as $index => $item ) {
		$existing = nc_seed_find_notice( $item['key'], $item['title'] );

		if ( $existing && ! $force ) {
			nc_seed_tally( 'notices', 'kept' );
			continue;
		}

		$postarr = array(
			'post_type'    => 'notice',
			'post_status'  => 'publish',
			'post_title'   => $item['title'],
			'post_content' => $item['body'],
			'post_excerpt' => $item['excerpt'],
		);

		if ( $existing ) {
			$post                     = get_post( $existing );
			$postarr['ID']            = $post->ID;
			$postarr['post_date']     = $post->post_date;
			$postarr['post_date_gmt'] = $post->post_date_gmt;
			$postarr['post_author']   = $post->post_author;
		} else {
			// 一覧の順番を保つため、先頭のお知らせほど新しい日付にする（表示はしない）。
			$date                     = wp_date( 'Y-m-d H:i:s', time() - $index * HOUR_IN_SECONDS );
			$postarr['post_date']     = $date;
			$postarr['post_date_gmt'] = get_gmt_from_date( $date );
		}

		$id = wp_insert_post( wp_slash( $postarr ), true );

		if ( is_wp_error( $id ) ) {
			nc_seed_message( 'お知らせを保存できませんでした: ' . $item['title'] . ' / ' . $id->get_error_message(), true );
		}

		update_post_meta( $id, '_nc_seed_key', $item['key'] );
		update_post_meta( $id, '_nc_tag', $item['tag'] );
		update_post_meta( $id, '_nc_title_en', $item['title_en'] );
		update_post_meta( $id, '_nc_desc_en', $item['desc_en'] );
		update_post_meta( $id, '_nc_warn', $item['warn'] ? '1' : '' );
		update_post_meta( $id, '_nc_link_url', $item['link_url'] );
		update_post_meta( $id, '_nc_link_label', $item['link_label'] );

		nc_seed_tally( 'notices', $existing ? 'updated' : 'created' );
	}
}

/**
 * 初期データのお知らせを探す。識別子を優先し、無ければタイトルで探す。
 * ゴミ箱のお知らせも含める（管理者が削除したものを、再実行で作り直さないため）。
 *
 * @param string $key   識別子。
 * @param string $title タイトル。
 * @return int 投稿ID。見つからなければ 0。
 */
function nc_seed_find_notice( $key, $title ) {
	$statuses = array( 'publish', 'pending', 'draft', 'future', 'private', 'trash' );

	$found = get_posts(
		array(
			'post_type'      => 'notice',
			'post_status'    => $statuses,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_nc_seed_key',
			'meta_value'     => $key,
		)
	);

	if ( ! $found ) {
		$found = get_posts(
			array(
				'post_type'      => 'notice',
				'post_status'    => $statuses,
				'title'          => $title,
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
	}

	return $found ? (int) $found[0] : 0;
}

/**
 * ナビゲーションメニューを作成し、テーマの場所に割り当てる。
 * 既存のメニューは $force のときだけ作り直す。
 *
 * @param string $name     メニュー名。
 * @param string $location テーマの場所（primary, footer）。
 * @param array  $items    項目。title、en（英語の副題）、page または url を持つ。
 * @param bool   $force    既存のメニューを作り直すか。
 */
function nc_seed_menu( $name, $location, $items, $force ) {
	$existing = wp_get_nav_menu_object( $name );

	if ( $existing && ! $force ) {
		nc_seed_tally( 'menus', 'kept' );
		return;
	}

	if ( $existing ) {
		wp_delete_nav_menu( $existing->term_id );
	}

	$menu_id = wp_create_nav_menu( $name );

	if ( is_wp_error( $menu_id ) ) {
		nc_seed_message( 'メニューを作成できませんでした: ' . $name, true );
	}

	foreach ( $items as $item ) {
		$args = array(
			'menu-item-title'       => $item['title'],
			'menu-item-description' => $item['en'] ?? '',
			'menu-item-status'      => 'publish',
		);

		if ( isset( $item['page'] ) ) {
			$args['menu-item-type']      = 'post_type';
			$args['menu-item-object']    = 'page';
			$args['menu-item-object-id'] = $item['page'];
		} else {
			$args['menu-item-type'] = 'custom';
			$args['menu-item-url']  = $item['url'];
		}

		$item_id = wp_update_nav_menu_item( $menu_id, 0, $args );

		if ( is_wp_error( $item_id ) ) {
			nc_seed_message( 'メニュー項目を保存できませんでした: ' . $item['title'] . ' / ' . $item_id->get_error_message(), true );
		}
	}

	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	nc_seed_tally( 'menus', $existing ? 'updated' : 'created' );
}

// 1. 写真 → 2. 固定ページ → 3. ページ間リンク → 4. お知らせ → 5. メニューと設定。
$nc_seed_media = nc_seed_photos( __DIR__ );
$nc_seed_ids   = nc_seed_pages( $nc_seed_pages, $nc_seed_media['ids'], __DIR__, $nc_seed_force );
nc_seed_link_pages( $nc_seed_pages, $nc_seed_ids );
nc_seed_notices( __DIR__, $nc_seed_force );

nc_seed_menu(
	'ヘッダーメニュー',
	'primary',
	array(
		array( 'title' => 'ミサ', 'en' => 'Mass', 'page' => $nc_seed_ids['mass'] ),
		array( 'title' => '教会について', 'en' => 'About', 'url' => '/#about' ),
		array( 'title' => '活動', 'en' => 'Get involved', 'url' => '/#community' ),
		array( 'title' => 'お知らせ', 'en' => 'News', 'page' => $nc_seed_ids['notices'] ),
	),
	$nc_seed_force
);

nc_seed_menu(
	'フッターメニュー',
	'footer',
	array(
		array( 'title' => 'プライバシーポリシー', 'en' => 'Privacy policy', 'page' => $nc_seed_ids['privacy'] ),
		array( 'title' => 'サイトマップ', 'en' => 'Sitemap', 'page' => $nc_seed_ids['sitemap'] ),
		array( 'title' => '東京大司教区', 'en' => 'Archdiocese of Tokyo', 'url' => 'https://tokyo.catholic.jp/' ),
	),
	$nc_seed_force
);

// サイトの表示名と front page は初回（または強制実行時）だけ設定する。
if ( $nc_seed_first || $nc_seed_force ) {
	update_option( 'blogname', nc_parish_defaults()['name_ja'] );
	update_option( 'blogdescription', nc_parish_defaults()['name_en'] );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $nc_seed_ids['home'] );
	update_option( 'nc_seeded_at', time() );
}

// 教会情報は初期値を保存しない（コードの初期値を使い、管理画面で入力した値だけを保存する）。

// WordPress の初期データ（サンプル投稿・サンプルページ・プライバシーの下書き）を削除する。
// 同じ slug でも、初期データの見出しと一致するものだけを対象にする。
$nc_seed_defaults = array(
	array( 'post', 'hello-world', 'Hello world!' ),
	array( 'page', 'sample-page', 'Sample Page' ),
	array( 'page', 'privacy-policy', 'Privacy Policy' ),
);

foreach ( $nc_seed_defaults as $default ) {
	$leftover = get_page_by_path( $default[1], OBJECT, $default[0] );

	if ( $leftover && $default[2] === $leftover->post_title ) {
		wp_delete_post( $leftover->ID, true );
	}
}

kses_init_filters();
flush_rewrite_rules( false );

$nc_seed_labels   = array(
	'pages'   => '固定ページ',
	'notices' => 'お知らせ',
	'menus'   => 'メニュー',
);
$nc_seed_outcomes = array(
	'created' => '作成',
	'updated' => '更新',
	'kept'    => '変更なし',
);

nc_seed_message( $nc_seed_force ? '完了しました（NC_SEED_FORCE=1：初期内容に戻しました）。' : '完了しました（既存の内容は変更していません）。' );

foreach ( nc_seed_tally() as $type => $outcomes ) {
	$parts = array();

	foreach ( $nc_seed_outcomes as $outcome => $label ) {
		$parts[] = $label . ' ' . ( $outcomes[ $outcome ] ?? 0 );
	}

	nc_seed_message( $nc_seed_labels[ $type ] . '：' . implode( '、', $parts ) );
}

nc_seed_message( '写真：' . count( $nc_seed_media['ids'] ) . ' 件 取り込み済み' );
