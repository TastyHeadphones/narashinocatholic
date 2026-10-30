<?php
/**
 * トップページ：ミサの時間と所在地（教会情報の設定から表示）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="sec mass" id="mass" aria-labelledby="mass-title">
	<?php nc_svg( 'kikko' ); ?>
	<div class="wrap">
		<div class="mass-head">
			<div>
				<p class="label">MASS &amp; VISIT · ミサと訪問</p>
				<h2 class="h2" id="mass-title">ミサに参加する<span class="en">Join us for Mass</span></h2>
			</div>
			<p class="mass-note">日曜日と平日のミサの時間・場所を、ご来訪前にご確認ください。<span class="en">Please check the Mass times and location before your visit.</span></p>
		</div>
		<div class="mass-grid">
			<article class="mc main">
				<span class="kanji" aria-hidden="true">日</span>
				<p class="label">SUNDAY</p>
				<h3>主日のミサ</h3>
				<p class="en">Sunday Mass</p>
				<p class="time">
					<?php echo esc_html( nc_parish( 'sunday_mass' ) ); ?>
					<?php if ( nc_parish( 'sunday_mass_note' ) ) : ?>
					<span class="sub"><?php echo esc_html( nc_parish( 'sunday_mass_note' ) ); ?></span>
					<?php endif; ?>
				</p>
			</article>
			<article class="mc">
				<span class="kanji" aria-hidden="true">平</span>
				<p class="label">WEEKDAY</p>
				<h3>平日のミサ</h3>
				<p class="en">Weekday Mass</p>
				<p class="time"><?php echo esc_html( trim( nc_parish( 'weekday_mass_label' ) . ' ' . nc_parish( 'weekday_mass' ) ) ); ?></p>
			</article>
			<article class="mc sakura">
				<span class="kanji" aria-hidden="true">地</span>
				<p class="label">LOCATION</p>
				<h3>所在地</h3>
				<p class="en">Address</p>
				<p class="time"><?php echo esc_html( nc_parish( 'postal_address' ) ); ?></p>
				<a class="link" href="<?php echo esc_url( nc_url( 'access' ) ); ?>">アクセス <span class="en">Directions</span><?php echo nc_arrow(); ?></a>
			</article>
		</div>
	</div>
</section>
