<?php
/**
 * A single notice.
 *
 * @package NarashinoCatholic
 */

get_header();

while ( have_posts() ) :
	the_post();
	$en_title = get_post_meta( get_the_ID(), 'nc_en_title', true );
	?>
	<article <?php post_class( 'sec' ); ?>>
		<div class="wrap narrow">
			<header class="page-head">
				<p class="label"><?php echo esc_html( get_the_date() ); ?> · お知らせ</p>
				<h1 class="h2">
					<?php the_title(); ?>
					<?php if ( $en_title ) : ?>
						<span class="en"><?php echo esc_html( $en_title ); ?></span>
					<?php endif; ?>
				</h1>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<p class="back">
				<a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>">お知らせ一覧へ <span class="en">All notices</span><?php echo nc_arrow(); ?></a>
			</p>
		</div>
	</article>
	<?php
endwhile;

get_footer();
