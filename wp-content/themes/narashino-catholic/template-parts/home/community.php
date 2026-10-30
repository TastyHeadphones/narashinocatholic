<?php
/**
 * トップページ：活動（清掃、聖書講座、ご協力者の募集）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="sec" id="community" aria-labelledby="community-title">
	<div class="wrap">
		<div class="split-head">
			<div>
				<p class="label">GET INVOLVED · 活動</p>
				<h2 class="h2" id="community-title">活動に参加する<span class="en">Ways to serve and belong</span></h2>
			</div>
			<p class="lead">教会は、多くの方々の奉仕と支え<span class="nowrap">によって</span>歩んでいます。</p>
		</div>
		<div class="act-grid">
			<a class="act" href="<?php echo esc_url( nc_url( 'cleaning' ) ); ?>">
				<span class="hanko-s" aria-hidden="true">清</span>
				<h3>土曜日の教会清掃</h3>
				<p class="en">Saturday church cleaning</p>
				<p class="when"><?php echo esc_html( nc_parish( 'cleaning' ) ); ?><?php if ( nc_parish( 'cleaning_en' ) ) : ?><span class="en"><?php echo esc_html( nc_parish( 'cleaning_en' ) ); ?></span><?php endif; ?></p>
				<p class="desc">ボランティアを募集しています。<br>Volunteers are needed.</p>
			</a>
			<a class="act" href="<?php echo esc_url( nc_url( 'bible' ) ); ?>">
				<span class="hanko-s ind" aria-hidden="true">学</span>
				<h3>聖書講座</h3>
				<p class="en">Bible study courses</p>
				<p class="desc">聖書を学ぶ講座をご案内しています。<br>Courses for learning Scripture. See the course guide.</p>
			</a>
			<a class="act" href="<?php echo esc_url( nc_url( 'cleaning' ) ); ?>">
				<span class="hanko-s gold" aria-hidden="true">支</span>
				<h3>ご協力者の募集</h3>
				<p class="en">Volunteers &amp; supporters</p>
				<p class="desc">運営委員会からの、ご奉仕者・ご協力者募集のご案内をご覧いただけます。<br>See the committee's call for volunteers and supporters.</p>
			</a>
		</div>
	</div>
</section>
