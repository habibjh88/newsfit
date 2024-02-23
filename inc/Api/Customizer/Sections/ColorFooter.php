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
class ColorFooter extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_footer_color = 'newsfit_footer_color_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_footer_color,
				'panel'       => 'rt_color_panel',
				'title'       => __( 'Footer Colors', 'newsfit' ),
				'description' => __( 'Newsfit Footer Color Section', 'newsfit' ),
				'priority'    => 8,
			]
		);

		Customize::add_controls( $this->section_footer_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_footer_color_controls',
			[
				'rt_footer_color1'              => [
					'type'  => 'heading',
					'label' => __( 'Main Footer', 'newsfit' ),
				],
				'rt_footer_bg'                  => [
					'type'  => 'color',
					'label' => __( 'Footer Background', 'newsfit' ),
				],
				'rt_footer_text_color'          => [
					'type'  => 'color',
					'label' => __( 'Footer Text', 'newsfit' ),
				],
				'rt_footer_link_color'          => [
					'type'  => 'color',
					'label' => __( 'Footer Link', 'newsfit' ),
				],
				'rt_footer_link_hover_color'    => [
					'type'  => 'color',
					'label' => __( 'Footer Link - Hover', 'newsfit' ),
				],
				'rt_footer_widget_title_color'  => [
					'type'  => 'color',
					'label' => __( 'Widget Title', 'newsfit' ),
				],
				'rt_footer_input_border_color'  => [
					'type'  => 'color',
					'label' => __( 'Input/List/Table Border Color', 'newsfit' ),
				],
				'rt_footer_copyright_color1'    => [
					'type'  => 'heading',
					'label' => __( 'Copyright Area', 'newsfit' ),
				],
				'rt_copyright_bg'               => [
					'type'  => 'color',
					'label' => __( 'Copyright Background', 'newsfit' ),
				],
				'rt_copyright_text_color'       => [
					'type'  => 'color',
					'label' => __( 'Copyright Text', 'newsfit' ),
				],
				'rt_copyright_link_color'       => [
					'type'  => 'color',
					'label' => __( 'Copyright Link', 'newsfit' ),
				],
				'rt_copyright_link_hover_color' => [
					'type'  => 'color',
					'label' => __( 'Copyright Link - Hover', 'newsfit' ),
				],
			]
		);
	}
}
