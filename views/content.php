<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */


$meta_list = newsfit_option( 'rt_blog_meta', '', true );
if ( newsfit_option( 'rt_blog_above_cat_visibility' ) ) {
	$category_index = array_search( 'category', $meta_list );
	unset( $meta_list[ $category_index ] );
}
?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( newsfit_post_class() ); ?>>
	<div class="article-inner-wrapper">

		<?php newsfit_post_thumbnail(); ?>

		<div class="entry-wrapper">
			<header class="entry-header">

				<?php
				newsfit_separate_meta( 'title-above-meta' );

				if ( ! is_single() ) {
					the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="entry-title default-max-width">', '</h2>' );
				}

				if ( ! empty( $meta_list ) && newsfit_option( 'rt_meta_visibility' ) ) {
					echo newsfit_post_meta( [
						'with_list'     => true,
						'include'       => $meta_list,
						'author_prefix' => newsfit_option( 'rt_author_prefix' ),
					] );
				}
				?>
			</header>
			<?php if ( newsfit_option( 'rt_blog_content_visibility' ) ) : ?>
				<div class="entry-content">
					<?php newsfit_entry_content() ?>
				</div>
			<?php endif; ?>

			<?php newsfit_entry_footer(); ?>
		</div>
	</div>
</article>
