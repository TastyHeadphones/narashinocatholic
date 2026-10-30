<?php
/**
 * カトリック習志野教会テーマの読み込み。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

define( 'NC_VERSION', '1.0.0' );

require_once get_theme_file_path( 'inc/helpers.php' );
require_once get_theme_file_path( 'inc/setup.php' );
require_once get_theme_file_path( 'inc/parish.php' );
require_once get_theme_file_path( 'inc/pages.php' );
require_once get_theme_file_path( 'inc/notices.php' );
require_once get_theme_file_path( 'inc/nav.php' );
require_once get_theme_file_path( 'inc/contact.php' );
require_once get_theme_file_path( 'inc/map.php' );
