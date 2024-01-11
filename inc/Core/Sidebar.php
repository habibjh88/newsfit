<?php

namespace RT\NewsFit\Core;

use RT\NewsFit\Traits\SingletonTraits;

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

	/*
		Define the sidebar
	*/
	public function widgets_init() {

		foreach ( Constants::$sidebar as $id => $sidebar ) {
			$description = sprintf( esc_html_x( '%s to add all your widgets.', 'Widget Description', 'newsfit' ), $sidebar['name'] );
			if ( ! empty( $sidebar['description'] ) ) {
				$description = sprintf( esc_html_x( '%s', 'Widget Description', 'newsfit' ), $sidebar['description'] );
			}
			$classes = 'widget col-lg-3 col-md-6 ';
			if ( ! empty( $sidebar['class'] ) ) {
				$classes .= $sidebar['class'];
			}
			register_sidebar( [
				'id'            => $id,
				'name'          => sprintf( esc_html_x( '%s', 'Widget Name', 'newsfit' ), $sidebar['name'] ),
				'description'   => $description,
				'before_widget' => '<section id="%1$s" class="' . $classes . ' %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			] );

		}
	}
}
