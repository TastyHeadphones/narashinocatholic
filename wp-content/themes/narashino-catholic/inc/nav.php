<?php
/**
 * ナビゲーション：ヘッダーのメニュー（英語の副題つき）とフッターのメニュー（同じく英語つき）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

/**
 * ヘッダー用のウォーカー。項目の説明文を英語の副題として表示する。
 */
class NC_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		// 現在のページだけを示す。/#about などページ内の項目には付けない。
		$current = 'post_type' === $data_object->type && in_array( 'current-menu-item', (array) $data_object->classes, true );

		$output .= sprintf(
			'<a class="nl" href="%1$s"%2$s>%3$s',
			esc_url( $data_object->url ),
			$current ? ' aria-current="page"' : '',
			esc_html( $data_object->title )
		);

		if ( $data_object->description ) {
			$output .= ' <span class="en">' . esc_html( $data_object->description ) . '</span>';
		}

		$output .= '</a>';
	}
}

/**
 * フッター用のウォーカー。<li><a> の形で、英語の副題を添える。
 */
class NC_Footer_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$output .= '<li><a href="' . esc_url( $data_object->url ) . '">' . esc_html( $data_object->title );

		if ( $data_object->description ) {
			$output .= ' <span class="en">' . esc_html( $data_object->description ) . '</span>';
		}

		$output .= '</a>';
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * ヘッダーのナビゲーションを出力する。
 */
function nc_primary_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'walker'         => new NC_Nav_Walker(),
			'fallback_cb'    => 'nc_fallback_primary_nav',
		)
	);
}

/**
 * メニュー未設定時のヘッダーナビゲーション。
 */
function nc_fallback_primary_nav() {
	$items = array(
		array( nc_url( 'mass' ), 'ミサ', 'Mass' ),
		array( home_url( '/#about' ), '教会について', 'About' ),
		array( home_url( '/#community' ), '活動', 'Get involved' ),
		array( nc_url( 'notices' ), 'お知らせ', 'News' ),
	);

	foreach ( $items as $item ) {
		printf(
			'<a class="nl" href="%1$s">%2$s <span class="en">%3$s</span></a>',
			esc_url( $item[0] ),
			esc_html( $item[1] ),
			esc_html( $item[2] )
		);
	}
}

/**
 * フッターのリンクを出力する。
 */
function nc_footer_nav() {
	wp_nav_menu(
		array(
			'theme_location' => 'footer',
			'container'      => false,
			'items_wrap'     => '<ul class="flinks">%3$s</ul>',
			'walker'         => new NC_Footer_Walker(),
			'fallback_cb'    => 'nc_fallback_footer_nav',
		)
	);
}

/**
 * メニュー未設定時のフッターのリンク。
 */
function nc_fallback_footer_nav() {
	echo '<ul class="flinks">';
	printf( '<li><a href="%s">プライバシーポリシー <span class="en">Privacy policy</span></a></li>', esc_url( nc_url( 'privacy' ) ) );
	printf( '<li><a href="%s">サイトマップ <span class="en">Sitemap</span></a></li>', esc_url( nc_url( 'sitemap' ) ) );
	echo '<li><a href="https://tokyo.catholic.jp/">東京大司教区 <span class="en">Archdiocese of Tokyo</span></a></li>';
	echo '</ul>';
}
