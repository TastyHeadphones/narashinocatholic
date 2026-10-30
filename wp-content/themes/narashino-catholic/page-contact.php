<?php
/**
 * Template Name: お問い合わせ
 *
 * お問い合わせフォームを含む固定ページ。メールアドレスが未設定のときはフォームを出さず、電話を案内する。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$has_body = '' !== trim( get_post_field( 'post_content', get_the_ID() ) );
	$result   = nc_contact_notice();
	$phone    = nc_parish( 'phone' );
	?>
	<main id="main">
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title' => get_the_title(),
				'en'    => nc_page_en(),
				'trail' => array(),
			)
		);
		?>

		<section class="page-body">
			<div class="wrap">
				<?php if ( $has_body ) : ?>
					<div class="prose"><?php nc_the_content(); ?></div>
				<?php endif; ?>

				<?php if ( $result ) : ?>
					<p class="flash<?php echo 'ok' === $result[0] ? '' : ' is-error'; ?>" role="<?php echo 'ok' === $result[0] ? 'status' : 'alert'; ?>"><?php echo esc_html( $result[1] ); ?></p>
				<?php endif; ?>

				<?php if ( nc_parish( 'email' ) ) : ?>
					<?php get_template_part( 'template-parts/contact-form' ); ?>
				<?php else : ?>
					<p class="form-note">メールでのお問い合わせは準備中です。お問い合わせは、電話（<a href="<?php echo esc_attr( nc_tel_href( $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>）にてお願いします。</p>
				<?php endif; ?>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
