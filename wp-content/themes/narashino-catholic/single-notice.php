<?php
/**
 * お知らせの詳細ページ。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$post_id   = get_the_ID();
	$tag       = nc_notice_meta( '_nc_tag' );
	$warn      = '1' === nc_notice_meta( '_nc_warn' );
	$en        = nc_notice_meta( '_nc_title_en' );
	$desc_en   = nc_notice_meta( '_nc_desc_en' );
	$link_url  = nc_notice_meta( '_nc_link_url' );
	$link_text = nc_notice_meta( '_nc_link_label' );
	$trail     = array(
		array( nc_url( 'notices' ), 'お知らせ一覧' ),
	);
	?>
	<main id="main">
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title' => get_the_title(),
				'en'    => $en,
				'trail' => $trail,
			)
		);
		?>

		<section class="page-body">
			<div class="wrap">
				<div class="notice-head">
					<div class="meta">
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?></time>
						<?php if ( $tag ) : ?>
							<span class="tz-tag<?php echo $warn ? ' warn' : ''; ?>"><?php echo esc_html( $tag ); ?></span>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( get_the_excerpt() ) : ?>
					<p class="notice-note"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
				<?php endif; ?>

				<div class="prose">
					<?php the_content(); ?>
					<?php if ( $desc_en ) : ?>
						<p class="en"><?php echo esc_html( $desc_en ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( $link_url ) : ?>
					<p><a class="link" href="<?php echo esc_url( $link_url ); ?>" rel="noopener noreferrer"><?php echo esc_html( $link_text ? $link_text : '詳しく見る' ); ?><?php echo nc_arrow(); ?></a></p>
				<?php endif; ?>

				<p><a class="link" href="<?php echo esc_url( nc_url( 'notices' ) ); ?>">お知らせ一覧に戻る <span class="en">Back to notices</span></a></p>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
