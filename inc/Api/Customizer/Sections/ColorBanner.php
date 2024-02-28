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
class ColorBanner extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_banner_color_section';

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
				'title'       => __( 'Banner / Breadcrumb Colors', 'newsfit' ),
				'description' => __( 'Newsfit Banner Color Section', 'newsfit' ),
				'priority'    => 6,
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
			'newsfit_site_color_controls',
			[

				'rt_banner_bg'         => [
					'type'  => 'color',
					'label' => __( 'Banner Background', 'newsfit' ),
				],

				'rt_banner_overlay'    => [
					'type'    => 'alfa_color',
					'default' => 'rgba(3,6,60,0.60)',
					'label'   => __( 'Banner Overlay', 'newsfit' ),
				],

				'rt_breadcrumb_color'  => [
					'type'  => 'color',
					'label' => __( 'Link Color', 'newsfit' ),
				],

				'rt_breadcrumb_active' => [
					'type'  => 'color',
					'label' => __( 'Link Active Color', 'newsfit' ),
				],

			]
		);
	}
}
