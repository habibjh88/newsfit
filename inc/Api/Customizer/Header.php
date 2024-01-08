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
class Header extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_header, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_header_controls', [

			'rt_header_style' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'newsfit' ),
				'default' => '1',
				'choices' => newsfit_header_presets()
			],

			'rt_menu_alignment' => [
				'type'    => 'select',
				'label'   => __( 'Menu Alignment', 'newsfit' ),
				'default' => 'text-left',
				'choices' => [
					'text-left'   => __( 'Left Alignment', 'newsfit' ),
					'text-center' => __( 'Center Alignment', 'newsfit' ),
					'text-right'  => __( 'Right Alignment', 'newsfit' ),
				]
			],

			'rt_header_width' => [
				'type'      => 'select',
				'label'     => __( 'Header Width', 'newsfit' ),
				'default'   => '',
				'choices'   => [
					''       => __( 'Box Width', 'newsfit' ),
					'-fluid' => __( 'Full Width', 'newsfit' ),
				]
			],

			'rt_header_max_width' => [
				'type'        => 'number',
				'label'       => __( 'Header Max Width (PX)', 'newsfit' ),
				'description' => __( 'Enter a number greater than 1440. Remove value for 100%', 'newsfit' ),
				'condition'   => [ 'rt_header_width', '==', '-fluid' ]
			],

			'rt_sticy_header' => [
				'type'        => 'switch',
				'label'       => __( 'Sticky Header', 'newsfit' ),
				'description' => __( 'Show header at the top when scrolling down', 'newsfit' ),
			],

			'rt_tr_header' => [
				'type'    => 'switch',
				'label'   => __( 'Transparent Header', 'newsfit' ),
			],

			'rt_header_border' => [
				'type'    => 'switch',
				'label'   => __( 'Header Border', 'newsfit' ),
				'default' => 1
			],


		] );

	}


}
