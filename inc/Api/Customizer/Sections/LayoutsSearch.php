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
 * LayoutsSearch class
 */
class LayoutsSearch extends Customizer {

	use LayoutControlsTraits;

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_search_layout_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'    => $this->section_id,
				'title' => __( 'Search Layout', 'newsfit' ),
				'panel' => 'rt_layouts_panel',
			]
		);

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return mixed|null
	 */
	public function get_controls() {
		$options_val = $this->get_layout_controls( 'search' );
		return $options_val;
	}
}
