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
class Blog extends Customizer {

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_blog_section';


	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'title'       => __( 'Blog Archive', 'newsfit' ),
				'description' => __( 'Newsfit Blog Section', 'newsfit' ),
				'priority'    => 25,
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
			'newsfit_blog_controls',
			[
				'rt_blog_style'              => [
					'type'        => 'select',
					'label'       => __( 'Blog Style', 'newsfit' ),
					'description' => __( 'It will affected on all archive page.', 'newsfit' ),
					'default'     => 'grid',
					'choices'     => [
						'grid' => __( 'Grid', 'newsfit' ),
						'list' => __( 'List', 'newsfit' ),
					],
				],

				'rt_blog_column'             => [
					'type'        => 'select',
					'label'       => __( 'Grid Column', 'newsfit' ),
					'description' => __( 'This option works only for large device', 'newsfit' ),
					'default'     => 'default',
					'choices'     => [
						'default'   => __( 'Default From Theme', 'newsfit' ),
						'col-lg-12' => __( '1 Column', 'newsfit' ),
						'col-lg-6'  => __( '2 Column', 'newsfit' ),
						'col-lg-4'  => __( '3 Column', 'newsfit' ),
						'col-lg-3'  => __( '4 Column', 'newsfit' ),
					],
				],

				'rt_excerpt_limit'           => [
					'type'    => 'text',
					'label'   => __( 'Content Limit', 'newsfit' ),
					'default' => '30',
				],

				'rt_meta_heading'            => [
					'type'  => 'heading',
					'label' => __( 'Post Meta Settings', 'newsfit' ),
				],

				'rt_blog_meta_style'         => [
					'type'    => 'select',
					'label'   => __( 'Meta Style', 'newsfit' ),
					'default' => 'meta-style-default',
					'choices' => Fns::meta_style(),
				],

				'rt_single_above_meta_style' => [
					'type'    => 'select',
					'label'   => __( 'Title Above Meta Style', 'newsfit' ),
					'default' => 'meta-style-dash',
					'choices' => Fns::meta_style( [ 'meta-style-dash-bg', 'meta-style-pipe' ] ),
				],

				'rt_blog_meta'               => [
					'type'        => 'select2',
					'label'       => __( 'Choose Meta', 'newsfit' ),
					'description' => __( 'You can sort meta by drag and drop', 'newsfit' ),
					'placeholder' => __( 'Choose Meta', 'newsfit' ),
					'multiselect' => true,
					'default'     => 'author,date,category,tag,comment',
					'choices'     => Fns::blog_meta_list(),
				],

				'rt_visibility'              => [
					'type'  => 'heading',
					'label' => __( 'Visibility Section', 'newsfit' ),
				],

				'rt_meta_visibility'         => [
					'type'    => 'switch',
					'label'   => __( 'Meta Visibility', 'newsfit' ),
					'default' => 1,
				],

				'rt_blog_above_meta'         => [
					'type'  => 'switch',
					'label' => __( 'Title Above Meta Visibility', 'newsfit' ),
				],

				'rt_meta_icon'               => [
					'type'    => 'switch',
					'label'   => __( 'Meta Icons ?', 'newsfit' ),
					'default' => 0,
				],

				'rt_meta_user_avatar'        => [
					'type'      => 'switch',
					'label'     => __( 'Meta User Avatar ?', 'newsfit' ),
					'default'   => 0,
					'condition' => [ 'rt_meta_icon' ],
				],

				'rt_blog_content'            => [
					'type'    => 'switch',
					'label'   => __( 'Entry Content Visibility', 'newsfit' ),
					'default' => 1,
				],

				'rt_blog_footer'             => [
					'type'    => 'switch',
					'label'   => __( 'Entry Footer Visibility', 'newsfit' ),
					'default' => 1,
				],

			]
		);
	}
}
