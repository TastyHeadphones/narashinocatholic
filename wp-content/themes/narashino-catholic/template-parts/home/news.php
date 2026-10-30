<?php
/**
 * トップページ：お知らせ（新しい順に3件）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

$notices = nc_latest_notices( 3 );
?>
<section class="sec paper" id="news" aria-labelledby="news-title">
	<div class="wrap">
		<div class="split-head">
			<div>
				<p class="label">NEWS · お知らせ</p>
				<h2 class="h2" id="news-title">お知らせ<span class="en">Notices</span></h2>
			</div>
			<a class="link" href="<?php echo esc_url( nc_url( 'notices' ) ); ?>">すべてのお知らせ <span class="en">All notices</span><?php echo nc_arrow(); ?></a>
		</div>
		<?php if ( $notices ) : ?>
		<div class="tz-grid">
			<?php
			foreach ( $notices as $notice ) {
				get_template_part( 'template-parts/notice-card', null, array( 'notice' => $notice ) );
			}
			?>
		</div>
		<?php else : ?>
		<p class="empty">現在、お知らせはありません。</p>
		<?php endif; ?>
	</div>
</section>
