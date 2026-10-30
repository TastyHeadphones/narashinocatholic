<?php
/**
 * Template Name: サイトマップ
 *
 * すべての固定ページと最新のお知らせを一覧にする。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$notices = get_posts(
		array(
			'post_type'      => 'notice',
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'no_found_rows'  => true,
		)
	);
	?>
	<main id="main">
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title' => get_the_title(),
				'en'    => nc_page_en(),
				'trail' => array(),
			)
		);
		?>

		<section class="page-body">
			<div class="wrap">
				<div class="sitemap-grid">
					<div>
						<h2>ページ</h2>
						<ul>
							<?php
							wp_list_pages(
								array(
									'title_li' => '',
									'depth'    => 0,
								)
							);
							?>
						</ul>
					</div>
					<div>
						<h2>お知らせ</h2>
						<?php if ( $notices ) : ?>
							<ul>
								<?php foreach ( $notices as $notice ) : ?>
									<li><a href="<?php echo esc_url( get_permalink( $notice ) ); ?>"><?php echo esc_html( get_the_title( $notice ) ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php else : ?>
							<p class="empty">現在、お知らせはありません。</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
