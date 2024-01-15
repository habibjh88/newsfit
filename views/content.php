<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */


$length         = 30;
$has_entry_meta = true;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'newsfit-post-card' ); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="post-img">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			<?php edit_post_link( 'Edit' ); ?>
		</div>
	<?php endif; ?>

	<div class="post-content">

		<?php
		if ( $has_entry_meta ) {
			echo newsfit_post_meta( true, [ 'tag', 'date', 'author' ] );
		}
		?>

		<?php if ( ! empty( get_the_title() ) ): ?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php endif; ?>

		<div class="post-excerprt-wrap">
			<?php echo wp_trim_words( get_the_excerpt(), $length ); ?>
		</div>
		<a href="<?php the_permalink(); ?>" class="item-btn">
			<?php esc_html_e( 'Read More', 'homlisti' ); ?>
		</a>
	</div>

</article>
