<?php
/**
 * お知らせのカード（短冊形）。
 *
 * @package NarashinoCatholic
 *
 * @var array{notice: WP_Post} $args
 */

defined( 'ABSPATH' ) || exit;

$notice     = $args['notice'];
$post_id    = $notice->ID;
$tag        = nc_notice_meta( '_nc_tag', $post_id );
$warn       = '1' === nc_notice_meta( '_nc_warn', $post_id );
$title_en   = nc_notice_meta( '_nc_title_en', $post_id );
$desc_en    = nc_notice_meta( '_nc_desc_en', $post_id );
$link_url   = nc_notice_meta( '_nc_link_url', $post_id );
$link_label = nc_notice_meta( '_nc_link_label', $post_id );
$excerpt    = wp_strip_all_tags( get_the_excerpt( $notice ) );
?>
<article class="tz">
	<span class="hole" aria-hidden="true"></span>
	<?php if ( $tag ) : ?>
	<p class="tz-tag<?php echo $warn ? ' warn' : ''; ?>"><?php echo esc_html( $tag ); ?></p>
	<?php endif; ?>
	<h3 class="vt"><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h3>
	<?php if ( $title_en ) : ?>
	<p class="tz-en"><?php echo esc_html( $title_en ); ?></p>
	<?php endif; ?>
	<?php if ( $excerpt || $desc_en ) : ?>
	<p class="tz-desc">
		<?php echo esc_html( $excerpt ); ?>
		<?php if ( $excerpt && $desc_en ) : ?><br><?php endif; ?>
		<?php echo esc_html( $desc_en ); ?>
	</p>
	<?php endif; ?>
	<?php if ( $link_url ) : ?>
	<a class="link" href="<?php echo esc_url( $link_url ); ?>" rel="noopener noreferrer"><?php echo esc_html( $link_label ? $link_label : '詳しく見る' ); ?><?php echo nc_arrow(); ?></a>
	<?php endif; ?>
</article>
