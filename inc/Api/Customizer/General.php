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
class General extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_general, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_test_controls', [

			'rt_svg_enable' => [
				'type'  => 'switch',
				'label' => __( 'Enable SVG Upload', 'newsfit' ),
			],

			'rt_preloader' => [
				'type'  => 'switch',
				'label' => __( 'Preloader', 'newsfit' ),
			],

			'rt_back_to_top' => [
				'type'  => 'switch',
				'label' => __( 'Back to Top', 'newsfit' ),
			],

			'rt_remove_admin_bar' => [
				'type'  => 'switch',
				'label' => __( 'Back to Top', 'newsfit' ),
			],

		] );

	}

}
