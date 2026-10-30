<?php
/**
 * お知らせ（notice）: 短いお知らせを管理する投稿タイプ。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

/**
 * 追加項目: メタキー => 種類。
 *
 * _nc_show_date は、公開日を一覧と詳細に出すかどうか（既定では出さない）。
 */
const NC_NOTICE_FIELDS = array(
	'_nc_tag'        => 'text',
	'_nc_title_en'   => 'text',
	'_nc_desc_en'    => 'textarea',
	'_nc_warn'       => 'bool',
	'_nc_show_date'  => 'bool',
	'_nc_link_url'   => 'url',
	'_nc_link_label' => 'text',
);

add_action( 'init', 'nc_register_notices' );

function nc_register_notices() {
	register_post_type(
		'notice',
		array(
			'labels'        => array(
				'name'          => 'お知らせ',
				'singular_name' => 'お知らせ',
				'add_new'       => '新規追加',
				'add_new_item'  => '新しいお知らせを追加',
				'edit_item'     => 'お知らせを編集',
				'new_item'      => '新しいお知らせ',
				'view_item'     => 'お知らせを表示',
				'search_items'  => 'お知らせを検索',
				'not_found'     => 'お知らせが見つかりません',
				'all_items'     => 'すべてのお知らせ',
				'menu_name'     => 'お知らせ',
			),
			'public'        => true,
			'show_in_rest'  => true,
			'has_archive'   => false,
			'rewrite'       => array( 'slug' => 'notice' ),
			'supports'      => array( 'title', 'editor', 'excerpt', 'revisions' ),
			'menu_icon'     => 'dashicons-megaphone',
			'menu_position' => 6,
		)
	);

	foreach ( NC_NOTICE_FIELDS as $key => $type ) {
		register_post_meta(
			'notice',
			$key,
			array(
				'type'          => 'bool' === $type ? 'boolean' : 'string',
				'single'        => true,
				'show_in_rest' => true,
				'auth_callback' => 'nc_notice_meta_can_edit',
			)
		);
	}

	// 初期データの識別子は画面からは編集しない。
	register_post_meta(
		'notice',
		'_nc_seed_key',
		array(
			'type'          => 'string',
			'single'        => true,
			'show_in_rest'  => false,
			'auth_callback' => 'nc_notice_meta_can_edit',
		)
	);
}

/**
 * お知らせの項目を編集できるかどうか（投稿ごとに判定する）。
 *
 * @param bool   $allowed  既定の判定。
 * @param string $meta_key メタキー。
 * @param int    $post_id  投稿ID。
 * @return bool
 */
function nc_notice_meta_can_edit( $allowed, $meta_key, $post_id ) {
	return current_user_can( 'edit_post', $post_id );
}

add_action( 'add_meta_boxes_notice', 'nc_notices_add_meta_box' );

function nc_notices_add_meta_box() {
	add_meta_box( 'nc-notice-details', 'お知らせの表示内容（トップページのカード）', 'nc_notices_render_meta_box', 'notice', 'normal', 'high' );
}

function nc_notices_render_meta_box( $post ) {
	wp_nonce_field( 'nc_notice_save', 'nc_notice_nonce' );

	$values = array();
	foreach ( array_keys( NC_NOTICE_FIELDS ) as $key ) {
		$values[ $key ] = (string) get_post_meta( $post->ID, $key, true );
	}
	?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label for="nc_tag">カードのラベル</label></th>
				<td>
					<input type="text" class="regular-text" id="nc_tag" name="nc_notice[_nc_tag]" value="<?php echo esc_attr( $values['_nc_tag'] ); ?>">
					<p class="description">例：10.31（土）、注意、東京大司教区</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="nc_title_en">英語の見出し</label></th>
				<td><input type="text" class="regular-text" id="nc_title_en" name="nc_notice[_nc_title_en]" value="<?php echo esc_attr( $values['_nc_title_en'] ); ?>"></td>
			</tr>
			<tr>
				<th scope="row"><label for="nc_desc_en">英語の説明</label></th>
				<td><textarea class="large-text" rows="2" id="nc_desc_en" name="nc_notice[_nc_desc_en]"><?php echo esc_textarea( $values['_nc_desc_en'] ); ?></textarea></td>
			</tr>
			<tr>
				<th scope="row">注意の表示</th>
				<td>
					<label>
						<input type="checkbox" name="nc_notice[_nc_warn]" value="1" <?php checked( $values['_nc_warn'], '1' ); ?>>
						注意喚起として赤色のラベルで表示する
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">日付の表示</th>
				<td>
					<label>
						<input type="checkbox" name="nc_notice[_nc_show_date]" value="1" <?php checked( $values['_nc_show_date'], '1' ); ?>>
						公開日を一覧と詳細に表示する
					</label>
					<p class="description">公式サイトのお知らせには日付がなかったため、既定では表示しません。</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="nc_link_url">関連リンク</label></th>
				<td>
					<input type="url" class="regular-text" id="nc_link_url" name="nc_notice[_nc_link_url]" value="<?php echo esc_attr( $values['_nc_link_url'] ); ?>">
					<input type="text" class="regular-text" id="nc_link_label" name="nc_notice[_nc_link_label]" placeholder="リンクの文言" value="<?php echo esc_attr( $values['_nc_link_label'] ); ?>">
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

add_action( 'save_post_notice', 'nc_notices_save_meta_box', 10, 2 );

function nc_notices_save_meta_box( $post_id, $post ) {
	if ( ! isset( $_POST['nc_notice_nonce'] ) ) {
		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['nc_notice_nonce'] ) );

	if ( ! wp_verify_nonce( $nonce, 'nc_notice_save' ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}

	$input = isset( $_POST['nc_notice'] ) && is_array( $_POST['nc_notice'] ) ? wp_unslash( $_POST['nc_notice'] ) : array();

	foreach ( NC_NOTICE_FIELDS as $key => $type ) {
		$raw = isset( $input[ $key ] ) && is_scalar( $input[ $key ] ) ? (string) $input[ $key ] : '';
		update_post_meta( $post_id, $key, nc_sanitize_notice_value( $raw, $type ) );
	}
}

/**
 * お知らせの項目を種類に応じて整形する。
 *
 * @param string $raw  入力値。
 * @param string $type 種類（text, textarea, url, bool）。
 * @return string
 */
function nc_sanitize_notice_value( $raw, $type ) {
	switch ( $type ) {
		case 'bool':
			return $raw ? '1' : '';
		case 'url':
			return esc_url_raw( $raw );
		case 'textarea':
			return sanitize_textarea_field( $raw );
		default:
			return sanitize_text_field( $raw );
	}
}

/**
 * お知らせの項目を取得する。
 *
 * @param string $key     メタキー。
 * @param int    $post_id 投稿ID。省略時は現在の投稿。
 * @return string
 */
function nc_notice_meta( $key, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();

	return (string) get_post_meta( $post_id, $key, true );
}

/**
 * 公開中の新しいお知らせを取得する。
 *
 * @param int $count 件数。
 * @return WP_Post[]
 */
function nc_latest_notices( $count = 3 ) {
	return get_posts(
		array(
			'post_type'        => 'notice',
			'post_status'      => 'publish',
			'posts_per_page'   => $count,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'no_found_rows'    => true,
			'suppress_filters' => false,
		)
	);
}
