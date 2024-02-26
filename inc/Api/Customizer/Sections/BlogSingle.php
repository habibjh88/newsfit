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
class BlogSingle extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_blog_single = 'newsfit_blog_single_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_blog_single,
				'title'       => __( 'Single Blog', 'newsfit' ),
				'description' => __( 'Newsfit Blog Single Section', 'newsfit' ),
				'priority'    => 26,
			]
		);

		Customize::add_controls( $this->section_blog_single, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {
		return apply_filters(
			'newsfit_single_controls',
			[

				'rt_single_post_style'         => [
					'type'    => 'select',
					'label'   => __( 'Post View Style', 'newsfit' ),
					'default' => 'single-default',
					'choices' => Fns::single_post_style(),
				],

				'rt_single_meta_list'          => [
					'type'        => 'select2',
					'label'       => __( 'Choose Single Meta', 'newsfit' ),
					'description' => __( 'You can sort meta by drag and drop', 'newsfit' ),
					'placeholder' => __( 'Choose Meta', 'newsfit' ),
					'multiselect' => true,
					'default'     => 'author,date,category,comment',
					'choices'     => Fns::blog_meta_list(),
				],

				'rt_single_meta_style'         => [
					'type'    => 'select',
					'label'   => __( 'Meta Style', 'newsfit' ),
					'default' => 'meta-style-default',
					'choices' => Fns::meta_style(),
				],

				'rt_single_visibility_heading' => [
					'type'  => 'heading',
					'label' => __( 'Visibility Section', 'newsfit' ),
				],

				'rt_single_meta'               => [
					'type'    => 'switch',
					'label'   => __( 'Meta Visibility', 'newsfit' ),
					'default' => 1,
				],

				'rt_single_above_meta'         => [
					'type'  => 'switch',
					'label' => __( 'Title Above Meta Visibility', 'newsfit' ),
				],

				'rt_single_meta_icon'          => [
					'type'      => 'switch',
					'label'     => __( 'Meta Icons ?', 'newsfit' ),
					'default'   => 0,
					'condition' => [ 'rt_single_meta' ],
				],

				'rt_single_meta_user_avatar'   => [
					'type'      => 'switch',
					'label'     => __( 'Meta User Avatar ?', 'newsfit' ),
					'default'   => 0,
					'condition' => [ 'rt_single_meta' ],
				],

			]
		);
	}
}
