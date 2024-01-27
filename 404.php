<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package newsfit
 */

get_header(); ?>

	<div class="container">

		<div class="row">

			<div class="col-sm-12">

				<div id="primary" class="content-area">
					<main id="main" class="site-main error-404" role="main">

						<?php newsfit_get_img( '404.svg', true, 'width="1007" height="530"' ); ?>

						<div class="error-info">
						<h2 class="error-title"><?php esc_html_e( 'Error Page!', 'newsfit' ); ?></h2>
						<p><?php esc_html_e('Sorry! This Page is Not Available!', 'newsfit'); ?></p>
						<a class="btn btn-primary" href="<?php echo esc_url(home_url()) ?>"><?php esc_html_e('Back to Home', 'newsfit') ?></a>
						</div>
					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- .col- -->

		</div><!-- .row -->

	</div><!-- .container -->

<?php
get_footer();
