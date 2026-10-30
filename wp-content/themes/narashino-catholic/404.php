<?php
/**
 * Not found page.
 *
 * @package NarashinoCatholic
 */

get_header();
?>

<section class="sec">
  <div class="wrap narrow">
    <header class="page-head">
      <p class="label">404</p>
      <h1 class="h2">ページが見つかりません<span class="en">Page not found</span></h1>
    </header>
    <p class="sub">お探しのページは移動したか、削除された可能性があります。<span class="en">The page may have moved or been removed.</span></p>
    <p class="back">
      <a class="link" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ <span class="en">Back to home</span><?php echo nc_arrow(); ?></a>
    </p>
  </div>
</section>

<?php get_footer(); ?>
