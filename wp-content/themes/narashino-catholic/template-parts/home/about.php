<?php
/**
 * トップページ：教会について（50年の歩み、バラ窓）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="sec" id="about" aria-labelledby="about-title">
	<div class="wrap about-grid">
		<div class="rose-wrap">
			<?php nc_svg( 'rose' ); ?>
			<?php nc_svg( 'seal' ); ?>
		</div>
		<div>
			<p class="fifty" aria-hidden="true">50</p>
			<p class="fifty-cap">年の歩み <span class="en">Fifty years</span></p>
			<p class="label" style="margin-top:40px">ABOUT US · 教会について</p>
			<h2 class="h2" id="about-title">教会について<span class="en">About our parish</span></h2>
			<p class="body" style="margin-top:28px">習志野の地に集う、カトリックの共同体です。50周年の記念ミサを迎え、祈りと交わりを大切にしながら歩みを続けています。</p>
			<p class="sub">A Catholic community gathered in Narashino. We celebrated our 50th anniversary with a commemorative Mass and continue to walk together in prayer and fellowship.</p>
			<p class="sub">東京大司教区に属しています。 <span class="en">Part of the Archdiocese of Tokyo.</span></p>
			<a class="link" href="<?php echo esc_url( nc_url( 'anniversary' ) ); ?>">50周年記念ミサの案内 <span class="en">Anniversary Mass</span><?php echo nc_arrow(); ?></a>
		</div>
	</div>
</section>
