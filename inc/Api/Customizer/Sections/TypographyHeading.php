<?php
/**
 * Theme Customizer - Heading Typography
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer\Sections;

use RT\NewsFit\Api\Customizer;
use RTFramework\Customize;

/**
 * Customizer class
 */
class TypographyHeading extends Customizer {

	protected string $section_id = 'newsfit_heading_typo_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'          => $this->section_id,
			'title'       => __( 'Heading Typography', 'newsfit' ),
			'description' => __( 'NewsFit Heading Typography Section', 'newsfit' ),
			'panel'       => 'rt_typography_panel',
			'priority'    => 2
		] );

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_heading_typo_section', [

			'rt_all_heading_typo' => [
				'type'    => 'typography',
				'label'   => __( 'All Headings Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => 'IBM Plex Sans',
						'regularweight' => 'normal',
						'size'          => '16',
						'lineheight'    => '26',
					]
				)
			],

			'rt_heading_h1_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H1 Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'rt_heading_h2_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H2 Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'rt_heading_h3_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H3 Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'rt_heading_h4_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H4 Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'rt_heading_h5_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H5 Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'rt_heading_h6_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H6 Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

		] );

	}

}
