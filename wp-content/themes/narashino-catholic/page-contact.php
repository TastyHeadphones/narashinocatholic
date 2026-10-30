<?php
/**
 * Template Name: お問い合わせ
 *
 * お問い合わせフォームを含む固定ページ。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	$has_body = '' !== trim( get_post_field( 'post_content', get_the_ID() ) );
	$result   = nc_contact_notice();
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
					<p class="flash<?php echo 'error' === $result[0] ? ' is-error' : ''; ?>" role="<?php echo 'error' === $result[0] ? 'alert' : 'status'; ?>"><?php echo esc_html( $result[1] ); ?></p>
				<?php endif; ?>

				<?php get_template_part( 'template-parts/contact-form' ); ?>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
