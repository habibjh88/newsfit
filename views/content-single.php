<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\NewsFit\Options\Opt;

$meta_key  = is_single() ? 'newsfit_single_meta' : 'newsfit_blog_meta';
$meta_list = newsfit_option( $meta_key, false, true );

$meta = newsfit_option( 'newsfit_blog_above_meta_visibility' );
$meta = newsfit_option( 'newsfit_single_above_meta_style' );
?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( newsfit_article_classes() ); ?>>
	<div class="article-inner-wrapper">

		<?php
		if ( ! in_array( Opt::$single_style, [ '2', '3', '4' ] ) ) {
			newsfit_post_thumbnail();
		}
		?>

		<div class="entry-wrapper">
			<header class="entry-header">
				<?php

				newsfit_above_title_meta();

				the_title( '<h1 class="entry-title default-max-width">', '</h1>' );

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
