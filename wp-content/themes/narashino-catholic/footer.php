<?php
/**
 * フッター：お問い合わせ、所在地、リンク。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?>
	<footer class="foot" id="contact">
		<div class="wrap">
			<div class="foot-top">
				<div>
					<p class="label">CONTACT · お問い合わせ</p>
					<h2 class="h2">お問い合わせ<span class="en">Contact &amp; access</span></h2>
				</div>
				<a class="btn fill-gold" href="<?php echo esc_url( nc_url( 'contact' ) ); ?>">お問い合わせ <span class="en">Contact</span></a>
			</div>
			<div class="foot-grid">
				<div>
					<p class="fl"><?php echo esc_html( nc_parish( 'name_ja' ) ); ?><span class="en"><?php echo esc_html( nc_parish( 'name_en' ) ); ?></span></p>
					<p class="ph-line"><span class="k">住所 · Address</span><?php echo esc_html( nc_parish( 'postal_address' ) ); ?></p>
					<p class="ph-line"><span class="k">電話 · Phone</span><a href="<?php echo esc_attr( nc_tel_href( nc_parish( 'phone' ) ) ); ?>"><?php echo esc_html( nc_parish( 'phone' ) ); ?></a><?php if ( nc_parish( 'fax' ) ) : ?> ／ FAX <?php echo esc_html( nc_parish( 'fax' ) ); ?><?php endif; ?></p>
					<?php if ( nc_parish( 'email' ) ) : ?>
					<p class="ph-line"><span class="k">メール · Email</span><a href="<?php echo esc_attr( 'mailto:' . nc_parish( 'email' ) ); ?>"><?php echo esc_html( nc_parish( 'email' ) ); ?></a></p>
					<?php endif; ?>
					<?php if ( nc_parish( 'office_closed' ) ) : ?>
					<p class="ph-line"><span class="k">事務室 · Office</span><?php echo esc_html( nc_parish( 'office_closed' ) ); ?></p>
					<?php endif; ?>
				</div>
				<div>
					<p class="ph-line"><span class="k">アクセス · Directions</span><?php echo esc_html( nc_parish( 'directions' ) ); ?></p>
				</div>
				<div>
					<?php nc_footer_nav(); ?>
				</div>
			</div>
			<div class="fine">
				<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( nc_parish( 'name_ja' ) ); ?> · <?php echo esc_html( nc_parish( 'name_en' ) ); ?></span>
				<a href="#top">ページの上へ · Back to top</a>
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
