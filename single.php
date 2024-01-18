<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package newsfit
 */

use RT\NewsFit\Helpers\Fns;

get_header();
$content_columns = Fns::content_columns();
?>

	<div class="container">

		<div class="row">

			<div class="<?php echo esc_attr( $content_columns ); ?>">

				<div id="primary" class="content-area single-content">
					<main id="main" class="site-main" role="main">

						<?php

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							get_template_part( 'views/content', get_post_format() );

							//the_post_navigation();
							get_template_part( 'views/custom/single', 'pagination' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile;

						?>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- .col- -->

			<?php get_sidebar(); ?>

		</div><!-- .row -->

	</div><!-- .container -->

<?php
get_footer();
