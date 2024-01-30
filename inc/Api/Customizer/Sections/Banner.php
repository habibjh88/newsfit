<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer\Sections;

use RT\NewsFit\Api\Customizer;
use RT\NewsFit\Helpers\Fns;
use RTFramework\Customize;

/**
 * Customizer class
 */
class Banner extends Customizer {

	protected string $section_breadcrumb = 'newsfit_breadcrumb_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'          => $this->section_breadcrumb,
			'title'       => __( 'Banner - Breadcrumb', 'newsfit' ),
			'description' => __( 'NewsFit Banner Section', 'newsfit' ),
			'priority'    => 23
		] );

		Customize::add_controls( $this->section_breadcrumb, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_topbar_controls', [

			'rt_banner' => [
				'type'    => 'switch',
				'label'   => __( 'Banner Visibility', 'newsfit' ),
				'default' => 0
			],

			'rt_banner_style' => [
				'type'      => 'image_select',
				'label'     => __( 'Breadcrumb Style', 'newsfit' ),
				'default'   => '1',
				'choices'   => Fns::image_placeholder( 'menu', 1 ),
				'condition' => [ 'rt_banner' ]
			],

			'rt_banner_image' => [
				'type'         => 'image',
				'label'        => __( 'Banner Image', 'newsfit' ),
				'description'  => __( 'Upload Banner Image', 'newsfit' ),
				'button_label' => __( 'Banner', 'newsfit' ),
				'condition'    => [ 'rt_banner' ]
			],

			'rt_banner_image_attr' => [
				'type'      => 'bg_attribute',
				'condition' => [ 'rt_banner' ],
				'default'   => json_encode(
					[
						'position'   => 'center center',
						'attachment' => 'scroll',
						'repeat'     => 'no-repeat',
						'size'       => 'cover',
					]
				)
			],

			'rt_banner_height' => [
				'type'        => 'number',
				'label'       => __( 'Banner Height (px)', 'newsfit' ),
				'description' => __( 'Height can be differ for transparent header.', 'newsfit' ),
				'default'     => '',
				'condition'   => [ 'rt_banner' ]
			],

			'rt_banner1' => [
				'type'      => 'heading',
				'label'     => __( 'Breadcrumb Settings', 'newsfit' ),
				'condition' => [ 'rt_banner' ]
			],

			'rt_breadcrumb' => [
				'type'      => 'switch',
				'label'     => __( 'Banner Content (Breadcrumb) Visibility', 'newsfit' ),
				'default'   => 1,
				'condition' => [ 'rt_banner' ]
			],

			'rt_breadcrumb_border' => [
				'type'      => 'switch',
				'label'     => __( 'Breadcrumb Border', 'newsfit' ),
				'default'   => 1,
				'condition' => [ 'rt_banner' ]
			],

		] );

	}

}
