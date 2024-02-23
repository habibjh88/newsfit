<?php
/**
 * Theme Customizer - Body Typography
 *
 * @package newsfit
 */

namespace RT\Newsfit\Api\Customizer\Sections;

use RT\Newsfit\Api\Customizer;
use RTFramework\Customize;

/**
 * Customizer class
 */
class TypographyBody extends Customizer {

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_body_typo_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'title'       => __( 'Body Typography', 'newsfit' ),
				'description' => __( 'Newsfit Body Typography Section', 'newsfit' ),
				'panel'       => 'rt_typography_panel',
				'priority'    => 1,
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
			'newsfit_body_typo_section',
			[

				'rt_body_typo' => [
					'type'    => 'typography',
					'label'   => __( 'Body Typography', 'newsfit' ),
					'default' => wp_json_encode(
						[
							'font'          => 'IBM Plex Sans',
							'regularweight' => 'normal',
							'size'          => '16',
							'lineheight'    => '26',
						]
					),
				],

			]
		);
	}
}
