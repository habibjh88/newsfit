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
class General extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_general_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'title'       => __( 'General', 'newsfit' ),
				'description' => __( 'Newsfit General Section', 'newsfit' ),
				'priority'    => 20,
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
			'newsfit_test_controls',
			[
				'rt_container_width'    => [
					'type'        => 'number',
					'label'       => __( 'Container Width', 'newsfit' ),
					'description' => __( 'The default container width is set at 1240px as per the theme style, and you have the flexibility to adjust it as needed. Enter greater than 767px', 'newsfit' ),
				],
				'rt_general_visibility' => [
					'type'  => 'heading',
					'label' => __( 'General Visibility', 'newsfit' ),
				],
				'rt_svg_enable'         => [
					'type'  => 'switch',
					'label' => __( 'Enable SVG Upload', 'newsfit' ),
				],

				'rt_preloader'          => [
					'type'  => 'switch',
					'label' => __( 'Preloader', 'newsfit' ),
				],

				'rt_back_to_top'        => [
					'type'  => 'switch',
					'label' => __( 'Back to Top', 'newsfit' ),
				],

				'rt_remove_admin_bar'   => [
					'type'        => 'switch',
					'label'       => __( 'Remove Admin Bar', 'newsfit' ),
					'description' => __( 'This option not work for administrator role.', 'newsfit' ),
				],

				'rt_social_icon_style'  => [
					'type'    => 'select',
					'label'   => __( 'Social Icon Style', 'newsfit' ),
					'default' => '',
					'choices' => [
						''        => __( 'Default Icon', 'newsfit' ),
						'-square' => __( 'Square Icon', 'newsfit' ),
					],
				],

			]
		);
	}
}
