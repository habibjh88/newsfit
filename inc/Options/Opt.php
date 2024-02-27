<?php

namespace RT\Newsfit\Options;

use RT\Newsfit\Api\Customizer;
use RT\Newsfit\Traits\SingletonTraits;

/**
 * Opt Class
 */
class Opt {

	use SingletonTraits;

	/**
	 * Store Customize Options
	 *
	 * @var null
	 */
	public static $options = null;

	/**
	 * Store layout value
	 *
	 * @var null
	 */
	public static $layout = null;

	/**
	 * Store sidebar value
	 *
	 * @var null
	 */
	public static $sidebar = null;

	/**
	 * Store header_style value
	 *
	 * @var null
	 */
	public static $header_style = null;

	/**
	 * Store topbar_style value
	 *
	 * @var null
	 */
	public static $topbar_style = null;

	/**
	 * Store footer_style value
	 *
	 * @var null
	 */
	public static $footer_style = null;

	/**
	 * Store footer_schema value
	 *
	 * @var null
	 */
	public static $footer_schema = null;

	/**
	 * Store has_banner value
	 *
	 * @var null
	 */
	public static $has_banner = null;

	/**
	 * Store has_breadcrumb value
	 *
	 * @var null
	 */
	public static $has_breadcrumb = null;

	/**
	 * Store layout value
	 *
	 * @var string
	 */
	public static $banner_image = '';

	/**
	 * Store banner_height value
	 *
	 * @var string
	 */
	public static $banner_height = '';

	/**
	 * Store header_width value
	 *
	 * @var null
	 */
	public static $header_width = null;

	/**
	 * Store menu_alignment value
	 *
	 * @var null
	 */
	public static $menu_alignment = null;

	/**
	 * Store padding_top value
	 *
	 * @var null
	 */
	public static $padding_top = null;

	/**
	 * Store padding_bottom value
	 *
	 * @var null
	 */
	public static $padding_bottom = null;

	/**
	 * Store has_tr_header value
	 *
	 * @var null
	 */
	public static $has_tr_header = null;

	/**
	 * Store has_top_bar value
	 *
	 * @var null
	 */
	public static $has_top_bar = null;

	/**
	 * Store single_style value
	 *
	 * @var null
	 */
	public static $single_style = null;


	/**
	 * Class Constructor
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'set_options' ], 99 );
		add_action( 'customize_preview_init', [ $this, 'set_options' ] );
	}

	/**
	 * Set Customize Options
	 *
	 * @return void
	 */
	public function set_options() {
		$newData  = [];
		$defaults = Customizer::$default_value;
		foreach ( $defaults as $key => $dValue ) {
			if ( isset( $_GET['reset_theme_mod'] ) && 1 == sanitize_text_field( wp_unslash( $_GET['reset_theme_mod'] ) ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
				remove_theme_mod( $key );
				wp_safe_redirect( 'customize.php' );
			}
			$value = isset( $_GET[ $key ] ) ? sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) : get_theme_mod( $key, $dValue ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended

			$newData[ $key ] = $value;
		}
		self::$options = $newData;
	}
}
