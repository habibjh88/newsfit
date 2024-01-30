<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer\Sections;

use RT\NewsFit\Api\Customizer;
use RTFramework\Customize;
use RT\NewsFit\Traits\LayoutControlsTraits;

/**
 * Customizer class
 */
class LayoutsWooArchive extends Customizer {

	use LayoutControlsTraits;

	protected string $section_woocommerce_archive_layout = 'newsfit_woocommerce_archive_layout_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'    => $this->section_woocommerce_archive_layout,
			'title' => __( 'Woocommerce Archive', 'newsfit' ),
			'panel' => 'rt_layouts_panel',
		] );
		Customize::add_controls( $this->section_woocommerce_archive_layout, $this->get_controls() );
	}

	public function get_controls(): array {
		return $this->get_layout_controls( 'woo_archive' );
	}

}
