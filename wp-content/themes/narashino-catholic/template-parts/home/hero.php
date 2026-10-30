<?php
/**
 * トップページ：ヒーロー（見出し・導入・主要ページへの入口）と夕暮れの教会の挿絵。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="night">
	<section class="hero" aria-labelledby="hero-title">
		<div class="wrap hero-grid">
			<div>
				<div class="eyebrow-row">
					<p class="eyebrow rise" style="--d:140ms">WELCOME · ようこそ</p>
					<div class="hanko stamp" style="--d:0ms" aria-hidden="true"><span>愛</span></div>
				</div>
				<h1 id="hero-title"><span class="h-line rise" style="--d:240ms">神を愛し、</span><span class="h-line rise" style="--d:320ms">隣人を愛する</span></h1>
				<p class="lede rise" style="--d:420ms">Love God. Love your neighbor.</p>
				<p class="copy rise" style="--d:500ms">祈りと交わりの場として、どなたもお気軽にお越しください。</p>
				<p class="copy-en rise" style="--d:560ms">A place of prayer and fellowship in Narashino, Chiba. Whether this is your first visit or you have been part of our community for years, you are welcome here.</p>
				<div class="cta rise" style="--d:640ms">
					<a class="btn fill-gold" href="<?php echo esc_url( nc_url( 'mass' ) ); ?>">ミサの時間を見る <span class="en">Mass times</span><?php echo nc_arrow(); ?></a>
					<a class="btn line-light" href="<?php echo esc_url( nc_url( 'access' ) ); ?>">アクセス <span class="en">Visit us</span></a>
				</div>
			</div>
			<nav class="quick" aria-label="主要なページ">
				<a class="rise" style="--d:720ms" href="<?php echo esc_url( nc_url( 'mass' ) ); ?>"><span class="n">01</span><span><b>ミサ</b><span class="en">Mass times</span></span><?php echo nc_arrow(); ?></a>
				<a class="rise" style="--d:790ms" href="<?php echo esc_url( nc_url( 'access' ) ); ?>"><span class="n">02</span><span><b>アクセス</b><span class="en">Visit us</span></span><?php echo nc_arrow(); ?></a>
				<a class="rise" style="--d:860ms" href="#community"><span class="n">03</span><span><b>活動</b><span class="en">Get involved</span></span><?php echo nc_arrow(); ?></a>
			</nav>
		</div>
		<p class="vertical fade-in" style="--d:900ms" aria-hidden="true"><?php echo esc_html( nc_parish( 'name_ja' ) ); ?></p>
	</section>
	<?php nc_svg( 'panorama' ); ?>
</div>
