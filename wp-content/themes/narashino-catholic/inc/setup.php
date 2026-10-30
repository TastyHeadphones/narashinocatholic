<?php
/**
 * テーマの基本設定、スタイルの読み込み。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'nc_setup' );

function nc_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => 'ヘッダーメニュー',
			'footer'  => 'フッターメニュー',
		)
	);
}

add_action( 'wp_enqueue_scripts', 'nc_enqueue_assets' );

function nc_enqueue_assets() {
	wp_enqueue_style(
		'narashino-catholic-fonts',
		'https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;600;700;800&family=Zen+Kaku+Gothic+New:wght@400;500;700&family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400;1,500&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'narashino-catholic',
		get_stylesheet_uri(),
		array( 'narashino-catholic-fonts' ),
		NC_VERSION
	);
}

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_action( 'wp_enqueue_scripts', 'nc_enqueue_contact_script' );

function nc_enqueue_contact_script() {
	if ( ! is_page_template( 'page-contact.php' ) ) {
		return;
	}

	wp_enqueue_script( 'narashino-catholic-contact', get_theme_file_uri( 'assets/js/contact.js' ), array(), NC_VERSION, true );
}
