<?php
/**
 * Notices list, archives, and search results.
 *
 * @package NarashinoCatholic
 */

get_header();

if ( is_search() ) {
	$heading = '検索結果 · ' . get_search_query();
} elseif ( is_home() ) {
	$heading = 'お知らせ';
} else {
	$heading = wp_strip_all_tags( get_the_archive_title() );
}
?>

<section class="sec">
  <div class="wrap narrow">
    <header class="page-head">
      <p class="label">NEWS · お知らせ</p>
      <h1 class="h2"><?php echo esc_html( $heading ); ?></h1>
    </header>

    <?php if ( have_posts() ) : ?>
      <ul class="post-list">
        <?php while ( have_posts() ) : the_post(); ?>
          <li class="post-item">
            <p class="post-date"><?php echo esc_html( get_the_date() ); ?></p>
            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
          </li>
        <?php endwhile; ?>
      </ul>

      <?php the_posts_pagination( [ 'prev_text' => '前へ · Prev', 'next_text' => '次へ · Next' ] ); ?>
    <?php else : ?>
      <p class="sub">まだお知らせはありません。<span class="en">No notices yet.</span></p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
