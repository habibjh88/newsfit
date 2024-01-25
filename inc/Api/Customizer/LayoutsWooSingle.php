<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer;

use RT\NewsFit\Api\Customizer;
use RTFramework\Customize;
use RT\NewsFit\Traits\LayoutControlsTraits;

/**
 * Customizer class
 */
class LayoutsWooSingle extends Customizer {

	use LayoutControlsTraits;

	protected string $section_woocommerce_single_layout = 'newsfit_woocommerce_single_layout_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {

		Customize::add_section( [
			'id'    => $this->section_woocommerce_single_layout,
			'title' => __( 'Woocommerce Single', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );
		Customize::add_controls( $this->section_woocommerce_single_layout, $this->get_controls() );
	}

	public function get_controls(): array {
		return $this->get_layout_controls( 'woo_single' );
	}

}
