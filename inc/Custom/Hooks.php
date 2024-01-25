<?php

namespace RT\NewsFit\Custom;

use RT\NewsFit\Helpers\Fns;
use RT\NewsFit\Traits\SingletonTraits;
use RT\NewsFit\Options\Opt;

/**
 * Extras.
 */
class Hooks {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 */
	public function __construct() {
		add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'meta_css' ] );
		add_action( 'newsfit_before_single_content', [ __CLASS__, 'before_single_content' ] );
	}

	/**
	 * Single post meta visibility
	 *
	 * @param $screen
	 *
	 * @return void
	 */
	public static function meta_css( $screen ) {
		if ( 'post.php' !== $screen ) {
			return;
		}
		global $typenow;
		$display = 'post' === $typenow ? 'table-row' : 'none';
		?>
		<style>
			.single_post_style {
				display: <?php echo esc_attr($display) ?>;
			}
		</style>
		<?php
	}

	public static function before_single_content() {
		$style = Opt::$single_style;

		if ( in_array( $style, [ '2', '3', '4' ] ) ) {
			$classes = newsfit_classes( [
				'content-top-area',
				( $style == '2' ) ? 'container' : 'rt-container-fluid'
			] );
			?>

			<div class="<?php echo esc_attr( $classes ) ?>">

				<?php newsfit_post_single_thumbnail(); ?>

				<?php if ( $style == '3' ) : ?>
					<div class='single-top-header <?php echo esc_attr( newsfit_post_class( null ) ) ?>'>
						<div class='container'>
							<div class="row">
								<div class="<?php echo esc_attr( Fns::content_columns() ); ?>">
									<?php newsfit_single_entry_header(); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<?php
		}

	}

}
