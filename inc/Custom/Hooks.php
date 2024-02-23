<?php

namespace RT\Newsfit\Custom;

use RT\Newsfit\Helpers\Fns;
use RT\Newsfit\Traits\SingletonTraits;
use RT\Newsfit\Options\Opt;

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
		add_action( 'wp_footer', [ __CLASS__, 'wp_footer_hook' ] );

		$this->filter_hooks();
	}

	/**
	 * Filter hooks
	 *
	 * @return void
	 */
	private function filter_hooks() {
		add_filter( 'wp_kses_allowed_html', [ __CLASS__, 'custom_wpkses_post_tags' ], 10, 2 );
	}

	public static function wp_footer_hook() {
		?>
		<style>
			.newsfit-header-footer .site-header {
				opacity: 1;
			}
		</style>

		<?php
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
				display: <?php echo esc_attr( $display ); ?>;
			}
		</style>
		<?php
	}

	/**
	 * Before single content hook
	 *
	 * @return void
	 */
	public static function before_single_content() {
		$style = Opt::$single_style;

		if ( in_array( $style, [ '2', '3', '4' ] ) ) {
			$classes = Fns::class_list(
				[
					'content-top-area',
					( '2' == $style ) ? 'container' : 'rt-container-fluid',
				]
			);
			?>

			<div class="<?php echo esc_attr( $classes ); ?>">

				<?php newsfit_post_single_thumbnail(); ?>

				<?php if ( '3' == $style ) : ?>
					<div class='single-top-header <?php echo esc_attr( newsfit_post_class( null ) ); ?>'>
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

	/**
	 * Add exceptions in wp_kses_post tags.
	 *
	 * @param array  $tags Allowed tags, attributes, and/or entities.
	 * @param string $context Context to judge allowed tags by. Allowed values are 'post'.
	 *
	 * @return array
	 */
	public static function custom_wpkses_post_tags( $tags, $context ) {
		if ( 'post' === $context ) {
			$tags['iframe'] = [
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
			];

			$tags['svg'] = [
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true,
				'stroke'          => true,
				'fill'            => true,
			];

			$tags['g']     = [ 'fill' => true ];
			$tags['title'] = [ 'title' => true ];
			$tags['path']  = [
				'd'               => true,
				'fill'            => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'fill-rule'       => true,
				'clip-rule'       => true,
				'stroke'          => true,
			];
		}

		return $tags;
	}
}
