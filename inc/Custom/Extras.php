<?php

namespace RT\Newsfit\Custom;

use RT\Newsfit\Traits\SingletonTraits;
use RT\Newsfit\Options\Opt;
use RT\Newsfit\Modules\Svg;

/**
 * Extras.
 */
class Extras {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 *
	 * @return
	 */
	public function __construct() {
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_filter( 'get_search_form', [ $this, 'search_form' ] );
		add_action( 'after_switch_theme', [ $this, 'rewrite_flush' ] );
	}

	/*
	 * Body Class added
	 */
	public function body_class( $classes ) {

		// Adds a class of group-blog to blogs with more than 1 published author.

		$classes[] = 'newsfit-header-' . Opt::$header_style;
		$classes[] = 'newsfit-footer-' . Opt::$footer_style;

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		if ( Opt::$has_tr_header ) {
			$classes[] = 'has-trheader';
		} else {
			$classes[] = 'no-trheader';
		}

		if ( newsfit_option( 'rt_tr_header_shadow' ) ) {
			$classes[] = 'has-menu-shadow';
		}

		if ( Opt::$has_banner ) {
			$classes[] = 'has-banner';
		} else {
			$classes[] = 'no-banner';
		}

		if ( Opt::$layout ) {
			$classes[] = 'layout-' . Opt::$layout;
		}

		if ( newsfit_option( 'rt_sticy_header' ) ) {
			$classes[] = 'has-sticky-header';
		}

		if ( is_single() && Opt::$single_style ) {
			$classes[] = 'newsfit-single-' . Opt::$single_style;
		}

		return $classes;
	}

	/**
	 * Search form modify
	 *
	 * @return string
	 */
	public function search_form() {
		$output = '
		<form method="get" class="newsfit-search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <div class="search-box">
				<input type="text" class="form-control" placeholder="' . esc_attr__( 'Type here to search...', 'newsfit' ) . '" value="' . get_search_query() . '" name="s" />
				<button class="item-btn" type="submit">
					' . Svg::get_svg( 'search', false ) . '
					<span class="btn-label">' . esc_html__( 'Search', 'newsfit' ) . '</span>
				</button>
            </div>
		</form>
		';

		return $output;
	}

	/**
	 * Flush Rewrite on CPT activation
	 *
	 * @return empty
	 */
	public function rewrite_flush() {
		// Flush the rewrite rules only on theme activation
		flush_rewrite_rules();
	}
}
