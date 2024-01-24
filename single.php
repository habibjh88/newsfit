<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package newsfit
 */

use RT\NewsFit\Helpers\Fns;
use RT\NewsFit\Options\Opt;

get_header();
$content_columns = Fns::content_columns();
$classes         = newsfit_classes( [
	'single-post-container',
	Fns::is_single_fullwidth() ? 'should-full-width' : ''
] );
?>

	<div class="<?php echo esc_attr( $classes ) ?>">

		<?php while ( have_posts() ) : ?>

			<?php do_action( 'newsfit_before_single_content' ); ?>
			<div class="container">
				<div class="row">

					<div class="<?php echo esc_attr( $content_columns ); ?>">

						<div id="primary" class="content-area single-content">
							<main id="main" class="site-main" role="main">
								<?php
								the_post();
								get_template_part( 'views/content-single', Opt::$single_style );
								//post thumbnail navigation
								get_template_part( 'views/custom/single', 'pagination' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
								?>
							</main><!-- #main -->
						</div><!-- #primary -->

					</div><!-- .col- -->

					<?php get_sidebar(); ?>

				</div><!-- .row -->
			</div><!-- .container -->
			<?php do_action( 'newsfit_after_single_content' ); ?>
		<?php endwhile; ?>

	</div>

<?php
get_footer();
