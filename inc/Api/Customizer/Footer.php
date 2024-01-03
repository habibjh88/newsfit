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
class Footer extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_footer, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_footer_controls', [

			'rt_footer_style' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'newsfit' ),
				'default' => '1',
				'choices' => newsfit_header_presets()
			],

			'rt_footer_width' => [
				'type'    => 'select',
				'label'   => __( 'Header Width', 'newsfit' ),
				'default' => '',
				'choices' => [
					''       => __( 'Box Width', 'newsfit' ),
					'-fluid' => __( 'Full Width', 'newsfit' ),
				]
			],

			'rt_footer_max_width' => [
				'type'        => 'number',
				'label'       => __( 'Header Max Width (PX)', 'newsfit' ),
				'description' => __( 'Enter a number greater than 1440. Remove value for 100%', 'newsfit' ),
				'condition'   => [ 'rt_footer_width', '==', '-fluid' ]
			],

			'rt_sticy_footer' => [
				'type'        => 'switch',
				'label'       => __( 'Sticky Footer', 'newsfit' ),
				'description' => __( 'Show footer at the top when scrolling down', 'newsfit' ),
			],


		] );

	}


}
