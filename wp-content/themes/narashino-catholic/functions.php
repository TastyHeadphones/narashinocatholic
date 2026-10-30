<?php
/**
 * Narashino Catholic theme setup.
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

define( 'NC_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/post-meta.php';

/**
 * Registers theme features.
 */
function nc_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'style', 'script' ] );
}
add_action( 'after_setup_theme', 'nc_setup' );

/**
 * Loads the web fonts and the theme stylesheet.
 */
function nc_enqueue_assets() {
	wp_enqueue_style(
		'nc-fonts',
		'https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;600;700;800&family=Zen+Kaku+Gothic+New:wght@400;500;700&family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400;1,500&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'nc-style', get_stylesheet_uri(), [ 'nc-fonts' ], NC_VERSION );
}
add_action( 'wp_enqueue_scripts', 'nc_enqueue_assets' );

/**
 * Returns the placeholder default of a theme setting.
 *
 * @param string $key Setting key from nc_settings().
 * @return string|int
 */
function nc_default( $key ) {
	$settings = nc_settings();

	return $settings[ $key ]['default'];
}

/**
 * Returns a theme setting, or its default until one is saved.
 *
 * @param string $key Setting key from nc_settings().
 * @return mixed
 */
function nc_get( $key ) {
	return get_theme_mod( $key, nc_default( $key ) );
}

/**
 * Returns a setting as escaped HTML. A value that still equals its placeholder is dashed,
 * so unfilled parish details are easy to spot on the page.
 *
 * @param string $key Setting key from nc_settings().
 * @return string
 */
function nc_field( $key ) {
	$value = (string) nc_get( $key );
	$html  = nl2br( esc_html( $value ) );

	if ( $value === nc_default( $key ) ) {
		return '<span class="ph">' . $html . '</span>';
	}

	return $html;
}

/**
 * Arrow icon for links and buttons.
 *
 * @return string
 */
function nc_arrow() {
	return '<svg class="arr" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';
}
