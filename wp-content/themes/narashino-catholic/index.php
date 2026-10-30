<?php
/**
 * 既定のテンプレート（該当するテンプレートがない場合）。投稿の一覧を表示する。
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
			'title' => get_bloginfo( 'name' ),
			'en'    => '',
			'trail' => array(),
		)
	);
	?>
	<section class="page-body">
		<div class="wrap">
			<?php if ( have_posts() ) : ?>
				<ul class="nlist">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<span>
									<span class="meta"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?></time></span>
									<b><?php echo esc_html( get_the_title() ); ?></b>
								</span>
								<?php echo nc_arrow(); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else : ?>
				<p class="empty">ページが見つかりません。</p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
