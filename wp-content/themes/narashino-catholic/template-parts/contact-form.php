<?php
/**
 * お問い合わせフォーム（送信先はメール。内容はデータベースに保存しない）。
 *
 * 送信に失敗した場合の入力内容は、ブラウザのセッション内だけで復元する（assets/js/contact.js）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;
?>
<form id="nc-contact-form" class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="nc_contact">
	<?php wp_nonce_field( 'nc_contact', 'nc_contact_nonce' ); ?>

	<div class="hp" aria-hidden="true">
		<label for="nc-website">Website</label>
		<input type="text" id="nc-website" name="website" tabindex="-1" autocomplete="off">
	</div>

	<div class="form-grid">
		<div class="field">
			<label for="nc-name">お名前<span class="req">必須</span></label>
			<input type="text" id="nc-name" name="name" required maxlength="100" autocomplete="name">
		</div>
		<div class="field">
			<label for="nc-church">所属教会<span class="hint">（任意）</span></label>
			<input type="text" id="nc-church" name="church" maxlength="100" autocomplete="organization">
		</div>
	</div>

	<div class="field">
		<label for="nc-email">メールアドレス<span class="req">必須</span></label>
		<input type="email" id="nc-email" name="email" required maxlength="254" autocomplete="email">
	</div>

	<div class="field">
		<label for="nc-message">メッセージ<span class="req">必須</span></label>
		<textarea id="nc-message" name="message" rows="8" required maxlength="4000"></textarea>
	</div>

	<div class="form-actions">
		<button class="btn fill-gold" type="submit">送信する <span class="en">Send</span></button>
		<p class="form-note">緊急のご連絡、神父様へのご連絡は、電話（<a href="<?php echo esc_attr( nc_tel_href( nc_parish( 'phone' ) ) ); ?>"><?php echo esc_html( nc_parish( 'phone' ) ); ?></a>）にてお願いします。</p>
	</div>
</form>
