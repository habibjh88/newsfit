<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\Newsfit\Options\Opt;
use RT\Newsfit\Modules\Thumbnail;

?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( newsfit_post_class() ); ?>>
	<div class="article-inner-wrapper">

		<?php if ( ! in_array( Opt::$single_style, [ '2', '3', '4' ] ) ) : ?>
			<?php Thumbnail::get_thumbnail( 'full', true ); ?>
		<?php endif; ?>

		<div class="entry-wrapper">
			<?php newsfit_single_entry_header(); ?>

			<?php if ( newsfit_option( 'rt_blog_content' ) ) : ?>
				<div class="entry-content">
					<?php newsfit_entry_content(); ?>
				</div>
			<?php endif; ?>


			<?php newsfit_entry_footer(); ?>
		</div>
	</div>
</article>
