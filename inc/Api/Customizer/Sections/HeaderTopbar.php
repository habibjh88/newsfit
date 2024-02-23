<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\Newsfit\Api\Customizer\Sections;

use RT\Newsfit\Api\Customizer;
use RT\Newsfit\Helpers\Fns;
use RTFramework\Customize;

/**
 * Customizer class
 */
class HeaderTopbar extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_topbar = 'newsfit_topbar_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_topbar,
				'panel'       => 'rt_header_panel',
				'title'       => __( 'Header Topbar', 'newsfit' ),
				'description' => __( 'Newsfit Topbar Section', 'newsfit' ),
				'priority'    => 1,
			]
		);

		Customize::add_controls( $this->section_topbar, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_topbar_controls',
			[

				'rt_top_bar'        => [
					'type'      => 'switch',
					'label'     => __( 'Topbar Visibility', 'newsfit' ),
					'default'   => 1,
					'edit-link' => '.topbar-row',
				],

				'rt_topbar_style'   => [
					'type'      => 'image_select',
					'label'     => __( 'Topbar Style', 'newsfit' ),
					'default'   => '1',
					'choices'   => Fns::image_placeholder( 'menu', 1 ),
					'condition' => [ 'top_bar' ],
				],

				'rt_top_bar_border' => [
					'type'    => 'switch',
					'label'   => __( 'Topbar Border', 'newsfit' ),
					'default' => 1,
				],

			]
		);
	}
}
