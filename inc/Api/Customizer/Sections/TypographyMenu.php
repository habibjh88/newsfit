<?php
/**
 * Theme Customizer - Menu Typography
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer\Sections;

use RT\NewsFit\Api\Customizer;
use RTFramework\Customize;

/**
 * Customizer class
 */
class TypographyMenu extends Customizer {

	protected string $section_id = 'newsfit_menu_typo_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_id,
			'title'       => __( 'Menu Typography', 'newsfit' ),
			'description' => __( 'NewsFit Menu Typography Section', 'newsfit' ),
			'panel'       => 'rt_typography_panel',
			'priority'    => 3
		] );

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'newsfit_menu_typo_section', [

			'rt_menu_typo' => [
				'type'    => 'typography',
				'label'   => __( 'Menu Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => 'IBM Plex Sans',
						'regularweight' => 'normal',
						'size'          => '16',
						'lineheight'    => '22',
					]
				)
			],

		] );

	}

}
