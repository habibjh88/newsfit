<?php

namespace RT\NewsFit\Setup;

use RT\NewsFit\Traits\SingletonTraits;

/**
 * Menus
 */
class Menus {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'menus' ] );
	}

	public function menus() {
		/*
			Register all your menus here
		*/
		register_nav_menus( [
			'primary' => esc_html__( 'Primary', 'newsfit' ),
			'topbar'  => esc_html__( 'Topbar Menu', 'newsfit' ),
			'footer'  => esc_html__( 'Footer Menu', 'newsfit' ),
		] );
	}
}
