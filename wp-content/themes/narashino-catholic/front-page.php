<?php
/**
 * Homepage, following the design sections in order.
 *
 * @package NarashinoCatholic
 */

get_header();

$priest_photo = absint( nc_get( 'nc_priest_photo' ) );
$notices      = new WP_Query(
	[
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	]
);
?>

<div class="night">
  <section class="hero" id="top">
    <div class="wrap hero-grid">
      <div>
        <div class="eyebrow-row">
          <p class="eyebrow rise" style="--d:140ms">WELCOME · ようこそ</p>
          <div class="hanko stamp" style="--d:0ms" aria-hidden="true"><span>愛</span></div>
        </div>
        <h1><span class="h-line rise" style="--d:240ms">神を愛し、</span><span class="h-line rise" style="--d:320ms">隣人を愛する</span></h1>
        <p class="lede rise" style="--d:420ms">Love God. Love your neighbor.</p>
        <p class="copy rise" style="--d:500ms">祈りと交わりの場として、どなたもお気軽にお越しください。</p>
        <p class="copy-en rise" style="--d:560ms">A place of prayer and fellowship in Narashino, Chiba. Whether this is your first visit or you have been part of our community for years, you are welcome here.</p>
        <div class="cta rise" style="--d:640ms">
          <a class="btn fill-gold" href="#mass">ミサの時間を見る <span class="en">Mass times</span><?php echo nc_arrow(); ?></a>
          <a class="btn line-light" href="#contact">アクセス <span class="en">Visit us</span></a>
        </div>
      </div>
      <nav class="quick" aria-label="主要なページ">
        <a class="rise" style="--d:720ms" href="#mass"><span class="n">01</span><span><b>ミサ</b><span class="en">Mass times</span></span><?php echo nc_arrow(); ?></a>
        <a class="rise" style="--d:790ms" href="#contact"><span class="n">02</span><span><b>アクセス</b><span class="en">Visit us</span></span><?php echo nc_arrow(); ?></a>
        <a class="rise" style="--d:860ms" href="#community"><span class="n">03</span><span><b>活動</b><span class="en">Get involved</span></span><?php echo nc_arrow(); ?></a>
      </nav>
    </div>
    <p class="vertical fade-in" style="--d:900ms" aria-hidden="true">カトリック習志野教会</p>
  </section>

  <svg class="panorama rise-lg" style="--d:520ms" viewBox="0 0 1280 440" preserveAspectRatio="xMidYMax slice" role="img" aria-label="Illustration of the church at dusk: a steep gable roof with a gold cross on its spire, lit tall windows, a lattice window, an arched entrance, and a wing with dormers and a balcony">
    <defs>
      <linearGradient id="sky" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0" stop-color="#DFE4EE"/>
        <stop offset=".72" stop-color="#F3E8CF"/>
        <stop offset="1" stop-color="#F4EFE4"/>
      </linearGradient>
      <pattern id="grille" width="16" height="16" patternUnits="userSpaceOnUse">
        <path d="M0 0H16M0 0V16" fill="none" stroke="#1B2750" stroke-width="2"/>
      </pattern>
      <pattern id="brick" width="28" height="14" patternUnits="userSpaceOnUse">
        <path d="M0 13.5H28M14 0V13.5" fill="none" stroke="#7D7764" stroke-width="1"/>
      </pattern>
    </defs>
    <rect width="1280" height="440" fill="url(#sky)"/>
    <circle cx="1040" cy="92" r="86" fill="#E0BF78" fill-opacity=".25"/>
    <circle cx="1040" cy="92" r="52" fill="#E0BF78"/>
    <g fill="#FBF8F1" fill-opacity=".85">
      <circle cx="200" cy="98" r="22"/><circle cx="234" cy="84" r="30"/><circle cx="270" cy="100" r="22"/><rect x="180" y="98" width="112" height="22" rx="11"/>
      <circle cx="640" cy="62" r="20"/><circle cx="670" cy="50" r="28"/><circle cx="704" cy="64" r="20"/><rect x="620" y="62" width="104" height="20" rx="10"/>
      <circle cx="884" cy="150" r="16"/><circle cx="906" cy="142" r="22"/><circle cx="934" cy="152" r="16"/><rect x="870" y="150" width="82" height="16" rx="8"/>
    </g>
    <g fill="none" stroke="#2E2A26" stroke-width="5" stroke-linecap="round">
      <path d="M48 402C50 330 40 262 58 176" stroke-width="10"/>
      <path d="M52 296L14 236M54 250L104 196M58 206L34 132M58 182L100 128"/>
    </g>
    <g fill="#34432C">
      <circle cx="1150" cy="196" r="72"/><circle cx="1212" cy="236" r="60"/><circle cx="1110" cy="262" r="50"/><circle cx="1222" cy="306" r="52"/>
      <rect x="1160" y="296" width="14" height="110" fill="#2E2A26"/>
    </g>
    <path d="M126 200L380 116L718 222L718 246L380 136L142 214Z" fill="#3A4458"/>
    <path d="M126 200L380 116L718 222" fill="none" stroke="#5B6781" stroke-width="2"/>
    <path d="M142 214L380 136L718 246V400H142Z" fill="#BDB59E"/>
    <path d="M142 214L380 136L718 246V400H142Z" fill="url(#brick)" opacity=".55"/>
    <circle cx="380" cy="66" r="30" fill="#E0BF78" fill-opacity=".14"/>
    <path d="M352 124L380 84L408 124Z" fill="#3A4458"/>
    <rect x="378" y="50" width="4" height="40" fill="#E0BF78"/>
    <rect x="369" y="62" width="22" height="4" fill="#E0BF78"/>
    <path d="M330 180L366 150V180Z" fill="#1B2750"/>
    <path d="M430 180L394 150V180Z" fill="#1B2750"/>
    <g fill="#E0BF78" stroke="#1B2750" stroke-width="3">
      <rect class="lamp" style="--d:760ms" x="165" y="244" width="30" height="58"/>
      <rect class="lamp" style="--d:805ms" x="232" y="244" width="30" height="58"/>
      <rect class="lamp" style="--d:850ms" x="318" y="244" width="30" height="58"/>
      <rect class="lamp" style="--d:895ms" x="378" y="244" width="30" height="58"/>
      <rect class="lamp" style="--d:940ms" x="448" y="244" width="30" height="58"/>
      <rect class="lamp" style="--d:985ms" x="531" y="244" width="30" height="58"/>
      <rect class="lamp" style="--d:1030ms" x="580" y="250" width="95" height="62"/>
    </g>
    <path d="M580 281H675M627.5 250V312" stroke="#1B2750" stroke-width="3"/>
    <rect class="lamp" style="--d:1075ms" x="580" y="330" width="100" height="70" fill="#E0BF78"/>
    <rect x="580" y="330" width="100" height="70" fill="url(#grille)"/>
    <path d="M352 400V356A28 28 0 0 1 408 356V400Z" fill="#0E1733"/>
    <path class="lamp" style="--d:1120ms" d="M368 400V364A12 12 0 0 1 392 364V400Z" fill="#E0BF78" fill-opacity=".85"/>
    <path d="M716 256L1110 206V400H716Z" fill="#A59F89"/>
    <path d="M716 256L1110 206V400H716Z" fill="url(#brick)" opacity=".5"/>
    <path d="M716 236L1110 184L1110 206L716 256Z" fill="#3A4458"/>
    <path d="M778 228V214L790 202L802 214V228Z" fill="#3A4458"/>
    <rect class="lamp" style="--d:1480ms" x="784" y="214" width="12" height="11" fill="#E0BF78"/>
    <path d="M888 212V198L900 186L912 198V212Z" fill="#3A4458"/>
    <rect class="lamp" style="--d:1525ms" x="894" y="198" width="12" height="11" fill="#E0BF78"/>
    <g fill="#E0BF78" stroke="#1B2750" stroke-width="2.5">
      <rect class="lamp" style="--d:1165ms" x="728" y="278" width="22" height="38"/>
      <rect class="lamp" style="--d:1210ms" x="858" y="262" width="24" height="36"/>
      <rect class="lamp" style="--d:1255ms" x="944" y="248" width="24" height="34"/>
      <rect class="lamp" style="--d:1300ms" x="1024" y="238" width="24" height="34"/>
    </g>
    <rect x="772" y="296" width="212" height="5" fill="#0E1733"/>
    <path d="M780 301V318M808 301V318M836 301V318M864 301V318M892 301V318M920 301V318M948 301V318M976 301V318" stroke="#0E1733" stroke-width="3"/>
    <path d="M730 400V362A30 30 0 0 1 790 362V400Z" fill="#0E1733"/>
    <path d="M820 400V362A30 30 0 0 1 880 362V400Z" fill="#0E1733"/>
    <path d="M910 400V362A30 30 0 0 1 970 362V400Z" fill="#0E1733"/>
    <path class="lamp" style="--d:1345ms" d="M742 400V372A18 18 0 0 1 778 372V400Z" fill="#E0BF78" fill-opacity=".7"/>
    <path class="lamp" style="--d:1390ms" d="M832 400V372A18 18 0 0 1 868 372V400Z" fill="#E0BF78" fill-opacity=".7"/>
    <path class="lamp" style="--d:1435ms" d="M922 400V372A18 18 0 0 1 958 372V400Z" fill="#E0BF78" fill-opacity=".7"/>
    <rect x="0" y="400" width="1280" height="40" fill="#D9CFBC"/>
    <g fill="#34432C">
      <circle cx="110" cy="392" r="30"/><circle cx="160" cy="382" r="34"/><circle cx="214" cy="392" r="28"/><circle cx="266" cy="382" r="34"/><circle cx="318" cy="392" r="28"/>
      <circle cx="470" cy="392" r="28"/><circle cx="522" cy="382" r="34"/><circle cx="576" cy="392" r="28"/><circle cx="630" cy="384" r="32"/><circle cx="684" cy="392" r="28"/><circle cx="736" cy="390" r="26"/>
    </g>
  </svg>
</div>

<svg class="noren" viewBox="0 0 1280 160" aria-hidden="true">
  <rect width="1280" height="12" fill="#2E2A26"/>
  <g style="fill: var(--ai-tint)">
    <path d="M16 12H162V150L89 136L16 150Z"/>
    <path d="M174 12H320V150L247 136L174 150Z"/>
    <path d="M332 12H478V150L405 136L332 150Z"/>
    <path d="M490 12H636V150L563 136L490 150Z"/>
    <path d="M648 12H794V150L721 136L648 150Z"/>
    <path d="M806 12H952V150L879 136L806 150Z"/>
    <path d="M964 12H1110V150L1037 136L964 150Z"/>
    <path d="M1122 12H1268V150L1195 136L1122 150Z"/>
  </g>
  <path d="M16 26H162M174 26H320M332 26H478M490 26H636M648 26H794M806 26H952M964 26H1110M1122 26H1268" stroke="#E0BF78" stroke-width="1.5" fill="none"/>
</svg>

<section class="verse" id="word">
  <div class="wrap verse-grid">
    <div>
      <p class="label">THE WORD · 聖書の言葉</p>
      <p class="verse-en">On these two commandments depend all the Law and the Prophets.</p>
      <p class="ref">マタイによる福音書 22:40 · Matthew 22:40</p>
      <p class="gloss">神を愛すること。<br>隣人を自分のように愛すること。</p>
      <p class="gloss-en">To love God, and to love your neighbor as yourself.</p>
    </div>
    <div class="kake">
      <div class="rod"></div>
      <div class="mount">
        <div class="panel">
          <p class="tate">律法全体と預言者は、<br>この二つの掟に基づいている。</p>
          <span class="kseal" aria-hidden="true">言</span>
        </div>
      </div>
      <div class="rod"></div>
    </div>
  </div>
</section>

<section class="sec mass" id="mass">
  <svg class="kikko" aria-hidden="true">
    <defs>
      <pattern id="kikko" width="52" height="90" patternUnits="userSpaceOnUse">
        <g fill="none" stroke="#B8924A" stroke-width="1.2">
          <path d="M0 -30L26 -15L26 15L0 30L-26 15L-26 -15Z"/>
          <path d="M52 -30L78 -15L78 15L52 30L26 15L26 -15Z"/>
          <path d="M0 60L26 75L26 105L0 120L-26 105L-26 75Z"/>
          <path d="M52 60L78 75L78 105L52 120L26 105L26 75Z"/>
          <path d="M26 15L52 30L52 60L26 75L0 60L0 30Z"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#kikko)"/>
  </svg>
  <div class="wrap">
    <div class="mass-head">
      <div>
        <p class="label">MASS &amp; VISIT · ミサと訪問</p>
        <h2 class="h2">ミサに参加する<span class="en">Join us for Mass</span></h2>
      </div>
      <p class="mass-note">日曜日と平日のミサの時間・場所を、ご来訪前にご確認ください。<span class="en">Please check the Mass times and location before your visit.</span></p>
    </div>
    <div class="mass-grid">
      <article class="mc main">
        <span class="kanji" aria-hidden="true">日</span>
        <p class="label">SUNDAY</p>
        <h3>主日のミサ</h3>
        <p class="en">Sunday Mass</p>
        <p class="time"><?php echo nc_field( 'nc_sunday_mass' ); ?></p>
      </article>
      <article class="mc">
        <span class="kanji" aria-hidden="true">平</span>
        <p class="label">WEEKDAY</p>
        <h3>平日のミサ</h3>
        <p class="en">Weekday Mass</p>
        <p class="time"><?php echo nc_field( 'nc_weekday_mass' ); ?></p>
      </article>
      <article class="mc sakura">
        <span class="kanji" aria-hidden="true">地</span>
        <p class="label">LOCATION</p>
        <h3>所在地</h3>
        <p class="en">Address</p>
        <p class="time"><?php echo nc_field( 'nc_address' ); ?></p>
        <a class="link" href="#contact">アクセス <span class="en">Directions</span><?php echo nc_arrow(); ?></a>
      </article>
    </div>
  </div>
</section>

<section class="sec" id="about">
  <div class="wrap about-grid">
    <div class="rose-wrap">
      <svg class="rose-svg" viewBox="0 0 600 600" role="img" aria-label="A rose window in a shippo pattern with a cross at its center">
        <defs>
          <pattern id="shippo" width="112" height="112" patternUnits="userSpaceOnUse">
            <rect width="112" height="112" fill="#F4EFE4"/>
            <path d="M28 19.3A34 34 0 0 0 36.7 28A34 34 0 0 0 28 36.7A34 34 0 0 0 19.3 28A34 34 0 0 0 28 19.3Z" fill="#1B2750"/>
            <path d="M84 19.3A34 34 0 0 0 92.7 28A34 34 0 0 0 84 36.7A34 34 0 0 0 75.3 28A34 34 0 0 0 84 19.3Z" fill="#B0402A"/>
            <path d="M28 75.3A34 34 0 0 0 36.7 84A34 34 0 0 0 28 92.7A34 34 0 0 0 19.3 84A34 34 0 0 0 28 75.3Z" fill="#B8924A"/>
            <path d="M84 75.3A34 34 0 0 0 92.7 84A34 34 0 0 0 84 92.7A34 34 0 0 0 75.3 84A34 34 0 0 0 84 75.3Z" fill="#5F6F4C"/>
            <g fill="none" stroke="#22211E" stroke-width="2.2">
              <circle cx="0" cy="0" r="34"/><circle cx="56" cy="0" r="34"/><circle cx="112" cy="0" r="34"/>
              <circle cx="0" cy="56" r="34"/><circle cx="56" cy="56" r="34"/><circle cx="112" cy="56" r="34"/>
              <circle cx="0" cy="112" r="34"/><circle cx="56" cy="112" r="34"/><circle cx="112" cy="112" r="34"/>
            </g>
          </pattern>
        </defs>
        <g class="rose">
          <circle cx="300" cy="300" r="292" fill="#E0BF78" fill-opacity=".12"/>
          <circle cx="300" cy="300" r="272" fill="none" stroke="#E0BF78" stroke-opacity=".45" stroke-width="1.5"/>
          <circle class="rose-pattern" cx="300" cy="300" r="250" fill="url(#shippo)"/>
          <circle cx="300" cy="300" r="250" fill="none" stroke="#B8924A" stroke-width="9"/>
          <circle cx="300" cy="300" r="236" fill="none" stroke="#22211E" stroke-width="3"/>
          <circle cx="300" cy="300" r="66" fill="#F4EFE4" stroke="#B8924A" stroke-width="4"/>
          <rect x="294" y="256" width="12" height="88" style="fill: var(--ai)"/>
          <rect x="274" y="280" width="52" height="12" style="fill: var(--ai)"/>
        </g>
      </svg>
      <svg class="seal" viewBox="0 0 160 160" aria-hidden="true">
        <rect width="160" height="160" fill="#B0402A"/>
        <rect x="9" y="9" width="142" height="142" fill="none" stroke="#F4EFE4" stroke-width="1.5" stroke-opacity=".8"/>
        <g font-family="Shippori Mincho, serif" font-size="28" font-weight="700" fill="#F4EFE4" text-anchor="middle">
          <text x="80" y="47">五</text>
          <text x="80" y="79">十</text>
          <text x="80" y="111">周</text>
          <text x="80" y="143">年</text>
        </g>
      </svg>
    </div>
    <div>
      <p class="fifty">50</p>
      <p class="fifty-cap">年の歩み <span class="en">Fifty years</span></p>
      <p class="label" style="margin-top:40px">ABOUT US · 教会について</p>
      <h2 class="h2">教会について<span class="en">About our parish</span></h2>
      <p class="body" style="margin-top:28px">習志野の地に集う、カトリックの共同体です。50周年の記念ミサを迎え、祈りと交わりを大切にしながら歩みを続けています。</p>
      <p class="sub">A Catholic community gathered in Narashino. We celebrated our 50th anniversary with a commemorative Mass and continue to walk together in prayer and fellowship.</p>
      <p class="sub">東京大司教区に属しています。 <span class="en">Part of the Archdiocese of Tokyo.</span></p>
      <a class="link" href="<?php echo esc_url( nc_get( 'nc_anniversary_url' ) ); ?>">50周年記念ミサの案内 <span class="en">Anniversary Mass</span><?php echo nc_arrow(); ?></a>
    </div>
  </div>
</section>

<section class="sec paper" id="message">
  <div class="wrap message-grid">
    <figure class="portrait">
      <?php if ( $priest_photo ) : ?>
        <?php echo wp_get_attachment_image( $priest_photo, 'large', false, [ 'class' => 'portrait-photo' ] ); ?>
      <?php else : ?>
        <svg class="frame-bg" viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
          <defs>
            <pattern id="diamond" width="44" height="44" patternUnits="userSpaceOnUse">
              <path d="M22 0L44 22L22 44L0 22Z" fill="none" stroke="#B8924A" stroke-opacity=".45" stroke-width="1.2"/>
            </pattern>
          </defs>
          <rect width="400" height="500" fill="url(#diamond)"/>
        </svg>
        <div class="ph-box">[司祭の写真 · PHOTO OF THE PRIEST]</div>
      <?php endif; ?>
    </figure>
    <div>
      <p class="label">A WORD FROM OUR PRIEST · 司祭からの言葉</p>
      <h2 class="h2">司祭からの言葉<span class="en">A word from our priest</span></h2>
      <p class="body" style="margin-top:28px"><?php echo nc_field( 'nc_priest_message' ); ?></p>
      <p class="sign"><?php echo nc_field( 'nc_priest_name' ); ?><span class="en">Priest</span></p>
      <a class="link" href="<?php echo esc_url( nc_get( 'nc_priest_url' ) ); ?>" style="margin-top:24px">メッセージを読む <span class="en">Read the message</span><?php echo nc_arrow(); ?></a>
    </div>
  </div>
</section>

<section class="sec" id="community">
  <div class="wrap">
    <div class="split-head">
      <div>
        <p class="label">GET INVOLVED · 活動</p>
        <h2 class="h2">活動に参加する<span class="en">Ways to serve and belong</span></h2>
      </div>
      <p class="lead">教会は、多くの方々の奉仕と支えによって歩んでいます。</p>
    </div>
    <div class="act-grid">
      <a class="act" href="#community">
        <span class="hanko-s">清</span>
        <h3>土曜日の教会清掃</h3>
        <p class="en">Saturday church cleaning</p>
        <p class="when">毎週土曜日 10:30〜11:00<span class="en">Every Saturday, 10:30–11:00</span></p>
        <p class="desc">ボランティアを募集しています。<br>Volunteers are needed.</p>
      </a>
      <a class="act" href="#community">
        <span class="hanko-s ind">学</span>
        <h3>聖書講座</h3>
        <p class="en">Bible study courses</p>
        <p class="desc">聖書を学ぶ講座をご案内しています。<br>Courses for learning Scripture. See the course guide.</p>
      </a>
      <a class="act" href="#community">
        <span class="hanko-s gold">支</span>
        <h3>運営のサポーター</h3>
        <p class="en">Volunteers &amp; supporters</p>
        <p class="desc">教会運営へのご協力を募集しています。<br>Help us keep our parish running.</p>
      </a>
    </div>
  </div>
</section>

<section class="sec paper" id="news">
  <div class="wrap">
    <div class="split-head">
      <div>
        <p class="label">NEWS · お知らせ</p>
        <h2 class="h2">お知らせ<span class="en">Notices</span></h2>
      </div>
      <a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>">すべてのお知らせ <span class="en">All notices</span><?php echo nc_arrow(); ?></a>
    </div>
    <?php if ( $notices->have_posts() ) : ?>
      <div class="tz-grid">
        <?php
        while ( $notices->have_posts() ) :
			$notices->the_post();

			$categories = array_values(
				array_filter(
					get_the_category(),
					static function ( $category ) {
						return 'uncategorized' !== $category->slug;
					}
				)
			);
			$is_caution = $categories && 'caution' === $categories[0]->slug;
			$en_title   = get_post_meta( get_the_ID(), 'nc_en_title', true );
			$en_excerpt = get_post_meta( get_the_ID(), 'nc_en_excerpt', true );
			?>
			<article class="tz">
				<span class="hole" aria-hidden="true"></span>
				<p class="tz-tag<?php echo $is_caution ? ' warn' : ''; ?>"><?php echo esc_html( $categories ? $categories[0]->name : get_the_date( 'm.d（D）' ) ); ?></p>
				<h3 class="vt"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php if ( $en_title ) : ?>
					<p class="tz-en"><?php echo esc_html( $en_title ); ?></p>
				<?php endif; ?>
				<p class="tz-desc"><?php echo esc_html( get_the_excerpt() ); ?><?php if ( $en_excerpt ) : ?><br><?php echo esc_html( $en_excerpt ); ?><?php endif; ?></p>
			</article>
		<?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <p class="sub">まだお知らせはありません。<span class="en">No notices yet.</span></p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
