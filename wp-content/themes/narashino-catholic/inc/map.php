<?php
/**
 * 地図：Google マップの埋め込み（ショートコード [nc_map]）。
 *
 * 地図は画像ではなく Google マップで表示する。埋め込みは API キーを使わない形式。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'nc_map', 'nc_map_shortcode' );

/**
 * 教会の地図と「Google マップで開く」リンクを出力する。
 *
 * 使い方: [nc_map] または [nc_map lang="en"]
 *
 * @param array|string $atts ショートコードの属性。
 * @return string
 */
function nc_map_shortcode( $atts ) {
	$atts  = shortcode_atts( array( 'lang' => 'ja' ), is_array( $atts ) ? $atts : array(), 'nc_map' );
	$lang  = 'en' === $atts['lang'] ? 'en' : 'ja';
	$query = nc_parish( 'name_ja' ) . ' ' . nc_parish( 'postal_address' );

	$embed_url = add_query_arg(
		array(
			'q'      => $query,
			'hl'     => $lang,
			'z'      => 17,
			'output' => 'embed',
		),
		'https://www.google.com/maps'
	);

	$open_url = add_query_arg(
		array(
			'api'   => 1,
			'query' => $query,
		),
		'https://www.google.com/maps/search/'
	);

	$title = 'en' === $lang ? 'Map of Catholic Narashino Church' : 'カトリック習志野教会の地図';
	$link  = 'en' === $lang ? 'Open in Google Maps' : 'Google マップで開く';

	return sprintf(
		'<div class="map-frame"><iframe title="%1$s" src="%2$s" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>'
		. '<p class="map-actions"><a class="link" href="%3$s" target="_blank" rel="noopener">%4$s</a></p>',
		esc_attr( $title ),
		esc_url( $embed_url ),
		esc_url( $open_url ),
		esc_html( $link )
	);
}
