<?php

namespace RT\NewsFit\Custom;

use RT\NewsFit\Traits\SingletonTraits;

/**
 * Custom
 * use it to write your custom functions.
 */
class PostTypes {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'custom_post_type' ], 10, 4 );
		add_action( 'after_switch_theme', [ $this, 'rewrite_flush' ] );
	}

	/**
	 * Create Custom Post Types
	 * @return The registered post type object, or an error object
	 */
	public function custom_post_type() {

	}

	/**
	 * Flush Rewrite on CPT activation
	 * @return empty
	 */
	public function rewrite_flush() {
		// Flush the rewrite rules only on theme activation
		flush_rewrite_rules();
	}
}
