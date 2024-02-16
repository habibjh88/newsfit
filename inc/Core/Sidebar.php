<?php

namespace RT\Newsfit\Core;

use RT\Newsfit\Helpers\Constants;
use RT\Newsfit\Traits\SingletonTraits;

/**
 * Sidebar.
 */
class Sidebar {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
	}

	/**
	 * All sidebar lists
	 * @return mixed|null
	 */
	public static function sidebar_lists() {
		$sidebar_lists = [
			'rt-sidebar'        => [
				'name'  => 'Main Sidebar',
				'class' => 'rt-sidebar'
			],
			'rt-single-sidebar' => [
				'name'  => 'Single Sidebar',
				'class' => 'rt-single-sidebar'
			],
			'rt-footer-sidebar' => [
				'name'  => 'Footer Sidebar',
				'class' => 'footer-sidebar col-lg-3 col-md-6',
			],
		];
		if ( class_exists( 'WooCommerce' ) ) {
			$sidebar_lists['rt-woo-archive-sidebar'] = [
				'name'  => 'WooCommerce Archive Sidebar',
				'class' => 'woo-archive-sidebar',
			];
			$sidebar_lists['rt-woo-single-sidebar']  = [
				'name'  => 'WooCommerce Single Sidebar',
				'class' => 'woo-single-sidebar',
			];
		}

		return apply_filters( 'newsfit_sidebar_lists', $sidebar_lists );
	}

	/**
	 * Define the sidebar
	 * @return void
	 */
	public function widgets_init() {

		foreach ( self::sidebar_lists() as $id => $sidebar ) {

			$classes = $sidebar['class'] ?? '';

			register_sidebar( [
				'id'            => $id,
				'name'          => sprintf( esc_html_x( '%s', 'Widget Name', 'newsfit' ), $sidebar['name'] ),
				'description'   => $sidebar['description'] ?? '',
				'before_widget' => '<section id="%1$s" class="widget ' . $classes . ' %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

		}
	}
}
