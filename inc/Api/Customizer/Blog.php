<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer;

use RT\NewsFit\Api\Customizer;
use RT\NewsFit\Helpers\Fns;
use RTFramework\Customize;

/**
 * Customizer class
 */
class Blog extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_blog, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {
		return apply_filters( 'newsfit_blog_controls', [

			'newsfit_blog_style' => [
				'type'        => 'select',
				'label'       => __( 'Blog Style', 'newsfit' ),
				'description' => __( 'This option works only for large device', 'newsfit' ),
				'default'     => 'default',
				'choices'     => [
					'default' => __( 'Default From Theme', 'newsfit' ),
					'list'    => __( 'List', 'newsfit' ),
				]
			],

			'newsfit_blog_column' => [
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


			'newsfit_excerpt_limit' => [
				'type'    => 'text',
				'label'   => __( 'Content Limit', 'newsfit' ),
				'default' => '30',
			],

			'newsfit_author_prefix' => [
				'type'    => 'text',
				'label'   => __( 'Author Prefix', 'newsfit' ),
				'default' => 'by',
			],

			'newsfit_meta_heading'     => [
				'type'  => 'heading',
				'label' => __( 'Post Meta Settings', 'newsfit' ),
			],
			'newsfit_single_above_meta_style' => [
				'type'    => 'select',
				'label'   => __( 'Title Above Meta Style', 'newsfit' ),
				'default' => 'meta-style-default',
				'choices' => Fns::meta_style( [ 'meta-style-dash-bg', 'meta-style-pipe' ] )
			],
			'newsfit_blog_meta_style'  => [
				'type'    => 'select',
				'label'   => __( 'Meta Style', 'newsfit' ),
				'default' => 'meta-style-default',
				'choices' => Fns::meta_style()
			],

			'newsfit_blog_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'newsfit' ),
				'description' => __( 'You can sort meta by drag and drop', 'newsfit' ),
				'placeholder' => __( 'Choose Meta', 'newsfit' ),
				'multiselect' => true,
				'default'     => 'author,date,category,tag,comment',
				'choices'     => Fns::blog_meta_list(),
			],

			'newsfit_visibility' => [
				'type'  => 'heading',
				'label' => __( 'Visibility Section', 'newsfit' ),
			],

			'newsfit_meta_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Meta Visibility', 'newsfit' ),
				'default' => 1
			],

			'newsfit_blog_above_meta_visibility' => [
				'type'  => 'switch',
				'label' => __( 'Title Above Category Visibility', 'newsfit' ),
			],

			'newsfit_blog_content_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Content Visibility', 'newsfit' ),
				'default' => 1
			],

			'newsfit_blog_footer_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Footer Visibility', 'newsfit' ),
				'default' => 1
			],

		] );
	}


}
