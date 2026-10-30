<?php
/**
 * 検索結果ページ（ヘッダーには検索欄がないため、?s= で直接開いた場合に使われる）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main">
	<?php
	get_template_part(
		'template-parts/page-hero',
		null,
		array(
			'title' => '検索結果',
			'en'    => 'Search results',
			'trail' => array(),
		)
	);
	?>
	<section class="page-body">
		<div class="wrap">
			<p class="lead-ja">「<?php echo esc_html( get_search_query() ); ?>」の検索結果です。</p>
			<?php if ( have_posts() ) : ?>
				<ul class="nlist">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<li>
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<span><b><?php echo esc_html( get_the_title() ); ?></b></span>
								<?php echo nc_arrow(); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<p class="empty">一致するページは見つかりませんでした。</p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
