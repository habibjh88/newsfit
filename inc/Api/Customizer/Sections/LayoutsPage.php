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
class LayoutsPage extends Customizer {

	use LayoutControlsTraits;

	/**
	 * Section ID
	 *
	 * @var string
	 */

	protected string $section_id = 'newsfit_page_layout_section';


	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'    => $this->section_id,
				'title' => __( 'Page Layout', 'newsfit' ),
				'panel' => 'rt_layouts_panel',
			]
		);

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	public function get_controls() {
		return $this->get_layout_controls( 'page' );
	}
}
