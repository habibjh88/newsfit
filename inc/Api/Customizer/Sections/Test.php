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
class Test extends Customizer {

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_labels = 'newsfit_test_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_labels,
				'title'       => __( 'Modify Static Text', 'newsfit' ),
				'description' => __( 'You can change all static text of the theme.', 'newsfit' ),
				'priority'    => 999,
			]
		);
		Customize::add_controls( $this->section_labels, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_labels_controls',
			[

				'rt_header_labels'     => [
					'type'  => 'heading',
					'label' => __( 'Header Labels', 'newsfit' ),
				],

				'rt_get_started_label' => [
					'type'        => 'text',
					'label'       => __( 'Get Started', 'newsfit' ),
					'default'     => __( 'Get Started', 'newsfit' ),
					'description' => __( 'Context: Menu Button', 'newsfit' ),
				],

				'rt_follow_us_label'   => [
					'type'        => 'text',
					'label'       => __( 'Follow Us On:', 'newsfit' ),
					'default'     => __( 'Follow Us On:', 'newsfit' ),
					'description' => __( 'Context: Topbar icon label', 'newsfit' ),
				],

				'rt_blog_labels'       => [
					'type'  => 'heading',
					'label' => __( 'Blog Labels', 'newsfit' ),
				],
				'rt_author_prefix'     => [
					'type'        => 'text',
					'label'       => __( 'By', 'newsfit' ),
					'default'     => 'by',
					'description' => __( 'Context: Meta Author Prefix', 'newsfit' ),
				],
				'rt_tags'              => [
					'type'        => 'text',
					'label'       => __( 'Tags:', 'newsfit' ),
					'default'     => __( 'Tags:', 'newsfit' ),
					'description' => __( 'Context: Single blog footer tags label', 'newsfit' ),
				],

			]
		);
	}
}
