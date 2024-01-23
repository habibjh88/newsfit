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
class BlogSingle extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_blog_single, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {
		return apply_filters( 'newsfit_single_controls', [
			'newsfit_single_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Single Meta', 'newsfit' ),
				'description' => __( 'You can sort meta by drag and drop', 'newsfit' ),
				'placeholder' => __( 'Choose Meta', 'newsfit' ),
				'multiselect' => true,
				'default'     => 'author,date,category,tag,comment',
				'choices'     => Fns::blog_meta_list(),
			],

			'newsfit_single_meta_style' => [
				'type'    => 'select',
				'label'   => __( 'Meta Style', 'newsfit' ),
				'default' => 'meta-style-default',
				'choices' => Fns::meta_style()
			],

			'newsfit_single_author_prefix' => [
				'type'    => 'text',
				'label'   => __( 'Meta Author Prefix', 'newsfit' ),
				'default' => 'by',
			],

			'newsfit_single_visibility' => [
				'type'  => 'heading',
				'label' => __( 'Visibility Section', 'newsfit' ),
			],

			'newsfit_single_meta_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Meta Visibility', 'newsfit' ),
				'default' => 1
			],

			'newsfit_single_meta_above_visibility' => [
				'type'  => 'switch',
				'label' => __( 'Title Above Category Visibility', 'newsfit' ),
			],

		] );
	}


}