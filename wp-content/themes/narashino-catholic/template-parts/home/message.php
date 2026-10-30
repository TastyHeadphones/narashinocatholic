<?php
/**
 * トップページ：司祭からの言葉（写真は「司祭の紹介」ページのアイキャッチ画像）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

$priest_id   = nc_page_id( 'priest' );
$message_id  = nc_page_id( 'message' );
$photo       = $priest_id ? get_the_post_thumbnail( $priest_id, 'large', array( 'alt' => '主任司祭 浦野雄二師', 'loading' => 'lazy' ) ) : '';
$teaser      = $message_id ? get_the_excerpt( $message_id ) : '';
$pastor_name = nc_parish( 'pastor_name' );
?>
<section class="sec paper" id="message" aria-labelledby="message-title">
	<div class="wrap message-grid">
		<figure class="portrait<?php echo $photo ? '' : ' is-plain'; ?>">
			<?php if ( $photo ) : ?>
				<?php echo $photo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-generated, attributes escaped. ?>
			<?php else : ?>
				<svg class="frame-bg" viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
					<defs>
						<pattern id="diamond" width="44" height="44" patternUnits="userSpaceOnUse">
							<path d="M22 0L44 22L22 44L0 22Z" fill="none" stroke="#B8924A" stroke-opacity=".45" stroke-width="1.2"/>
						</pattern>
					</defs>
					<rect width="400" height="500" fill="url(#diamond)"/>
				</svg>
				<p class="plain-caption"><?php echo esc_html( $pastor_name ); ?></p>
			<?php endif; ?>
		</figure>
		<div>
			<p class="label">A WORD FROM OUR PRIEST · 司祭からの言葉</p>
			<h2 class="h2" id="message-title">司祭からの言葉<span class="en">A word from our priest</span></h2>
			<div class="body message-copy" style="margin-top:28px">
				<?php if ( $teaser ) : ?>
					<p><?php echo esc_html( wp_strip_all_tags( $teaser ) ); ?></p>
				<?php else : ?>
					<p>主任司祭の言葉を、こちらからお読みいただけます。</p>
				<?php endif; ?>
			</div>
			<p class="sign"><?php echo esc_html( $pastor_name ); ?><span class="en">Priest</span></p>
			<a class="link" href="<?php echo esc_url( nc_url( 'message' ) ); ?>" style="margin-top:24px">メッセージを読む <span class="en">Read the message</span><?php echo nc_arrow(); ?></a>
		</div>
	</div>
</section>
