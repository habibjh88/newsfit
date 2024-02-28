<?php

namespace RT\Newsfit\Options;

use RT\Newsfit\Traits\SingletonTraits;

/**
 * Layouts Class
 */
class Layouts {

	use SingletonTraits;

	/**
	 * Page Type depending on the page type
	 *
	 * @var null
	 */
	public $type = null;

	/**
	 * Store temporary Meta Value
	 *
	 * @var null
	 */
	public $meta_value = null;

	/**
	 * Class Constructor function
	 */
	public function __construct() {
		add_action( 'template_redirect', [ $this, 'set_options_value' ] );
		add_action( 'template_redirect', [ $this, 'overwrite_options_value' ] );
	}

	/**
	 * Set Options value
	 *
	 * @return void
	 */
	public function set_options_value() {

		if ( ( is_single() || is_page() ) ) {
			// Single Pages.
			$post_type        = get_post_type();
			$post_id          = get_the_id();
			$this->meta_value = get_post_meta( $post_id, 'rt_layout_meta_data', true );

			switch ( $post_type ) {
				case 'post':
					$this->type = 'single_post';
					break;
				case 'product':
					$this->type = 'woocommerce_single';
					break;
				default:
					$this->type = 'page';
			}

			Opt::$layout         = $this->check_meta_and_layout_value( 'layout', false, true );
			Opt::$header_style   = $this->check_meta_and_layout_value( 'header_style', false, true );
			Opt::$sidebar        = $this->check_meta_and_layout_value( 'sidebar', false, true );
			Opt::$header_width   = $this->check_meta_and_layout_value( 'header_width' );
			Opt::$menu_alignment = $this->check_meta_and_layout_value( 'menu_alignment' );
			Opt::$padding_top    = $this->check_meta_and_layout_value( 'padding_top' );
			Opt::$padding_bottom = $this->check_meta_and_layout_value( 'padding_bottom' );
			Opt::$banner_image   = $this->check_meta_and_layout_value( 'banner_image', false, true );
			Opt::$banner_height  = $this->check_meta_and_layout_value( 'banner_height', false, true );
			Opt::$footer_style   = $this->check_meta_and_layout_value( 'footer_style', false, true );
			Opt::$footer_schema  = $this->check_meta_and_layout_value( 'footer_schema', false, true );
			Opt::$has_top_bar    = $this->check_meta_and_layout_value( 'top_bar', true, true );
			Opt::$has_tr_header  = $this->check_meta_and_layout_value( 'tr_header', true, true );
			Opt::$has_breadcrumb = $this->check_meta_and_layout_value( 'breadcrumb', true, true );
			Opt::$has_banner     = $this->check_meta_and_layout_value( 'banner', true, true );
			Opt::$single_style   = $this->check_meta_option_value( 'single_post_style' );
		} elseif ( is_home() || is_archive() || is_search() || is_search() ) {
			// Blog and Archive.
			if ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$this->type = 'woocommerce_archive';
			} elseif ( is_search() ) {
				$this->type = 'search';
			} else {
				$this->type = 'blog';
			}

			Opt::$layout         = $this->check_option_value( 'layout', false, true );
			Opt::$header_style   = $this->check_option_value( 'header_style', false, true );
			Opt::$sidebar        = $this->check_option_value( 'sidebar', false, true );
			Opt::$header_width   = $this->check_option_value( 'header_width' );
			Opt::$menu_alignment = $this->check_option_value( 'menu_alignment' );
			Opt::$padding_top    = $this->check_option_value( 'padding_top' );
			Opt::$padding_bottom = $this->check_option_value( 'padding_bottom' );
			Opt::$banner_image   = $this->check_option_value( 'banner_image', false, true );
			Opt::$banner_height  = $this->check_option_value( 'banner_height', false, true );
			Opt::$footer_style   = $this->check_option_value( 'footer_style', false, true );
			Opt::$footer_schema  = $this->check_option_value( 'footer_schema', false, true );
			Opt::$has_top_bar    = $this->check_option_value( 'top_bar', true, true );
			Opt::$has_tr_header  = $this->check_option_value( 'tr_header', true, true );
			Opt::$has_breadcrumb = $this->check_option_value( 'breadcrumb', true, true );
			Opt::$has_banner     = $this->check_option_value( 'banner', true, true );
		}
	}

	/**
	 * Get Meta and Options value conditionally
	 *
	 * @param $key
	 * @param $is_bool
	 * @param $check_layout
	 *
	 * @return bool|mixed|string
	 */
	private function check_meta_and_layout_value( $key, $is_bool = false, $check_layout = false ) {
		$option_key      = $this->type . '_' . $key;
		$meta_value      = $this->meta_value[ $key ] ?? 'default';
		$opt_from_layout = Opt::$options[ $option_key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'rt_' . $key ] ?? 'default';

		if ( ! empty( $meta_value ) && 'default' != $meta_value ) {
			// Check from Meta.
			$result = $meta_value;
		} elseif ( $check_layout && ! empty( $opt_from_layout ) && 'default' != $opt_from_layout ) {
			// Check from Layout.
			$result = $opt_from_layout;
		} else {
			// Set global option.
			$result = $opt_from_global;
		}

		if ( $is_bool ) {
			return 1 == $result || 'on' == $result;
		}

		return $result;
	}

	/**
	 * Get Options value only
	 *
	 * @param $key
	 * @param $is_bool
	 * @param $check_layout
	 *
	 * @return bool|string
	 */
	private function check_option_value( $key, $is_bool = false, $check_layout = false ) {
		$option_key = $this->type . '_' . $key;

		$opt_from_layout = Opt::$options[ $option_key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'rt_' . $key ] ?? 'default';

		if ( $check_layout && ! empty( $opt_from_layout ) && 'default' != $opt_from_layout ) {
			$result = $opt_from_layout;
		} else {
			$result = $opt_from_global;
		}

		if ( $is_bool ) {
			return 1 == $result || 'on' == $result;
		}

		return $result;
	}

	/**
	 * Check meta options value
	 *
	 * @param $key
	 *
	 * @return mixed|string
	 */
	private function check_meta_option_value( $key ) {
		$meta_value      = $this->meta_value[ $key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'rt_' . $key ] ?? 'default';

		if ( ! empty( $meta_value ) && 'default' != $meta_value ) { // Check from Meta.
			$result = $meta_value;
		} else {
			$result = $opt_from_global;
		}

		return $result;
	}

	/**
	 * Overwrite options value
	 *
	 * @return void
	 */
	public function overwrite_options_value() {
		if ( '3' == Opt::$single_style ) {
			Opt::$has_tr_header = '1';
		}
	}
}
