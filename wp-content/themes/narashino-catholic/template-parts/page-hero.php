<?php
/**
 * 下層ページの見出し帯（パンくず、タイトル、英語の副題）。
 *
 * @package NarashinoCatholic
 *
 * @var array{title: string, en: string, trail: array<int, array{0: string, 1: string}>} $args
 */

defined( 'ABSPATH' ) || exit;

$title = $args['title'];
$en    = $args['en'];
$trail = isset( $args['trail'] ) ? $args['trail'] : array();
?>
<section class="page-hero">
	<div class="wrap">
		<nav class="crumb" aria-label="現在の位置">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a>
			<?php foreach ( $trail as $crumb ) : ?>
				<span aria-hidden="true">›</span> <a href="<?php echo esc_url( $crumb[0] ); ?>"><?php echo esc_html( $crumb[1] ); ?></a>
			<?php endforeach; ?>
		</nav>
		<h1 class="page-title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $en ) : ?>
			<p class="en-sub"><?php echo esc_html( $en ); ?></p>
		<?php endif; ?>
	</div>
</section>
