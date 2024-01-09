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
class ColorTopbar extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_topbar_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_header_color_controls', [


			'rt_topbar_color' => [
				'type'    => 'alfa_color',
				'label'   => __( 'Topbar Color', 'newsfit' ),
			],

			'rt_topbar_active_color' => [
				'type'    => 'alfa_color',
				'label'   => __( 'Hover & Active Color', 'newsfit' ),
			],

			'rt_topbar_bg_color' => [
				'type'    => 'alfa_color',
				'label'   => __( 'Topbar Background', 'newsfit' ),
			],

			/*
			 * 'rt_topbar_heading4' => [
				'type'    => 'heading',
				'label'   => __( 'Others Style', 'newsfit' ),
			],

			'rt_topbar_border_color' => [
				'type'    => 'alfa_color',
				'label'   => __( 'Menu Border Color', 'newsfit' ),
			],
			*/


		] );


	}

}
