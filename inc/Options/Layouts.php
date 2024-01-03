<?php

namespace RT\NewsFit\Options;

use RT\NewsFit\Traits\SingletonTraits;

class Layouts {

	use SingletonTraits;

	public $base;
	public $type;
	public $meta_value;

	public function __construct() {
		add_action( 'template_redirect', [ $this, 'set_options_value' ] );
	}

	/**
	 * Set Options value
	 * @return void
	 */
	public function set_options_value(): void {

		// Single Pages
		if ( ( is_single() || is_page() ) ) {
			$post_type        = get_post_type();
			$post_id          = get_the_id();
			$this->meta_value = get_post_meta( $post_id, "rt_layout_meta_data", true );


			switch ( $post_type ) {
				case 'post':
					$this->type = 'single_post';
					break;
				case 'product' :
					$this->type = 'woocommerce_single';
					break;
				default:
					$this->type = 'page';
			}

			Opt::$layout         = $this->check_meta_and_option_value( 'layout' );
			Opt::$header_style   = $this->check_meta_and_option_value( 'header_style', false, true );
			Opt::$sidebar        = $this->check_meta_and_option_value( 'sidebar' );
			Opt::$header_width   = $this->check_meta_and_option_value( 'header_width' );
			Opt::$menu_alignment = $this->check_meta_and_option_value( 'menu_alignment' );
			Opt::$padding_top    = $this->check_meta_and_option_value( 'padding_top' );
			Opt::$padding_bottom = $this->check_meta_and_option_value( 'padding_bottom' );
			Opt::$footer_style   = $this->check_meta_and_option_value( 'footer_style', false, true );
			Opt::$has_top_bar    = $this->check_meta_and_option_value( 'top_bar', true, true );
			Opt::$has_tr_header  = $this->check_meta_and_option_value( 'tr_header', true, true );
			Opt::$has_breadcrumb = $this->check_meta_and_option_value( 'breadcrumb', true, true );
		} // Blog and Archive
		elseif ( is_home() || is_archive() || is_search() || is_404() ) {
			if ( is_404() ) {
				$this->type                               = 'error';
				Opt::$options[ $this->type . '_layout' ]  = 'full-width';
				Opt::$options[ $this->type . '_sidebar' ] = '';
			} elseif ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$this->type = 'woocommerce_archive';
			} else {
				$this->type = 'blog';
			}

			Opt::$layout         = $this->check_option_value( 'layout' );
			Opt::$header_style   = $this->check_option_value( 'header_style', false, true );
			Opt::$sidebar        = $this->check_option_value( 'sidebar' );
			Opt::$header_width   = $this->check_option_value( 'header_width' );
			Opt::$menu_alignment = $this->check_option_value( 'menu_alignment' );
			Opt::$padding_top    = $this->check_option_value( 'padding_top' );
			Opt::$padding_bottom = $this->check_option_value( 'padding_bottom' );
			Opt::$footer_style   = $this->check_option_value( 'footer_style', false, true );
			Opt::$has_top_bar    = $this->check_option_value( 'top_bar', true, true );
			Opt::$has_tr_header  = $this->check_option_value( 'tr_header', true, true );
			Opt::$has_breadcrumb = $this->check_option_value( 'breadcrumb', true, true );
		}
	}

	/**
	 * Get Meta and Options value conditionally
	 *
	 * @param $key
	 * @param $is_bool
	 *
	 * @return bool|mixed|string
	 */
	private function check_meta_and_option_value( $key, $is_bool = false, $check_layout = false ) {
		$option_key      = $this->type . '_' . $key;
		$meta_value      = $this->meta_value[ $key ] ?? 'default';
		$opt_from_layout = Opt::$options[ $option_key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'rt_' . $key ] ?? 'default';

		if ( $meta_value != 'default' ) { //Check from Meta
			$result = $meta_value;
		} elseif ( $check_layout && $opt_from_layout != 'default' ) { //Check from Layout
			$result = $opt_from_layout;
		} else { //Set global option
			$result = $opt_from_global;
		}

		if ( $is_bool ) {
			return $result == 1 || $result == 'on';
		}

		return $result;
	}

	/**
	 * Get Options value only
	 *
	 * @param $key
	 * @param bool $is_bool
	 *
	 * @return bool|mixed|string
	 */
	private function check_option_value( $key, $is_bool = false, $check_layout = false ) {
		$option_key = $this->type . '_' . $key;

		$opt_from_layout = Opt::$options[ $option_key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'rt_' . $key ] ?? 'default';


		if ( $check_layout && $opt_from_layout != 'default' ) {
			$result = $opt_from_layout;
		} else {
			$result = $opt_from_global;
		}

		if ( $is_bool ) {
			return $result == 1 || $result == 'on';
		}

		return $result;
	}

}
