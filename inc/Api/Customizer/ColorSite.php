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
class ColorSite extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_site_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_site_color_controls', [

			'rt_site_color1' => [
				'type'    => 'heading',
				'label'   => __( 'Site Ascent Color', 'newsfit' ),
			],
			'rt_primary_color' => [
				'type'    => 'color',
				'label'   => __( 'Primary Color', 'newsfit' ),
				'default' => '#007BFF'
			],

			'rt_primary_dark_color' => [
				'type'    => 'color',
				'label'   => __( 'Primary Dark Color', 'newsfit' ),
				'default' => '#091EF6'
			],

			'rt_primary_light_color' => [
				'type'    => 'color',
				'label'   => __( 'Primary Light Color', 'newsfit' ),
				'default' => '#4AA2FF'
			],

			'rt_color_separator2' => [
				'type' => 'separator',
			],

			'rt_secondary_color' => [
				'type'    => 'color',
				'label'   => __( 'Secondary Color', 'newsfit' ),
				'default' => '#131619'
			],

			'rt_site_color2' => [
				'type'    => 'heading',
				'label'   => __( 'Others Color', 'newsfit' ),
			],

			'rt_body_color' => [
				'type'    => 'color',
				'label'   => __( 'Body Color', 'newsfit' ),
				'default' => '#3D3E41'
			],

			'rt_title_color' => [
				'type'    => 'color',
				'label'   => __( 'Title Color', 'newsfit' ),
				'default' => '#161D25'
			],

			'rt_meta_color' => [
				'type'    => 'color',
				'label'   => __( 'Meta Color', 'newsfit' ),
				'default' => '#808993'
			],

			'rt_gray20_color' => [
				'type'    => 'color',
				'label'   => __( 'Gray # 1', 'newsfit' ),
				'default' => '#E6E6E6'
			],

			'rt_gray40_color' => [
				'type'    => 'color',
				'label'   => __( 'Gray # 2', 'newsfit' ),
				'default' => '#D0D0D0'
			],

		] );


	}

}
