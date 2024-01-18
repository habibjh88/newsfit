<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\NewsFit\Helpers\Fns;

$meta_key   = is_single() ? 'newsfit_single_meta' : 'newsfit_blog_meta';
$meta_list  = newsfit_option( $meta_key, false, true );
$meta_style = newsfit_option( 'newsfit_blog_meta_style' );

if ( is_single() ) {
	$post_classes = newsfit_classes( [ 'newsfit-post-card', $meta_style ] );
} else {
	$post_classes = newsfit_classes( [ 'newsfit-post-card', $meta_style, Fns::newsfit_blog_column() ] );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_classes ); ?>>
	<div class="article-inner-wrapper">
		<header class="entry-header">
			<?php newsfit_post_thumbnail(); ?>

			<?php if ( ! is_single() && newsfit_option( 'newsfit_meta_above_visibility' ) ) : ?>
				<div class="title-above-meta">
					<?php echo newsfit_post_meta( [
						'with_list' => false,
						'include'   => [ 'category' ],
					] ); ?>
				</div>
			<?php endif; ?>

			<?php
			if ( ! is_single() ) {
				the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
			} else {
				the_title( '<h2 class="entry-title default-max-width">', '</h2>' );
			}

			if ( ! empty( $meta_list ) && newsfit_option( 'newsfit_meta_visibility' ) ) {
				echo newsfit_post_meta( [
					'with_list'     => true,
					'include'       => $meta_list,
					'edit_link'     => true,
					'author_prefix' => newsfit_option( 'newsfit_author_prefix' ),
				] );
			}
			?>
		</header>

		<?php if ( newsfit_option( 'newsfit_blog_content_visibility' ) ) : ?>
			<div class="entry-content">
				<?php newsfit_entry_content() ?>
			</div>
		<?php endif; ?>


		<?php newsfit_entry_footer(); ?>
	</div>
</article>
