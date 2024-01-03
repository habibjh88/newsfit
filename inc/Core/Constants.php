<?php

namespace RT\NewsFit\Core;

use RT\NewsFit\Traits\SingletonTraits;

class Constants {
	use SingletonTraits;

	public static array $sidebar = [];

	public function __construct() {
		self::$sidebar = self::sidebar_lists();
	}

	public static function sidebar_lists() {
		$sidebar_lists = [
			'rt-sidebar'        => [
				'name'  => 'Sidebar',
				'class' => 'rt-sidebar'
			],
			'rt-footer-sidebar' => [
				'name'  => 'Footer Sidebar',
				'class' => 'footer-sidebar',
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
}

