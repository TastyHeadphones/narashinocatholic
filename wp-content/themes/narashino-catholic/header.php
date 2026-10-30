<?php
/**
 * Document head, announcement bar, and site header.
 *
 * @package NarashinoCatholic
 */

$announce_ja = nc_get( 'nc_announce_ja' );
$announce_en = nc_get( 'nc_announce_en' );
?>
<!doctype html>
<html lang="ja">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">本文へ · Skip to content</a>

<?php if ( $announce_ja ) : ?>
<div class="announce">
  <div class="wrap">
    <span class="ann-tag">お知らせ</span>
    <span>
      <?php echo esc_html( $announce_ja ); ?>
      <?php if ( $announce_en ) : ?>
        <span class="en"><?php echo esc_html( $announce_en ); ?></span>
      <?php endif; ?>
    </span>
    <a href="<?php echo esc_url( home_url( '/#news' ) ); ?>">詳細 <span class="en">Details</span></a>
  </div>
</div>
<?php endif; ?>

<header class="site-header night">
  <div class="wrap bar">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <svg viewBox="0 0 46 46" aria-hidden="true">
        <rect width="46" height="46" fill="#B0402A"/>
        <path d="M14.5 37V25a8.5 8.5 0 0 1 17 0v12" fill="none" stroke="#F4EFE4" stroke-width="2.2"/>
        <rect x="22" y="9" width="2.2" height="9" fill="#F4EFE4"/>
        <rect x="19.4" y="12" width="7.4" height="2.2" fill="#F4EFE4"/>
      </svg>
      <span>
        <b>カトリック習志野教会</b>
        <small>Catholic Narashino Church</small>
      </span>
    </a>
    <nav class="nav" aria-label="メインメニュー">
      <a class="nl" href="<?php echo esc_url( home_url( '/#mass' ) ); ?>">ミサ <span class="en">Mass</span></a>
      <a class="nl" href="<?php echo esc_url( home_url( '/#about' ) ); ?>">教会について <span class="en">About</span></a>
      <a class="nl" href="<?php echo esc_url( home_url( '/#community' ) ); ?>">活動 <span class="en">Get involved</span></a>
      <a class="nl" href="<?php echo esc_url( home_url( '/#news' ) ); ?>">お知らせ <span class="en">News</span></a>
      <a class="btn fill-gold sm" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">お問い合わせ</a>
    </nav>
  </div>
</header>

<main id="main">
