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
class LayoutsSingle extends Customizer {

	use LayoutControlsTraits;

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_single_layout, $this->get_controls() );
	}

	public function get_controls(): array {
		return $this->get_layout_controls( 'single_post' );
	}

}
