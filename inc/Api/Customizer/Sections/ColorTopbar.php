<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\Newsfit\Api\Customizer\Sections;

use RT\Newsfit\Api\Customizer;
use RTFramework\Customize;

/**
 * Customizer class
 */
class ColorTopbar extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_topbar_color_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'panel'       => 'rt_color_panel',
				'title'       => __( 'Topbar Colors', 'newsfit' ),
				'description' => __( 'Newsfit Topbar Color Section', 'newsfit' ),
				'priority'    => 3,
			]
		);

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_header_color_controls',
			[

				'rt_topbar_color'        => [
					'type'  => 'alfa_color',
					'label' => __( 'Topbar Color', 'newsfit' ),
				],

				'rt_topbar_active_color' => [
					'type'  => 'alfa_color',
					'label' => __( 'Hover & Active Color', 'newsfit' ),
				],

				'rt_topbar_bg_color'     => [
					'type'  => 'alfa_color',
					'label' => __( 'Topbar Background', 'newsfit' ),
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

			]
		);
	}
}
