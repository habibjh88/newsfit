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
class Banner extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_breadcrumb_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'title'       => __( 'Banner - Breadcrumb', 'newsfit' ),
				'description' => __( 'Newsfit Banner Section', 'newsfit' ),
				'priority'    => 23,
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
			'newsfit_topbar_controls',
			[

				'rt_banner'            => [
					'type'    => 'switch',
					'label'   => __( 'Banner Visibility', 'newsfit' ),
					'default' => 0,
				],

				'rt_banner_style'      => [
					'type'      => 'select',
					'label'     => __( 'Breadcrumb Style', 'newsfit' ),
					'default'   => 'style-default',
					'choices'   => [
						'style-default' => __( 'Default from theme', 'newsfit' ),
						'style-left'    => __( 'Text Left', 'newsfit' ),
						'style-center'  => __( 'Text Center', 'newsfit' ),
						'style-right'   => __( 'Text Right', 'newsfit' ),
					],
					'condition' => [ 'rt_banner' ],
				],

				'rt_banner_image'      => [
					'type'         => 'image',
					'label'        => __( 'Banner Image', 'newsfit' ),
					'description'  => __( 'Upload Banner Image', 'newsfit' ),
					'button_label' => __( 'Banner', 'newsfit' ),
					'condition'    => [ 'rt_banner' ],
				],

				'rt_banner_image_attr' => [
					'type'      => 'bg_attribute',
					'condition' => [ 'rt_banner' ],
					'default'   => wp_json_encode(
						[
							'position'   => 'center center',
							'attachment' => 'scroll',
							'repeat'     => 'no-repeat',
							'size'       => 'cover',
						]
					),
				],

				'rt_banner_height'     => [
					'type'        => 'number',
					'label'       => __( 'Banner Height (px)', 'newsfit' ),
					'description' => __( 'Height can be differ for transparent header.', 'newsfit' ),
					'default'     => '',
					'condition'   => [ 'rt_banner' ],
				],

				'rt_banner1'           => [
					'type'      => 'heading',
					'label'     => __( 'Breadcrumb Settings', 'newsfit' ),
					'condition' => [ 'rt_banner' ],
				],

				'rt_breadcrumb'        => [
					'type'      => 'switch',
					'label'     => __( 'Banner Content (Breadcrumb) Visibility', 'newsfit' ),
					'default'   => 1,
					'condition' => [ 'rt_banner' ],
				],

				'rt_breadcrumb_border' => [
					'type'      => 'switch',
					'label'     => __( 'Breadcrumb Border', 'newsfit' ),
					'default'   => 1,
					'condition' => [ 'rt_banner' ],
				],

			]
		);
	}
}
