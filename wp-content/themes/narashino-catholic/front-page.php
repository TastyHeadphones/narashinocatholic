<?php
/**
 * トップページ（固定ページ「ホーム」を静的なフロントページに設定した場合に使用）。
 *
 * @package NarashinoCatholic
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="main">
	<?php get_template_part( 'template-parts/home/hero' ); ?>
	<?php get_template_part( 'template-parts/home/verse' ); ?>
	<?php get_template_part( 'template-parts/home/mass' ); ?>
	<?php get_template_part( 'template-parts/home/about' ); ?>
	<?php get_template_part( 'template-parts/home/message' ); ?>
	<?php get_template_part( 'template-parts/home/community' ); ?>
	<?php get_template_part( 'template-parts/home/news' ); ?>
</main>
<?php
get_footer();
