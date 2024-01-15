<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer;

use RT\NewsFit\Api\Customizer;
use RTFramework\Customize;

/**
 * Customizer class
 */
class Blog extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_blog, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {
		return apply_filters( 'newsfit_blog_controls', [

			'newsfit_blog_meta_order1' => [
				'type'    => 'repeater',
				'label'   => __( 'Meta Order', 'newsfit' ),
				'default' => 'one, two, three, four',
				'use_as'  => 'sort', //'sort','repeater'
			],

			'newsfit_blog_meta_order2' => [
				'type'    => 'repeater',
				'label'   => __( 'Meta Order', 'newsfit' ),
				'default' => 'one, two, three, four',
//				'use_as'  => 'repeater', //'sort','repeater'
			],

		] );
	}


}
