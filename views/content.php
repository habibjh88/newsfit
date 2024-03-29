<?php
/**
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\Newsfit\Modules\Thumbnail;
use RT\Newsfit\Modules\PostMeta;

$meta_list = newsfit_option( 'rt_blog_meta', '', true );
if ( newsfit_option( 'rt_blog_above_ca_visibility' ) ) {
	$category_index = array_search( 'category', $meta_list );
	unset( $meta_list[ $category_index ] );
}
?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( newsfit_post_class() ); ?>>
	<div class="article-inner-wrapper">

		<?php Thumbnail::get_thumbnail( 'rt-square' ); ?>

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
					PostMeta::get_meta( [ 'include' => $meta_list ] );
				}
				?>
			</header>
			<?php if ( newsfit_option( 'rt_blog_content' ) ) : ?>
				<div class="entry-content">
					<?php newsfit_entry_content(); ?>
				</div>
			<?php endif; ?>

			<?php newsfit_entry_footer(); ?>
		</div>
	</div>
</article>
