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
class Labels extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_labels, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_labels_controls', [

			'rt_header_labels' => [
				'type'        => 'heading',
				'label'       => __( 'Header Labels', 'newsfit' ),
			],

			'rt_get_started_label' => [
				'type'        => 'text',
				'label'       => __( 'Get Started', 'newsfit' ),
				'default'     => __( 'Get Started', 'newsfit' ),
				'description' => __( 'Context: Menu Button', 'newsfit' ),
			],

			'rt_follow_us_label' => [
				'type'        => 'text',
				'label'       => __( 'Follow Us On:', 'newsfit' ),
				'default'     => __( 'Follow Us On:', 'newsfit' ),
				'description' => __( 'Context: Topbar icon lable', 'newsfit' ),
			],

		] );
	}


}
