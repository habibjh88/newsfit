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
class LayoutsWooSingle extends Customizer {

	use LayoutControlsTraits;

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_woocommerce_single_layout = 'newsfit_woocommerce_single_layout_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {

		Customize::add_section(
			[
				'id'    => $this->section_woocommerce_single_layout,
				'title' => __( 'Woocommerce Single', 'newsfit' ),
				'panel' => 'rt_layouts_panel',
			]
		);
		Customize::add_controls( $this->section_woocommerce_single_layout, $this->get_controls() );
	}

	public function get_controls() {
		return $this->get_layout_controls( 'woo_single' );
	}
}
