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
class HeaderTopbar extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_topbar, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_topbar_controls', [

			'rt_top_bar' => [
				'type'    => 'switch',
				'label'   => __( 'Topbar Visibility', 'newsfit' ),
				'default' => 1
			],

			'rt_topbar_style' => [
				'type'      => 'image_select',
				'label'     => __( 'Topbar Style', 'newsfit' ),
				'default'   => '1',
				'choices'   => newsfit_header_presets(),
				'condition' => [ 'top_bar' ]
			],

		] );

	}

}
