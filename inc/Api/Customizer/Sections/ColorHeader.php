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
class ColorHeader extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_header_color = 'newsfit_header_color_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {

		Customize::add_section(
			[
				'id'          => $this->section_header_color,
				'panel'       => 'rt_color_panel',
				'title'       => __( 'Header Colors', 'newsfit' ),
				'description' => __( 'Newsfit Header Color Section', 'newsfit' ),
				'priority'    => 4,
			]
		);

		Customize::add_controls( $this->section_header_color, $this->get_controls() );
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

				'rt_menu_heading1'        => [
					'type'  => 'heading',
					'label' => __( 'Default Menu', 'newsfit' ),
				],

				'rt_menu_color'           => [
					'type'  => 'alfa_color',
					'label' => __( 'Menu Color', 'newsfit' ),
				],

				'rt_menu_active_color'    => [
					'type'  => 'alfa_color',
					'label' => __( 'Menu Hover & Active Color', 'newsfit' ),
				],

				'rt_menu_bg_color'        => [
					'type'  => 'alfa_color',
					'label' => __( 'Menu Background Color', 'newsfit' ),
				],

				'rt_menu_heading2'        => [
					'type'  => 'heading',
					'label' => __( 'Transparent Menu', 'newsfit' ),
				],

				'rt_tr_menu_color'        => [
					'type'  => 'alfa_color',
					'label' => __( 'TR Menu Color', 'newsfit' ),
				],

				'rt_tr_menu_active_color' => [
					'type'  => 'alfa_color',
					'label' => __( 'TR Menu Hover & Active Color', 'newsfit' ),
				],

				'rt_menu_heading4'        => [
					'type'  => 'heading',
					'label' => __( 'Others Style', 'newsfit' ),
				],

				'rt_menu_border_color'    => [
					'type'  => 'alfa_color',
					'label' => __( 'Menu Border Color', 'newsfit' ),
				],

			]
		);
	}
}
