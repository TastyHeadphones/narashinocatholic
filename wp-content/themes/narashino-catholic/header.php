<?php
/**
 * ヘッダー：告知バーと、ロゴ・ナビゲーションのある上部の帯。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html lang="ja">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">本文へ進む</a>
<div class="page" id="top">

<?php if ( '' !== nc_announcement() ) : ?>
<div class="announce">
	<div class="wrap">
		<span class="ann-tag">お知らせ</span>
		<span><?php echo esc_html( nc_announcement() ); ?><?php if ( nc_parish( 'announcement_en' ) ) : ?> <span class="en"><?php echo esc_html( nc_parish( 'announcement_en' ) ); ?></span><?php endif; ?></span>
		<a href="<?php echo esc_url( nc_url( 'notices' ) ); ?>">詳細 <span class="en">Details</span></a>
	</div>
</div>
<?php endif; ?>

<div class="night">
	<div class="wrap bar">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<svg viewBox="0 0 46 46" aria-hidden="true">
				<rect width="46" height="46" fill="#B0402A"/>
				<path d="M14.5 37V25a8.5 8.5 0 0 1 17 0v12" fill="none" stroke="#F4EFE4" stroke-width="2.2"/>
				<rect x="22" y="9" width="2.2" height="9" fill="#F4EFE4"/>
				<rect x="19.4" y="12" width="7.4" height="2.2" fill="#F4EFE4"/>
			</svg>
			<span>
				<b><?php echo esc_html( nc_parish( 'name_ja' ) ); ?></b>
				<small><?php echo esc_html( nc_parish( 'name_en' ) ); ?></small>
			</span>
		</a>
		<nav class="nav" aria-label="メインメニュー">
			<?php nc_primary_nav(); ?>
			<a class="btn fill-gold sm" href="<?php echo esc_url( nc_url( 'contact' ) ); ?>">お問い合わせ</a>
		</nav>
	</div>
</div>
