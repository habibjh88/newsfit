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
class Breadcrumb extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_breadcrumb, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_topbar_controls', [

			'rt_breadcrumb' => [
				'type'    => 'switch',
				'label'   => __( 'Topbar Visibility', 'newsfit' ),
				'default' => 1
			],

			'rt_breadcrumb_style' => [
				'type'      => 'image_select',
				'label'     => __( 'Breadcrumb Style', 'newsfit' ),
				'default'   => '1',
				'choices'   => newsfit_header_presets(),
				'condition' => [ 'rt_breadcrumb' ]
			],

		] );

	}

}
