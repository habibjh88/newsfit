<?php

namespace RT\Newsfit\Setup;

use RT\Newsfit\Helpers\Constants;
use RT\Newsfit\Traits\SingletonTraits;

/**
 * Enqueue.
 */
class Enqueue {
	use SingletonTraits;

	/**
	 * Register default hooks and actions for WordPress
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 12 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 15 );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ], 15 );
	}

	/**
	 * Register script
	 *
	 * @return void
	 */
	public function register_scripts() {
		wp_register_style( 'newsfit-gfonts', $this->fonts_url(), [], Constants::get_version() );
	}

	/**
	 * Enqueue all necessary scripts and styles for the theme
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		// CSS.
		wp_enqueue_style( 'newsfit-gfonts' );
		wp_enqueue_style( 'newsfit-main', newsfit_get_css( 'style', true ), [], Constants::get_version() );

		// JS.

		$scripts = [
			[
				'handle' => 'magnific-popup',
				'src'    => newsfit_get_js( 'vendor/magnific-popup' ),
				'deps'   => [ 'jquery' ],
				'footer' => true,
			],
			[
				'handle' => 'slick',
				'src'    => newsfit_get_js( 'vendor/slick' ),
				'deps'   => [ 'jquery' ],
				'footer' => true,
			],
			[
				'handle' => 'newsfit-main',
				'src'    => newsfit_get_js( 'scripts' ),
				'deps'   => [ 'jquery' ],
				'footer' => true,
			],
		];
		foreach ( $scripts as $script ) {
			wp_enqueue_script( $script['handle'], $script['src'], $script['deps'], $script['version'] ?? Constants::get_version(), $script['footer'] );
		}

		//wp_enqueue_script( 'magnific-popup', newsfit_get_js( 'vendor/magnific-popup' ), [ 'jquery' ], Constants::get_version(), true );
		//wp_enqueue_script( 'newsfit-main', newsfit_get_js( 'scripts' ), [ 'jquery' ], Constants::get_version(), true );

		// Extra.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Admin Enqueue
	 *
	 * @return void
	 */
	public function admin_scripts( $screen ) {
		global $post_type;
		if ( 'post' === $post_type && 'post.php' === $screen ) {
			wp_enqueue_script( 'newsfit-meta', newsfit_get_js( 'postmeta' ), [ 'jquery' ], Constants::get_version(), true );
		}
	}

	public function fonts_url() {

		if ( 'off' === _x( 'on', 'Google font: on or off', 'newsfit' ) ) {
			return '';
		}

		// Default variable.
		$subsets = '';

		$body_font = json_decode( newsfit_option( 'rt_body_typo' ), true );
		$menu_font = json_decode( newsfit_option( 'rt_menu_typo' ), true );
		$h_font    = json_decode( newsfit_option( 'rt_all_heading_typo' ), true );

		$bodyFont = $body_font['font'] ?? 'IBM Plex Sans'; // Body Font
		$menuFont = $menu_font['font'] ?? $bodyFont; // Menu Font
		$hFont    = $h_font['font'] ?? $body_font; // Heading Font
		$hFontW   = $h_font['regularweight'];

		$heading_fonts = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];

		foreach ( $heading_fonts as $heading ) {
			$heading_font         = json_decode( newsfit_option( "rt_heading_{$heading}_typo" ), true );
			${$heading . '_font'} = $heading_font;
			${$heading . 'Font'}  = ''; // Assign default value if not exist the value
			if ( ! empty( $heading_font['font'] ) ) {
				${$heading . 'Font'}  = $heading_font['font'] == 'Inherit' ? $hFont : $heading_font['font'];
				${$heading . 'FontW'} = $heading_font['font'] == 'Inherit' ? $hFontW : $heading_font['regularweight'];
			}
		}

		$check_families = [];
		$font_families  = [];

		// Body Font
		$font_families[]  = $bodyFont . ':300,400,500,600,700';
		$check_families[] = $bodyFont;

		// Menu Font
		if ( ! in_array( $menuFont, $check_families ) ) {
			$font_families[]  = $menuFont . ':300,400,500,600,700';
			$check_families[] = $menuFont;
		}

		// Heading Font
		if ( ! in_array( $hFont, $check_families ) ) {
			$font_families[]  = $hFont . ':300,400,500,600,700';
			$check_families[] = $hFont;
		}

		// Check all heading fonts
		foreach ( $heading_fonts as $heading ) {
			$hDynamic = ${$heading . '_font'};
			if ( ! empty( $hDynamic['font'] ) ) {
				if ( ! in_array( ${$heading . 'Font'}, $check_families ) ) {
					$font_families[]  = ${$heading . 'Font'} . ':' . ${$heading . 'FontW'};
					$check_families[] = ${$heading . 'Font'};
				}
			}
		}

		$final_fonts = array_unique( $font_families );
		$query_args  = [
			'family'  => urlencode( implode( '|', $final_fonts ) ),
			'display' => urlencode( 'fallback' ),
		];

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
}
