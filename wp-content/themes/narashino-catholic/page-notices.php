<?php
/**
 * Template Name: お知らせ一覧
 *
 * お知らせ（notice）の一覧ページ。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

$paged = isset( $_GET['paged'] ) ? max( 1, absint( wp_unslash( $_GET['paged'] ) ) ) : 1;
$query = new WP_Query(
	array(
		'post_type'      => 'notice',
		'post_status'    => 'publish',
		'posts_per_page' => 10,
		'paged'          => $paged,
	)
);

// 最後のページより先を指定されたら、一覧の先頭に戻す（何も表示されないページを作らない）。
if ( $paged > max( 1, (int) $query->max_num_pages ) ) {
	wp_safe_redirect( get_permalink( get_queried_object_id() ) );
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$has_body = '' !== trim( get_post_field( 'post_content', get_the_ID() ) );
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

				<?php if ( $query->have_posts() ) : ?>
					<ul class="nlist">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							$tag       = nc_notice_meta( '_nc_tag' );
							$en        = nc_notice_meta( '_nc_title_en' );
							$show_date = '1' === nc_notice_meta( '_nc_show_date' );
							?>
							<li>
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<span>
										<?php if ( $show_date || $tag ) : ?>
											<span class="meta">
												<?php if ( $show_date ) : ?>
													<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'Y年n月j日' ) ); ?></time>
												<?php endif; ?>
												<?php if ( $tag ) : ?>
													<span class="tz-tag<?php echo '1' === nc_notice_meta( '_nc_warn' ) ? ' warn' : ''; ?>"><?php echo esc_html( $tag ); ?></span>
												<?php endif; ?>
											</span>
										<?php endif; ?>
										<b><?php echo esc_html( get_the_title() ); ?></b>
										<?php if ( $en ) : ?>
											<span class="en"><?php echo esc_html( $en ); ?></span>
										<?php endif; ?>
									</span>
									<?php echo nc_arrow(); ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
					<?php wp_reset_postdata(); ?>
					<?php
					$pagination = paginate_links(
						array(
							'total'     => (int) $query->max_num_pages,
							'current'   => $paged,
							'format'    => '?paged=%#%',
							'prev_text' => '前へ',
							'next_text' => '次へ',
							'type'      => 'list',
						)
					);

					if ( $pagination ) {
						echo wp_kses_post( $pagination );
					}
					?>
				<?php else : ?>
					<p class="empty">現在、お知らせはありません。</p>
				<?php endif; ?>
			</div>
		</section>
	</main>
	<?php
endwhile;

wp_reset_postdata();
get_footer();
