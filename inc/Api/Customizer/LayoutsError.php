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
class LayoutsError extends Customizer {

	use LayoutControlsTraits;

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_error_layout, $this->get_controls() );
	}

	public function get_controls(): array {
		$options_val = $this->get_layout_controls( 'error' );
		unset( $options_val['error_layout'] );
		unset( $options_val['error__header_style'] );

		return $options_val;
	}

}
