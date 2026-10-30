<?php
/**
 * 404（ページが見つからない）。
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
			'title' => 'ページが見つかりません',
			'en'    => 'Page not found',
			'trail' => array(),
		)
	);
	?>
	<section class="page-body">
		<div class="wrap">
			<p class="lead-ja">お探しのページは移動または削除された可能性があります。トップページからご覧ください。</p>
			<p><a class="btn fill-gold" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ <span class="en">Back to home</span></a></p>
		</div>
	</section>
</main>
<?php
get_footer();
