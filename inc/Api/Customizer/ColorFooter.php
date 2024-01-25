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
class ColorFooter extends Customizer {
	protected string $section_footer_color = 'newsfit_footer_color_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'          => $this->section_footer_color,
			'panel'       => 'rt_color_panel',
			'title'       => __( 'Footer Colors', 'newsfit' ),
			'description' => __( 'NewsFit Footer Color Section', 'newsfit' ),
			'priority'    => 8
		] );

		Customize::add_controls( $this->section_footer_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_footer_color_controls', [
			'rt_footer_color1'           => [
				'type'  => 'heading',
				'label' => __( 'Main Footer', 'newsfit' ),
			],
			'rt_footer_bg'               => [
				'type'  => 'color',
				'label' => __( 'Footer Background', 'newsfit' ),
			],
			'rt_footer_text'             => [
				'type'  => 'color',
				'label' => __( 'Footer Text', 'newsfit' ),
			],
			'rt_footer_link'             => [
				'type'  => 'color',
				'label' => __( 'Footer Link', 'newsfit' ),
			],
			'rt_footer_link_hover'       => [
				'type'  => 'color',
				'label' => __( 'Footer Link - Hover', 'newsfit' ),
			],
			'rt_footer_widget_title'     => [
				'type'  => 'color',
				'label' => __( 'Widget Title', 'newsfit' ),
			],
			'rt_footer_input_border'     => [
				'type'  => 'color',
				'label' => __( 'Input/List/Table Border Color', 'newsfit' ),
			],
			'rt_footer_copyright_color1' => [
				'type'  => 'heading',
				'label' => __( 'Copyright Area', 'newsfit' ),
			],
			'rt_copyright_bg'            => [
				'type'  => 'color',
				'label' => __( 'Copyright Background', 'newsfit' ),
			],
			'rt_copyright_text'          => [
				'type'  => 'color',
				'label' => __( 'Copyright Text', 'newsfit' ),
			],
			'rt_copyright_link'          => [
				'type'  => 'color',
				'label' => __( 'Copyright Link', 'newsfit' ),
			],
			'rt_copyright_link_hover'    => [
				'type'  => 'color',
				'label' => __( 'Copyright Link - Hover', 'newsfit' ),
			],
		] );


	}

}
