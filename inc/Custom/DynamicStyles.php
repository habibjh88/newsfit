<?php

namespace RT\NewsFit\Custom;

use RT\NewsFit\Options\Opt;
use RT\NewsFit\Traits\SingletonTraits;

class DynamicStyles {

	use SingletonTraits;

	protected $meta_data;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 1 );
	}

	public function enqueue_scripts() {
		$this->meta_data = get_post_meta( get_the_ID(), "rt_layout_meta_data", true );
		$dynamic_css     = $this->inline_style();
		wp_register_style( 'newsfit-dynamic', false );
		wp_enqueue_style( 'newsfit-dynamic' );
		wp_add_inline_style( 'newsfit-dynamic', $this->minify_css( $dynamic_css ) );
	}

	function minify_css( $css ) {
		$css = preg_replace( '/\/\*[^*]*\*+([^\/][^*]*\*+)*\//', '', $css ); // Remove comments
		$css = preg_replace( '/\s+/', ' ', $css ); // Remove multiple spaces
		$css = preg_replace( '/\s*([\{\};,:])\s*/', '$1', $css ); // Remove spaces around { } ; : ,

		return $css;
	}

	private function inline_style() {

		$primary_color       = newsfit_option( 'rt_primary_color' ) ?? '#00c194';
		$primary_dark_color  = newsfit_option( 'rt_primary_dark_color' ) ?? '#091EF6';
		$primary_light_color = newsfit_option( 'rt_primary_light_color' ) ?? '#4AA2FF';
		$secondary_color     = newsfit_option( 'rt_secondary_color' ) ?? '#131619';
		$body_color          = newsfit_option( 'rt_body_color' ) ?? '#3D3E41';
		$title_color         = newsfit_option( 'rt_title_color' ) ?? '#161D25';
		$meta_color          = newsfit_option( 'rt_meta_color' ) ?? '#808993';
		$gray1_color         = newsfit_option( 'rt_gray1_color' ) ?? '#E6E6E6';
		$gray2_color         = newsfit_option( 'rt_gray2_color' ) ?? '#D0D0D0';
		$gray3_color         = newsfit_option( 'rt_gray3_color' ) ?? '#bfc7d7';

		ob_start(); ?>

		:root {
		--rt-primary-color: <?php echo esc_html( $primary_color ); ?>;
		--rt-primary-dark: <?php echo esc_html( $primary_dark_color ); ?>;
		--rt-primary-light: <?php echo esc_html( $primary_light_color ); ?>;
		--rt-secondary-color: <?php echo esc_html( $secondary_color ); ?>;
		--rt-body-color: <?php echo esc_html( $body_color ); ?>;
		--rt-title-color: <?php echo esc_html( $title_color ); ?>;
		--rt-meta-color: <?php echo esc_html( $meta_color ); ?>;
		--rt-gray1-color: <?php echo esc_html( $gray1_color ); ?>;
		--rt-gray2-color: <?php echo esc_html( $gray2_color ); ?>;
		--rt-gray3-color: <?php echo esc_html( $gray3_color ); ?>;
		--rt-body-rgb: <?php echo esc_html( newsfit_hex2rgb( $body_color ) ); ?>;
		--rt-title-rgb: <?php echo esc_html( newsfit_hex2rgb( $title_color ) ); ?>;
		--rt-primary-rgb: <?php echo esc_html( newsfit_hex2rgb( $primary_color ) ); ?>;
		--rt-secondary-rgb: <?php echo esc_html( newsfit_hex2rgb( $secondary_color ) ); ?>;
		}

		body {
		color: <?php echo esc_html( $body_color ); ?>;
		}

		<?php
		$this->topbar_css();
		$this->header_css();
		$this->breadcrumb_css();
		$this->content_padding_css();

		return ob_get_clean();
	}

	/**
	 * Topbar Settings
	 * @return void
	 */
	protected function topbar_css() {
		$rt_topbar_color        = newsfit_option( 'rt_topbar_color' );
		$rt_topbar_active_color = newsfit_option( 'rt_topbar_active_color' );
		$rt_topbar_bg_color     = newsfit_option( 'rt_topbar_bg_color' );
		?>

		<?php if ( ! empty( $rt_topbar_color ) ) : ?>
			body .has-transparent-header .site-header .newsfit-topbar *:not(.dropdown-menu *),
			body .newsfit-topbar #topbar-menu ul.newsfit-topbar-menu > li > *:not(.dropdown-menu *) {
			color: <?php echo esc_attr( $rt_topbar_color ); ?>!important;
			}
		<?php endif; ?>

		<?php if ( ! empty( $rt_topbar_active_color ) ) : ?>
			body .newsfit-topbar a:hover,
			body .newsfit-topbar #topbar-menu ul ul li.current_page_item > a,
			body .newsfit-topbar #topbar-menu ul ul li.current-menu-ancestor > a,
			body .newsfit-topbar #topbar-menu ul.newsfit-topbar-menu > li.current-menu-item > a,
			body .newsfit-topbar #topbar-menu ul.newsfit-topbar-menu > li.current-menu-ancestor > a {
			color: <?php echo esc_attr( $rt_topbar_active_color ); ?> !important;
			}

			body .newsfit-topbar #topbar-menu ul.newsfit-topbar-menu > li.current-menu-item > a svg,
			body .newsfit-topbar #topbar-menu ul.newsfit-topbar-menu > li.current-menu-ancestor > a svg {
			fill: <?php echo esc_attr( $rt_topbar_active_color ); ?> !important;
			}
		<?php endif; ?>

		<?php if ( ! empty( $rt_topbar_bg_color ) ) : ?>
			body .newsfit-topbar {
			background-color: <?php echo esc_attr( $rt_topbar_bg_color ); ?>;
			}
		<?php endif; ?>

		<?php
	}


	/**
	 * Menu Color Settings
	 * @return void
	 */
	protected function header_css() {
		//Logo CSS
		$logo_width = '';

		$logo_dimension     = newsfit_option( 'rt_logo_width_height' );
		$menu_border_bottom = newsfit_option( 'rt_menu_border_color' );

		if ( strpos( $logo_dimension, ',' ) ) {
			$logo_width = explode( ',', $logo_dimension );
		}

		//Default Menu
		$rt_menu_color        = newsfit_option( 'rt_menu_color' ) ?? '';
		$rt_menu_active_color = newsfit_option( 'rt_menu_active_color' ) ?? '';
		$rt_menu_bg_color     = newsfit_option( 'rt_menu_bg_color' ) ?? '';

		//Transparent Menu
		$rt_tr_menu_color        = newsfit_option( 'rt_tr_menu_color' ) ?? '';
		$rt_tr_menu_active_color = newsfit_option( 'rt_tr_menu_active_color' ) ?? '';

		$rt_topbar_border     = newsfit_option( 'rt_topbar_border' );
		$rt_header_border     = newsfit_option( 'rt_header_border' );
		$rt_breadcrumb_border = newsfit_option( 'rt_breadcrumb_border' );
		?>

		<?php //Header Logo CSS ?>
		<?php if ( newsfit_option( 'rt_header_width' ) && newsfit_option( 'rt_header_max_width' ) > 1400 ) : ?>
			.header-container, .topbar-container {width: <?php echo newsfit_option( 'rt_header_max_width' ); ?>px;max-width: 100%;}
		<?php endif; ?>

		<?php if ( ! empty( $logo_width ) ) : ?>
			.site-header .site-branding img {
			max-width: <?php echo esc_attr( $logo_width[0] ?? '100%' ) ?>;
			max-height: <?php echo esc_attr( $logo_width[1] ?? 'auto' ) ?>;
			object-fit: contain;
			}
		<?php endif; ?>

		<?php //Default Header ?>
		<?php if ( ! empty( $rt_menu_color ) ) : ?>
			body .main-header-section .newsfit-navigation ul li a {color: <?php echo esc_attr( $rt_menu_color ) ?>;}
			body .main-header-section [class*=rticon] svg {fill: <?php echo esc_attr( $rt_menu_color ) ?>;}
			body .main-header-section .menu-icon-wrapper .menu-bar span {background-color: <?php echo esc_attr( $rt_menu_color ) ?>;}
		<?php endif; ?>

		<?php if ( ! empty( $rt_menu_active_color ) ) : ?>
			body .main-header-section .newsfit-navigation ul li a:hover,
			body .main-header-section .newsfit-navigation ul li.current-menu-item > a,
			body .main-header-section .newsfit-navigation ul li.current-menu-ancestor > a {color: <?php echo esc_attr( $rt_menu_active_color ) ?>;}
			body .main-header-section .newsfit-navigation ul li.current-menu-item > a svg,body .main-header-section .newsfit-navigation ul li.current-menu-ancestor > a svg {fill: <?php echo esc_attr( $rt_menu_active_color ) ?>;}
			body .main-header-section .menu-icon-wrapper .menu-bar:hover span {background-color: <?php echo esc_attr( $rt_menu_active_color ) ?>;}
			body .main-header-section a:hover [class*=rticon] svg {fill: <?php echo esc_attr( $rt_menu_active_color ) ?>;}
		<?php endif; ?>

		<?php if ( ! empty( $rt_menu_bg_color ) ) : ?>
			body .main-header-section {background-color: <?php echo esc_attr( $rt_menu_bg_color ) ?>;}
		<?php endif; ?>

		<?php //Transparent Header ?>
		<?php if ( ! empty( $rt_tr_menu_color ) ) : ?>
			body.has-transparent-header .site-header .site-branding h1 a,
			body.has-transparent-header .site-header .newsfit-navigation *,
			body.has-transparent-header .site-header .newsfit-navigation ul li a {
			color: <?php echo esc_attr( $rt_tr_menu_color ); ?>;
			}
			body.has-transparent-header .site-header .menu-bar span {
			background-color: <?php echo esc_attr( $rt_tr_menu_color ); ?> !important;
			}

			body.has-transparent-header .site-header .menu-icon-wrapper svg,
			body.has-transparent-header .site-header .newsfit-topbar .caret svg,
			body.has-transparent-header .site-header .main-header-section .caret svg {
			fill: <?php echo esc_attr( $rt_tr_menu_color ); ?>
			}
		<?php endif; ?>

		<?php if ( ! empty( $rt_tr_menu_active_color ) ) : ?>
			body.has-transparent-header .site-header .newsfit-navigation ul li a:hover,
			body.has-transparent-header .site-header .newsfit-navigation ul li.current-menu-item > a,
			body.has-transparent-header .site-header .newsfit-navigation ul li.current-menu-ancestor > a {
			color: <?php echo esc_attr( $rt_tr_menu_active_color ); ?>
			}
			body.has-transparent-header .main-header-section .menu-icon-wrapper .menu-bar:hover span {
			background-color: <?php echo esc_attr( $rt_tr_menu_active_color ); ?> !important;
			}
			body.has-transparent-header .main-header-section a:hover [class*=rticon] svg,
			body.has-transparent-header .site-header .newsfit-navigation ul li.current-menu-ancestor > a svg,
			body.has-transparent-header .site-header .newsfit-navigation ul li.current-menu-item > a svg {
			fill: <?php echo esc_attr( $rt_tr_menu_active_color ); ?>
			}
		<?php endif; ?>
		<?php if ( ! empty( $menu_border_bottom ) ) : ?>
			body .newsfit-topbar,
			body .main-header-section,
			body .newsfit-breadcrumb-wrapper {
			border-bottom-color: <?php echo esc_attr( $menu_border_bottom ); ?>;
			}
		<?php endif; ?>


		<?php if ( ! $rt_topbar_border ) : ?>
			body .newsfit-topbar {border-bottom: none;}
		<?php endif; ?>
		<?php if ( ! $rt_header_border ) : ?>
			body .main-header-section {border-bottom: none;}
		<?php endif; ?>
		<?php if ( ! $rt_breadcrumb_border ) : ?>
			body .newsfit-breadcrumb-wrapper {border-bottom: none;}
		<?php endif; ?>

		<?php
	}


	/**
	 * Breadcrumb Settings
	 * @return void
	 */
	protected function breadcrumb_css() {
		$banner_bg         = newsfit_option( 'rt_banner_bg' ) ?? '';
		$breadcrumb_color  = newsfit_option( 'rt_breadcrumb_color' ) ?? '';
		$breadcrumb_active = newsfit_option( 'rt_breadcrumb_active' ) ?? '';
		if ( ! empty( $banner_bg ) ) : ?>
			body .newsfit-breadcrumb-wrapper {background-color: <?php echo esc_attr( $banner_bg ) ?>;}
		<?php endif; ?>
		<?php if ( ! empty( $breadcrumb_color ) ) : ?>
			body .newsfit-breadcrumb-wrapper .breadcrumb a {color: <?php echo esc_attr( $breadcrumb_color ) ?>;}
			body .newsfit-breadcrumb-wrapper .breadcrumb li::after {border-color: <?php echo esc_attr( $breadcrumb_color ) ?>;}
		<?php endif; ?>
		<?php if ( ! empty( $breadcrumb_active ) ) : ?>
			body .newsfit-breadcrumb-wrapper .breadcrumb li.active {color: <?php echo esc_attr( $breadcrumb_active ) ?>;}
		<?php endif;
	}

	/**
	 * Content Padding
	 * @return void
	 */
	protected function content_padding_css() {

		$content_padding_top    = $this->meta_data['rt_padding_top'] ?? '';
		$content_padding_bottom = $this->meta_data['rt_padding_bottom'] ?? '';

		if ( ! ( $content_padding_top || $content_padding_bottom ) ) {
			return;
		}
		$class = 'body .site-content';
		if ( Opt::$has_banner ) {
			$class = 'body.has-banner .site-content .newsfit-breadcrumb-wrapper + div';
		}
		?>
		<?php echo esc_attr( $class ) ?> {
		<?php if ( $content_padding_top ) : ?>
			padding-top: <?php echo esc_attr( $content_padding_top ); ?>px;
		<?php endif; ?>
		<?php if ( $content_padding_bottom ) : ?>
			padding-bottom: <?php echo esc_attr( $content_padding_bottom ); ?>px;
		<?php endif; ?>
		}
		<?php
	}

}
