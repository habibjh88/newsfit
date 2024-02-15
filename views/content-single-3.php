<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

$meta_list = newsfit_option( 'rt_single_meta', '', true );
$meta      = newsfit_option( 'rt_blog_above_cat_visibility' );
$meta      = newsfit_option( 'rt_single_above_meta_style' );
if ( newsfit_option( 'rt_single_above_cat_visibility' ) ) {
	$category_index = array_search( 'category', $meta_list );
	unset( $meta_list[ $category_index ] );
}
?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( newsfit_post_class() ); ?>>
	<div class="article-inner-wrapper">

		<div class="entry-wrapper">
			<?php if ( newsfit_option( 'rt_blog_content_visibility' ) ) : ?>
				<div class="entry-content">
					<?php newsfit_entry_content() ?>
				</div>
			<?php endif; ?>

			<?php newsfit_entry_footer(); ?>
		</div>
	</div>
</article>
