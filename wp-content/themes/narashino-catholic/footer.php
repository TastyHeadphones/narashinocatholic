<?php
/**
 * Site footer with contact details and links.
 *
 * @package NarashinoCatholic
 */

$privacy_url = get_privacy_policy_url();
$contact_url = nc_get( 'nc_contact_url' ) ?: '#contact';
?>
</main>

<footer class="foot" id="contact">
  <div class="wrap">
    <div class="foot-top">
      <div>
        <p class="label">CONTACT · お問い合わせ</p>
        <h2 class="h2">お問い合わせ<span class="en">Contact &amp; access</span></h2>
      </div>
      <a class="btn fill-gold" href="<?php echo esc_url( $contact_url ); ?>">お問い合わせフォーム <span class="en">Contact form</span></a>
    </div>
    <div class="foot-grid">
      <div>
        <p class="fl">カトリック習志野教会<span class="en">Catholic Narashino Church</span></p>
        <p class="ph-line"><span class="k">住所 · Address</span><?php echo nc_field( 'nc_address' ); ?></p>
        <p class="ph-line"><span class="k">電話 · Phone</span><?php echo nc_field( 'nc_phone' ); ?></p>
        <p class="ph-line"><span class="k">メール · Email</span><?php echo nc_field( 'nc_email' ); ?></p>
      </div>
      <div>
        <p class="ph-line"><span class="k">アクセス · Directions</span><?php echo nc_field( 'nc_directions' ); ?></p>
      </div>
      <div>
        <ul class="flinks">
          <?php if ( $privacy_url ) : ?>
            <li><a href="<?php echo esc_url( $privacy_url ); ?>">プライバシーポリシー <span class="en">Privacy policy</span></a></li>
          <?php endif; ?>
          <li><a href="<?php echo esc_url( home_url( '/wp-sitemap.xml' ) ); ?>">サイトマップ <span class="en">Sitemap</span></a></li>
          <li>東京大司教区 <span class="en">Archdiocese of Tokyo</span></li>
        </ul>
      </div>
    </div>
    <div class="fine">
      <span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> カトリック習志野教会 · Catholic Narashino Church</span>
      <a href="#">ページの上へ · Back to top</a>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
