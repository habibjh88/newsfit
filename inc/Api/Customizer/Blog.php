<?php
/**
 * Theme Customizer - Header
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer;

use RT\NewsFit\Api\Customizer;
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
			'newsfit_blog_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'newsfit' ),
				'description' => __( 'You can sort meta by drag and drop', 'newsfit' ),
				'placeholder' => __( 'Choose Meta', 'newsfit' ),
				'multiselect' => true,
				'default'     => 'author,date,category,tag,comment',
				'choices'     => [
					'author'   => __( 'Author', 'skyrocket' ),
					'date'     => __( 'Date', 'skyrocket' ),
					'category' => __( 'Category', 'skyrocket' ),
					'tag'      => __( 'Tag', 'skyrocket' ),
					'comment'  => __( 'Comment', 'skyrocket' ),
				],
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


		] );
	}


}
