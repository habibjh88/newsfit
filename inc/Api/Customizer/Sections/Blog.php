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
class Blog extends Customizer {

	protected string $section_blog = 'newsfit_blog_section';


	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'          => $this->section_blog,
			'title'       => __( 'Blog Archive', 'newsfit' ),
			'description' => __( 'NewsFit Blog Section', 'newsfit' ),
			'priority'    => 25
		] );

		Customize::add_controls( $this->section_blog, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {
		return apply_filters( 'newsfit_blog_controls', [

			'rt_blog_style' => [
				'type'        => 'select',
				'label'       => __( 'Blog Style', 'newsfit' ),
				'description' => __( 'This option works only for large device', 'newsfit' ),
				'default'     => 'default',
				'choices'     => [
					'default' => __( 'Default From Theme', 'newsfit' ),
					'list'    => __( 'List', 'newsfit' ),
				]
			],

			'rt_blog_column' => [
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
				]
			],


			'rt_excerpt_limit' => [
				'type'    => 'text',
				'label'   => __( 'Content Limit', 'newsfit' ),
				'default' => '30',
			],

			'rt_meta_heading' => [
				'type'  => 'heading',
				'label' => __( 'Post Meta Settings', 'newsfit' ),
			],

			'rt_blog_meta_style' => [
				'type'    => 'select',
				'label'   => __( 'Meta Style', 'newsfit' ),
				'default' => 'meta-style-default',
				'choices' => Fns::meta_style()
			],

			'rt_single_above_meta_style' => [
				'type'    => 'select',
				'label'   => __( 'Title Above Meta Style', 'newsfit' ),
				'default' => 'meta-style-dash',
				'choices' => Fns::meta_style( [ 'meta-style-dash-bg', 'meta-style-pipe' ] )
			],

			'rt_blog_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'newsfit' ),
				'description' => __( 'You can sort meta by drag and drop', 'newsfit' ),
				'placeholder' => __( 'Choose Meta', 'newsfit' ),
				'multiselect' => true,
				'default'     => 'author,date,category,tag,comment',
				'choices'     => Fns::blog_meta_list(),
			],

			'rt_visibility' => [
				'type'  => 'heading',
				'label' => __( 'Visibility Section', 'newsfit' ),
			],

			'rt_meta_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Meta Visibility', 'newsfit' ),
				'default' => 1
			],

			'rt_blog_above_cat_visibility' => [
				'type'  => 'switch',
				'label' => __( 'Title Above Category Visibility', 'newsfit' ),
			],

			'rt_blog_content_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Content Visibility', 'newsfit' ),
				'default' => 1
			],

			'rt_blog_footer_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Footer Visibility', 'newsfit' ),
				'default' => 1
			],

		] );
	}


}
