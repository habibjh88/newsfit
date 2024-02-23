<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\Newsfit\Api\Customizer\Sections;

use RT\Newsfit\Api\Customizer;
use RTFramework\Customize;
use RT\Newsfit\Traits\LayoutControlsTraits;

/**
 * Customizer class
 */
class LayoutsBlogs extends Customizer {

	use LayoutControlsTraits;

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_blog_layout = 'newsfit_blog_layout_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'    => $this->section_blog_layout,
				'title' => __( 'Blog Layout', 'newsfit' ),
				'panel' => 'rt_layouts_panel',
			]
		);
		Customize::add_controls( $this->section_blog_layout, $this->get_controls() );
	}

	public function get_controls() {
		return $this->get_layout_controls( 'blog' );
	}
}
