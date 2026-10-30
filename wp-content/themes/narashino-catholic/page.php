<?php
/**
 * 固定ページ（標準）：本文と、下層ページへのリンク。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$post_id  = get_the_ID();
	$has_body = '' !== trim( get_post_field( 'post_content', $post_id ) );
	$children = get_pages(
		array(
			'parent'      => $post_id,
			'sort_column' => 'menu_order,post_title',
		)
	);

	$trail = array();
	foreach ( array_reverse( get_post_ancestors( $post_id ) ) as $ancestor_id ) {
		$trail[] = array( get_permalink( $ancestor_id ), get_the_title( $ancestor_id ) );
	}
	?>
	<main id="main">
		<?php
		get_template_part(
			'template-parts/page-hero',
			null,
			array(
				'title' => get_the_title(),
				'en'    => nc_page_en( $post_id ),
				'trail' => $trail,
			)
		);
		?>

		<section class="page-body">
			<div class="wrap">
				<?php if ( $has_body ) : ?>
					<div class="prose">
						<?php nc_the_content(); ?>
					</div>
				<?php elseif ( ! $children ) : ?>
					<p class="empty">このページの内容は準備中です。ご不明な点は教会事務室（電話 <?php echo esc_html( nc_parish( 'phone' ) ); ?>）までお問い合わせください。</p>
				<?php endif; ?>

				<?php if ( $children ) : ?>
					<nav class="quick child-list" aria-label="関連ページ">
						<?php foreach ( $children as $index => $child ) : ?>
							<a href="<?php echo esc_url( get_permalink( $child->ID ) ); ?>">
								<span class="n"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
								<span>
									<b><?php echo esc_html( $child->post_title ); ?></b>
									<?php if ( nc_page_en( $child->ID ) ) : ?>
										<span class="en"><?php echo esc_html( nc_page_en( $child->ID ) ); ?></span>
									<?php endif; ?>
								</span>
								<?php echo nc_arrow(); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
