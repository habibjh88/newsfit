<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newsfit
 */

use RT\NewsFit\Options\Opt;
use RT\NewsFit\Helpers\Fns;

get_header();
$content_columns = Fns::content_columns();
?>

	<div class="container">

		<div class="row align-stretch">

			<div class="<?php echo esc_attr( $content_columns ); ?>">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
						<div class="row">
							<?php
							if ( have_posts() ) :
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'views/content', get_post_format() );
								endwhile;
							else :
								get_template_part( 'views/content', 'none' );
							endif;
							?>
						</div>

						<div class="row post-pagination">
							<?php the_posts_navigation(); ?>
						</div>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- .col- -->


			<?php get_sidebar(); ?>

		</div><!-- .row -->

	</div><!-- .container -->

<?php


get_footer();
