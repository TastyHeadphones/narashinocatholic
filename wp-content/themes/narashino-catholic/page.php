<?php
/**
 * A standard page.
 *
 * @package NarashinoCatholic
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'sec' ); ?>>
		<div class="wrap narrow">
			<header class="page-head">
				<h1 class="h2"><?php the_title(); ?></h1>
			</header>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
