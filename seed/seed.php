<?php
/**
 * 教会サイトの初期データを投入する（固定ページ、画像、お知らせ、メニュー）。
 *
 * 実行方法（テーマを有効化してから）:
 *   wp eval-file /seed/seed.php
 *
 * 既定では、まだ無いものだけを作成する。管理画面で編集した内容は上書きしない。
 * NC_SEED_FORCE=1 を付けると、固定ページ・お知らせ・メニューを初期内容に戻す
 * （教会情報の設定は上書きしない）。
 * 内容の出典は現在の公式サイト（https://www.narashinocatholic.com/）。
 *
 * @package NarashinoCatholic
 */

if ( ! function_exists( 'nc_parish_defaults' ) ) {
	nc_seed_message( 'narashino-catholic テーマを有効化してから実行してください。', true );
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

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
	'sacraments'    => array( 'title' => '秘跡（SACRAMENTS)', 'slug' => '秘跡-sacraments', 'parent' => 'parish', 'en' => 'Sacraments' ),
	'courses'       => array( 'title' => '各講座の案内', 'slug' => '各講座の案内', 'parent' => 'parish', 'en' => 'Classes and courses', 'content' => 'courses.html' ),
	'movable'       => array( 'title' => '年間移動祝日一覧', 'slug' => '年間移動祝日一覧', 'parent' => 'parish', 'en' => 'Movable feasts' ),
	'calendar'      => array( 'title' => '年間典礼行事予定', 'slug' => '年間典礼行事予定', 'parent' => 'parish', 'en' => 'Liturgical calendar', 'content' => 'calendar.html' ),
	'anniversary'   => array( 'title' => '50周年記念ミサ関連', 'slug' => '50周年記念ミサ関連', 'parent' => 'parish', 'en' => '50th anniversary', 'content' => 'anniversary.html' ),
	'gallery'       => array( 'title' => '50周年記念ミサギャラリー', 'slug' => '50周年記念ミサギャラリー', 'parent' => 'anniversary', 'en' => 'Anniversary Mass gallery', 'content' => 'gallery.html' ),
	'priest'        => array( 'title' => '司祭の紹介', 'slug' => '司祭の紹介', 'en' => 'Our priest', 'content' => 'priest.html', 'image' => 'priest-portrait' ),
	'message'       => array( 'title' => '司祭からの言葉', 'slug' => '司祭からの言葉', 'en' => 'A word from our priest', 'content' => 'message.html', 'excerpt' => '「二本の映画」（習志野教会ニュース77号より）' ),
	'map'           => array( 'title' => '教会地図', 'slug' => '教会地図', 'en' => 'Church map', 'content' => 'map.html' ),
	'bible'         => array( 'title' => '聖書講座', 'slug' => '聖書講座', 'en' => 'Bible class', 'content' => 'bible.html' ),
	'notices'       => array( 'title' => 'お知らせ一覧', 'slug' => 'お知らせ一覧', 'en' => 'Notices', 'template' => 'page-notices.php' ),
	'cleaning'      => array( 'title' => '教会の清掃の奉仕者・協力者募集', 'slug' => '教会の清掃の奉仕者-協力者募集', 'parent' => 'notices', 'en' => 'Cleaning volunteers', 'content' => 'cleaning.html' ),
	'contact'       => array( 'title' => 'お問い合せ', 'slug' => 'お問い合せ', 'en' => 'Contact', 'template' => 'page-contact.php', 'content' => 'contact.html' ),
	'links'         => array( 'title' => '外部リンク', 'slug' => '外部リンク', 'en' => 'Links', 'content' => 'links.html' ),
	'link-list'     => array( 'title' => 'リンク集', 'slug' => 'リンク集', 'parent' => 'links', 'en' => 'Useful links', 'content' => 'link-list.html' ),
	'english'       => array( 'title' => 'English Page', 'slug' => 'english-page', 'en' => 'English' ),
	'english-guide' => array( 'title' => 'English Guide', 'slug' => 'english-guide', 'parent' => 'english', 'en' => 'Church guide', 'content' => 'english-guide.html' ),
	'english-map'   => array( 'title' => 'Map', 'slug' => 'map', 'parent' => 'english', 'en' => 'Directions', 'content' => 'english-map.html' ),
	'access'        => array( 'title' => 'アクセス（ACCESS)', 'slug' => 'アクセス-access', 'en' => 'Access', 'content' => 'access.html' ),
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
 * 画像を取り込む。失敗したら 0 を返す。
 *
 * @param string $key  画像の識別子（ファイル名にも使う）。
 * @param string $url  取得元のURL。
 * @param string $alt  代替テキスト。
 * @return int 添付ファイルのID。
 */
function nc_seed_sideload( $key, $url, $alt ) {
	$tmp = download_url( $url, 60 );

	if ( is_wp_error( $tmp ) ) {
		return 0;
	}

	$ext = strtolower( pathinfo( (string) wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION ) );
	$id  = media_handle_sideload(
		array(
			'name'     => $key . '.' . $ext,
			'tmp_name' => $tmp,
		),
		0,
		$alt
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
 * 画像をまとめて取り込む（取り込み済みのものは再利用）。
 *
 * @param string $seed_dir シードのディレクトリ。
 * @return array{images: array<string, int>, manifest: array<string, array{url: string, alt: string}>}
 */
function nc_seed_images( $seed_dir ) {
	$manifest = json_decode( (string) file_get_contents( $seed_dir . '/images.json' ), true );
	$stored   = get_option( 'nc_image_ids', array() );
	$ids      = array();

	foreach ( $manifest as $key => $item ) {
		$id = isset( $stored[ $key ] ) ? (int) $stored[ $key ] : 0;

		if ( ! $id || ! get_post( $id ) ) {
			$id = nc_seed_sideload( $key, $item['url'], $item['alt'] );
		}

		if ( $id ) {
			$ids[ $key ] = $id;
		} else {
			nc_seed_message( '画像を取り込めませんでした（元のURLを使用します）: ' . $key );
		}
	}

	update_option( 'nc_image_ids', $ids );

	return array(
		'images'   => $ids,
		'manifest' => $manifest,
	);
}

/**
 * 本文のプレースホルダ（{{img:key}}）を実際のURLに置き換える。
 *
 * @param string $html     本文。
 * @param array  $images   取り込み済みの画像ID。
 * @param array  $manifest 画像の定義（取り込めなかった場合のURL）。
 * @return string
 */
function nc_seed_fill_images( $html, $images, $manifest ) {
	return (string) preg_replace_callback(
		'/\{\{img:([a-z0-9-]+)\}\}/',
		static function ( $match ) use ( $images, $manifest ) {
			$key = $match[1];

			if ( isset( $images[ $key ] ) ) {
				return (string) wp_get_attachment_url( $images[ $key ] );
			}

			return isset( $manifest[ $key ] ) ? $manifest[ $key ]['url'] : '';
		},
		$html
	);
}

/**
 * 固定ページを作成する（既存のページは $force のときだけ初期内容に戻す）。
 *
 * @param array  $pages    固定ページの定義。
 * @param array  $images   取り込み済みの画像ID。
 * @param array  $manifest 画像の定義。
 * @param string $seed_dir シードのディレクトリ。
 * @param bool   $force    既存の内容を上書きするか。
 * @return array<string, int> 識別子 => ページID。
 */
function nc_seed_pages( $pages, $images, $manifest, $seed_dir, $force ) {
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
			$content = nc_seed_fill_images(
				(string) file_get_contents( $seed_dir . '/pages/' . $spec['content'] ),
				$images,
				$manifest
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

		if ( ! empty( $spec['image'] ) && isset( $images[ $spec['image'] ] ) ) {
			set_post_thumbnail( $id, $images[ $spec['image'] ] );
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
 * お知らせを作成する（既存のお知らせは $force のときだけ更新する）。
 *
 * @param string $seed_dir シードのディレクトリ。
 * @param bool   $force    既存の内容を上書きするか。
 */
function nc_seed_notices( $seed_dir, $force ) {
	$notices = json_decode( (string) file_get_contents( $seed_dir . '/notices.json' ), true );

	foreach ( $notices as $index => $item ) {
		$existing = get_posts(
			array(
				'post_type'      => 'notice',
				'post_status'    => 'any',
				'title'          => $item['title'],
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

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
			$postarr['ID'] = $existing[0];
		} else {
			// 一覧の順番を保つため、先頭のお知らせほど新しい日付にする。
			$date                     = wp_date( 'Y-m-d H:i:s', time() - $index * HOUR_IN_SECONDS );
			$postarr['post_date']     = $date;
			$postarr['post_date_gmt'] = get_gmt_from_date( $date );
		}

		$id = wp_insert_post( wp_slash( $postarr ), true );

		if ( is_wp_error( $id ) ) {
			nc_seed_message( 'お知らせを保存できませんでした: ' . $item['title'] . ' / ' . $id->get_error_message(), true );
		}

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

		wp_update_nav_menu_item( $menu_id, 0, $args );
	}

	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	nc_seed_tally( 'menus', $existing ? 'updated' : 'created' );
}

// 1. 画像 → 2. 固定ページ → 3. ページ間リンク → 4. お知らせ → 5. メニューと設定。
$nc_seed_media = nc_seed_images( __DIR__ );
$nc_seed_ids   = nc_seed_pages( $nc_seed_pages, $nc_seed_media['images'], $nc_seed_media['manifest'], __DIR__, $nc_seed_force );
nc_seed_link_pages( $nc_seed_pages, $nc_seed_ids );
nc_seed_notices( __DIR__, $nc_seed_force );

nc_seed_menu(
	'ヘッダーメニュー',
	'primary',
	array(
		array( 'title' => 'ミサ', 'en' => 'Mass', 'page' => $nc_seed_ids['mass'] ),
		array( 'title' => '教会について', 'en' => 'About', 'url' => home_url( '/#about' ) ),
		array( 'title' => '活動', 'en' => 'Get involved', 'url' => home_url( '/#community' ) ),
		array( 'title' => 'お知らせ', 'en' => 'News', 'page' => $nc_seed_ids['notices'] ),
	),
	$nc_seed_force
);

nc_seed_menu(
	'フッターメニュー',
	'footer',
	array(
		array( 'title' => 'プライバシーポリシー', 'page' => $nc_seed_ids['privacy'] ),
		array( 'title' => 'サイトマップ', 'page' => $nc_seed_ids['sitemap'] ),
		array( 'title' => '東京大司教区', 'url' => 'https://tokyo.catholic.jp/' ),
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

// 教会情報は管理画面で編集されることが多いため、無い場合にだけ初期値を入れる。
if ( false === get_option( NC_PARISH_OPTION ) ) {
	add_option( NC_PARISH_OPTION, nc_parish_defaults() );
}

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

nc_seed_message( '画像：' . count( $nc_seed_media['images'] ) . ' 件 取り込み済み' );
