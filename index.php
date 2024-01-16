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

get_header(); ?>

	<div class="default-index-content pt-40 pb-40">
		<div class="container">

			<div class="row align-stretch">

				<div class="col-sm-8">

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
									the_posts_navigation();
								else :
									get_template_part( 'views/content', 'none' );
								endif;
								?>
							</div>

						</main><!-- #main -->
					</div><!-- #primary -->

				</div><!-- .col- -->

				<div id="sidebar" class="col-sm-4">
					<?php get_sidebar(); ?>
				</div><!-- .col- -->

			</div><!-- .row -->

		</div><!-- .container -->
	</div>
<?php
get_footer();
