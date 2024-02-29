<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package newsfit
 */

use RT\Newsfit\Helpers\Fns;
use RT\Newsfit\Modules\Pagination;

get_header();
$content_columns = Fns::content_columns();

?>

<?php get_search_form( [ 'echo' => true ] ); ?>
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
							<div class="col-md-12">
								<?php
								Pagination::get_pagination();
								// the_posts_navigation();
								?>
							</div>
						</div>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- .col- -->


			<?php get_sidebar(); ?>

		</div><!-- .row -->

	</div><!-- .container -->

<?php
get_footer();
