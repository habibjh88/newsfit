<?php

namespace RT\Newsfit\Helpers;

use RT\Newsfit\Core\Sidebar;
use RT\Newsfit\Options\Opt;

/**
 * Extras.
 */
class Fns {

	/**
	 * Filters whether post thumbnail can be displayed.
	 *
	 * @param bool $show_post_thumbnail Whether to show post thumbnail.
	 *
	 */
	public static function can_show_post_thumbnail() {
		return apply_filters(
			'newsfit_can_show_post_thumbnail',
			! post_password_required() && ! is_attachment() && has_post_thumbnail()
		);
	}

	public static function html( $html, $checked = true ) {
		$allowed_html = [
			'a'      => [
				'href'   => [],
				'title'  => [],
				'class'  => [],
				'target' => [],
			],
			'br'     => [],
			'span'   => [
				'class' => [],
				'id'    => [],
			],
			'em'     => [],
			'strong' => [],
			'i'      => [
				'class' => []
			],
			'iframe' => [
				'class'                 => [],
				'id'                    => [],
				'name'                  => [],
				'src'                   => [],
				'title'                 => [],
				'frameBorder'           => [],
				'width'                 => [],
				'height'                => [],
				'scrolling'             => [],
				'allowvr'               => [],
				'allow'                 => [],
				'allowFullScreen'       => [],
				'webkitallowfullscreen' => [],
				'mozallowfullscreen'    => [],
				'loading'               => [],
			],
		];

		if ( $checked ) {
			return wp_kses( $html, $allowed_html );
		} else {
			return $html;
		}
	}

	/**
	 * Sanitize Text Field
	 *
	 * @param $data
	 * @param $default
	 * @param $mode
	 *
	 * @return mixed|string
	 */
	public static function sanitize( $data, $default = '', $mode = '' ) {
		if ( 'html' === $mode ) {
			return ! empty( $data ) ? self::html( $data ) : $default;
		}

		return ! empty( $data ) ? sanitize_text_field( $data ) : $default;
	}

	/**
	 * Social icon for the site
	 * @return mixed|null
	 */
	public static function get_socials() {
		return apply_filters( 'newsfit_socials_icon', [
			'facebook'  => [
				'title' => __( 'Facebook', 'newsfit' ),
				'url'   => newsfit_option( 'facebook' ),
			],
			'twitter'   => [
				'title' => __( 'Twitter', 'newsfit' ),
				'url'   => newsfit_option( 'twitter' ),
			],
			'linkedin'  => [
				'title' => __( 'Linkedin', 'newsfit' ),
				'url'   => newsfit_option( 'linkedin' ),
			],
			'youtube'   => [
				'title' => __( 'Youtube', 'newsfit' ),
				'url'   => newsfit_option( 'youtube' ),
			],
			'pinterest' => [
				'title' => __( 'Pinterest', 'newsfit' ),
				'url'   => newsfit_option( 'pinterest' ),
			],
			'instagram' => [
				'title' => __( 'Instagram', 'newsfit' ),
				'url'   => newsfit_option( 'instagram' ),
			],
			'skype'     => [
				'title' => __( 'Skype', 'newsfit' ),
				'url'   => newsfit_option( 'skype' ),
			],
		] );

	}


	/**
	 * Get image presets
	 *
	 * @param $name
	 * @param int $total
	 * @param string $type
	 *
	 * @return array
	 */
	public static function image_placeholder( $name, $total = 1, $type = 'svg' ) {
		$presets = [];
		for ( $i = 1; $i <= $total; $i ++ ) {
			$image_name    = "$name-$i.$type";
			$presets[ $i ] = [
				'image' => newsfit_get_img( $image_name ),
				'name'  => __( 'Style', 'newsfit' ) . ' ' . $i,
			];
		}

		return apply_filters( 'newsfit_image_placeholder', $presets );
	}


	/**
	 * Convert HEX to RGB color
	 *
	 * @param $hex
	 *
	 * @return string
	 */
	public static function hex2rgb( $hex ) {
		$hex = str_replace( "#", "", $hex );
		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = "$r, $g, $b";

		return $rgb;
	}

	/**
	 * Modify Color
	 * Add positive or negative $steps. Ex: 30, -50 etc
	 *
	 * @param $hex
	 * @param $steps
	 *
	 * @return string
	 */
	public static function modify_color( $hex, $steps ) {
		$steps = max( - 255, min( 255, $steps ) );
		// Format the hex color string
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}
		// Get decimal values
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		// Adjust number of steps and keep it inside 0 to 255
		$r     = max( 0, min( 255, $r + $steps ) );
		$g     = max( 0, min( 255, $g + $steps ) );
		$b     = max( 0, min( 255, $b + $steps ) );
		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}


	/**
	 * Return Sidebar Column
	 * @return string
	 */
	public static function sidebar_columns() {
		$columns = "col-md-4";

		return $columns;
	}

	/**
	 * Return content columns
	 * @return string
	 */
	public static function content_columns( $full_width_col = 'col-md-12' ) {
		$sidebar = Opt::$sidebar === 'default' ? Fns::sidebar( 'main' ) : Opt::$sidebar;
		$columns = ! is_active_sidebar( $sidebar ) ? $full_width_col : 'col-md-8';
		if ( Opt::$layout === 'full-width' ) {
			$columns = $full_width_col;
		}

		return $columns;
	}

	public static function single_content_colums() {
		$default_sitebar = is_active_sidebar( Fns::sidebar( 'single' ) ) ? Fns::sidebar( 'single' ) : Fns::sidebar( 'main' );
		$sidebar         = Opt::$sidebar === 'default' ? $default_sitebar : Opt::$sidebar;
		$columns         = is_active_sidebar( $sidebar ) ? "col-md-8" : "col-md-10 col-md-offset-1";

		if ( Opt::$layout === 'full-width' ) {
			$columns = "col-md-10 col-md-offset-1";
		}

		return $columns;
	}


	/**
	 * Get blog colum
	 * @return mixed|string
	 */
	public static function blog_column() {
		if ( ! empty( $_REQUEST['column'] ) ) {
			return sanitize_text_field( $_REQUEST['column'] );
		}
		$blog_colum_opt = newsfit_option( 'rt_blog_column' ) !== 'default' ? newsfit_option( 'rt_blog_column' ) : '';
		$blog_sidebar   = Opt::$sidebar === 'default' ? Fns::sidebar( 'main' ) : Opt::$sidebar;
		$blog_layout    = Opt::$layout ?? 'right-sidebar';

		$output = 'col-lg-4';
		if ( $blog_colum_opt ) {
			$output = $blog_colum_opt;
		} elseif ( in_array( $blog_layout, [ 'left-sidebar', 'right-sidebar' ] ) && is_active_sidebar( $blog_sidebar ) ) {
			$output = 'col-lg-6';
		}

		return $output;
	}

	/**
	 * Get all post type
	 * @return array
	 */
	public static function get_post_types() {
		$post_types = get_post_types(
			[
				'public' => true,
			],
			'objects'
		);
		$post_types = wp_list_pluck( $post_types, 'label', 'name' );

		$exclude = apply_filters( 'newsfit_exclude_post_type', [ 'attachment', 'revision', 'nav_menu_item', 'elementor_library', 'tpg_builder', 'e-landing-page', 'elementor-newsfit' ] );

		foreach ( $exclude as $ex ) {
			unset( $post_types[ $ex ] );
		}

		return $post_types;
	}

	/**
	 * Meta Style
	 * @return array
	 */
	public static function meta_style( $exclude = [] ) {
		$meta_style = [
			'meta-style-default' => __( 'Default From Theme', 'newsfit' ),
			'meta-style-border'  => __( 'Border Style', 'newsfit' ),
			'meta-style-dash'    => __( 'Before Dash ( — )', 'newsfit' ),
			'meta-style-dash-bg' => __( 'Before Dash with BG ( — )', 'newsfit' ),
			'meta-style-pipe'    => __( 'After Pipe ( | )', 'newsfit' ),
		];

		if ( ! empty( $exclude ) && is_array( $exclude ) ) {
			foreach ( $exclude as $item ) {
				unset( $meta_style[ $item ] );
			}
		}

		return $meta_style;
	}

	/**
	 * Single Style
	 * @return array
	 */
	public static function single_post_style( $exclude = [] ) {
		$meta_style = [
			'1' => __( 'Style 1 (Default From Theme)', 'newsfit' ),
			'2' => __( 'Style 2 (Full-width Thumbnail)', 'newsfit' ),
			'3' => __( 'Style 3 (Transparent Menu)', 'newsfit' ),
			'4' => __( 'Style 4 (Content over on Thumb)', 'newsfit' ),
		];

		if ( ! empty( $exclude ) && is_array( $exclude ) ) {
			foreach ( $exclude as $item ) {
				unset( $meta_style[ $item ] );
			}
		}

		return $meta_style;
	}

	/**
	 * Blog Meta Style
	 * @return array
	 */
	public static function blog_meta_list() {
		return [
			'author'   => __( 'Author', 'skyrocket' ),
			'date'     => __( 'Date', 'skyrocket' ),
			'category' => __( 'Category', 'skyrocket' ),
			'tag'      => __( 'Tag', 'skyrocket' ),
			'comment'  => __( 'Comment', 'skyrocket' ),
		];
	}

	public static function is_single_fullwidth() {
		if ( in_array( Opt::$single_style, [ 'rt-single-top-thumb', 'rt-single-transparent', 'rt-single-content-on-thumb' ] ) ) {
			return true;
		}

		return false;
	}


	public static function single_meta_lists() {
		$meta_list = newsfit_option( 'rt_single_meta', '', true );
		if ( newsfit_option( 'rt_single_above_cat_visibility' ) ) {
			$category_index = array_search( 'category', $meta_list );
			unset( $meta_list[ $category_index ] );
		}

		return $meta_list;
	}

	/**
	 * Class list
	 *
	 * @param $clsses
	 *
	 * @return string
	 */
	public static function class_list( $clsses ): string {
		return implode( ' ', $clsses );
	}

	public static function sidebar( $id = '' ) {
		$sidebar_lists = [
			'main'   => [
				'id'    => 'rt-sidebar',
				'name'  => __( 'Main Sidebar', 'newsfit' ),
				'class' => 'rt-sidebar'
			],
			'single' => [
				'id'    => 'rt-single-sidebar',
				'name'  => __( 'Single Sidebar', 'newsfit' ),
				'class' => 'rt-single-sidebar'
			],
			'footer' => [
				'id'    => 'rt-footer-sidebar',
				'name'  => 'Footer Sidebar',
				'class' => 'footer-sidebar col-lg-3 col-md-6',
			],
		];
		if ( class_exists( 'WooCommerce' ) ) {
			$sidebar_lists['woo-archive'] = [
				'id'    => 'rt-woo-archive-sidebar',
				'name'  => __( 'WooCommerce Archive Sidebar', 'newsfit' ),
				'class' => 'woo-archive-sidebar',
			];
			$sidebar_lists['woo-single']  = [
				'id'    => 'rt-woo-single-sidebar',
				'name'  => __( 'WooCommerce Single Sidebar', 'newsfit' ),
				'class' => 'woo-single-sidebar',
			];
		}
		$sidebar_lists = apply_filters( 'newsfit_sidebar_lists', $sidebar_lists );
		if ( ! $id ) {
			return $sidebar_lists;
		}
		if ( isset( $sidebar_lists[ $id ] ) ) {
			return $sidebar_lists[ $id ]['id'];
		}

		return [];
	}

	/**
	 * Get Sidebar lists
	 * @return array
	 */
	public static function sidebar_lists() {
		$sidebar_fields            = [];
		$sidebar_fields['default'] = esc_html__( 'Choose Sidebar', 'newsfit' );

		foreach ( self::sidebar() as $id => $sidebar ) {
			$sidebar_fields[ $id ] = $sidebar['name'];
		}


		return $sidebar_fields;
	}
}
