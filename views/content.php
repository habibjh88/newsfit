<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */


$length       = 30;
$newsfit_meta = newsfit_option( 'newsfit_blog_meta', false, true );
$post_column  =
$post_classes = newsfit_classes( [
	'newsfit-post-card',
	newsfit_blog_column()
] );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="post-img">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		</div>
	<?php endif; ?>

	<div class="post-content">

		<div class="title-above-meta">
			<?php
			echo newsfit_post_meta( [
				'with_list' => false,
				'include'   => [ 'category' ],
			] );
			?>
		</div>

		<?php if ( ! empty( get_the_title() ) ): ?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php endif; ?>

		<?php
		if ( ! empty( $newsfit_meta ) ) {
			echo newsfit_post_meta( [
				'with_list' => true,
				'include'   => $newsfit_meta,
				'edit_link' => true,
				'class'     => 'style-line-before'
			] );
		}
		?>

		<div class="post-excerprt-wrap">
			<?php echo wp_trim_words( get_the_excerpt(), $length ); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="item-btn">
			<?php esc_html_e( 'Read More', 'homlisti' ); ?>
		</a>
	</div>

</article>
