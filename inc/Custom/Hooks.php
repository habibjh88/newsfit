<?php

namespace RT\NewsFit\Custom;

use RT\NewsFit\Traits\SingletonTraits;
use RT\NewsFit\Options\Opt;

/**
 * Extras.
 */
class Hooks {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {

		add_action( 'newsfit_banner', [ __CLASS__, 'banner' ] );

	}

	/**
	 * Site Breadcrumb
	 * @return void
	 */
	public static function banner() {
		if ( ! Opt::$has_banner ) {
			return;
		}

		$banner_image_css = '';


		if ( ! empty( Opt::$banner_image ) ) {
			$image_url = wp_get_attachment_image_src( Opt::$banner_image, 'full' );

			$banner_image_css .= isset( $image_url[0] ) ? "background-image:url({$image_url[0]});" : '';

			if ( ! empty( Opt::$banner_height ) ) {
				$banner_image_css .= "min-height:" . rtrim( Opt::$banner_height, 'px' ) . "px;";
			}

			if ( ! empty( newsfit_option( 'rt_banner_image_attr' ) ) ) {
				$bg_attr = json_decode( newsfit_option( 'rt_banner_image_attr' ), ARRAY_A );

				if ( ! empty( $bg_attr['position'] ) ) {
					$banner_image_css .= "background-position: {$bg_attr['position']};";
				}
				if ( ! empty( $bg_attr['attachment'] ) ) {
					$banner_image_css .= "background-attachment: {$bg_attr['attachment']};";
				}
				if ( ! empty( $bg_attr['repeat'] ) ) {
					$banner_image_css .= "background-repeat: {$bg_attr['repeat']};";
				}
				if ( ! empty( $bg_attr['size'] ) ) {
					$banner_image_css .= "background-size: {$bg_attr['size']};";
				}
			}
		}

		?>
		<div class="newsfit-breadcrumb-wrapper" style="<?php echo esc_attr( $banner_image_css ) ?>">
			<?php if ( Opt::$has_breadcrumb )  : ?>
				<div class="container">
					<nav aria-label="breadcrumb">
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo esc_url( site_url() ); ?>"><?php esc_html_e( 'Home', 'newsfit' ) ?></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">
								<?php
								if ( is_tag() ) {
									esc_html_e( 'Posts Tagged ', 'newsfit' );
									?><span class="raquo">/</span><?php
									single_tag_title();
									echo '/';
								} elseif ( is_day() || is_month() || is_year() ) {
									esc_html_e( 'Posts made in', 'newsfit' );
									echo esc_html( get_the_time( is_year() ? 'Y' : ( is_month() ? 'F, Y' : 'F jS, Y' ) ) );
								} elseif ( is_search() ) {
									esc_html_e( 'Search results for', 'newsfit' );
									the_search_query();
								} elseif ( is_404() ) {
									esc_html_e( '404', 'newsfit' );
								} elseif ( is_single() ) {
									$category = get_the_category();
									if ( $category ) {
										$catlink = get_category_link( $category[0]->cat_ID );
										echo '<a href="' . esc_url( $catlink ) . '">' . esc_html( $category[0]->cat_name ) . '</a> <span class="raquo"> /</span> ';
									}
									echo get_the_title();
								} elseif ( is_category() ) {
									single_cat_title();
								} elseif ( is_tax() ) {
									$tt_taxonomy_links = [];
									$tt_term           = get_queried_object();
									$tt_term_parent_id = $tt_term->parent;
									$tt_term_taxonomy  = $tt_term->taxonomy;

									while ( $tt_term_parent_id ) {
										$tt_current_term     = get_term( $tt_term_parent_id, $tt_term_taxonomy );
										$tt_taxonomy_links[] = '<a href="' . esc_url( get_term_link( $tt_current_term, $tt_term_taxonomy ) ) . '" title="' . esc_attr( $tt_current_term->name ) . '">' . esc_html( $tt_current_term->name ) . '</a>';
										$tt_term_parent_id   = $tt_current_term->parent;
									}

									if ( ! empty( $tt_taxonomy_links ) ) {
										echo implode( ' <span class="raquo">/</span> ', array_reverse( $tt_taxonomy_links ) ) . ' <span class="raquo">/</span> ';
									}

									echo esc_html( $tt_term->name );
								} elseif ( is_author() ) {
									global $wp_query;
									$current_author = $wp_query->get_queried_object();

									esc_html_e( 'Posts by: ', 'newsfit' );
									echo ' ', esc_html( $current_author->nickname );
								} elseif ( is_page() ) {
									echo get_the_title();
								} elseif ( is_home() ) {
									esc_html_e( 'Blog', 'newsfit' );
								} elseif ( class_exists( 'WooCommerce' ) and is_shop() ) {
									esc_html_e( 'Shop', 'newsfit' );
								}
								?>
							</li>
						</ul>
					</nav>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

}
