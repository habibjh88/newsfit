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
class Header extends Customizer {
	protected string $section_header = 'newsfit_header_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'          => $this->section_header,
			'panel'       => 'rt_header_panel',
			'title'       => __( 'Header Menu', 'newsfit' ),
			'description' => __( 'NewsFit Header Section', 'newsfit' ),
			'priority'    => 2
		] );
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
				'choices' => Fns::image_placeholder( 'menu', 1 )
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
				'type'    => 'select',
				'label'   => __( 'Header Width', 'newsfit' ),
				'default' => '',
				'choices' => [
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
				'type'  => 'switch',
				'label' => __( 'Transparent Header', 'newsfit' ),
			],

			'rt_tr_header_shadow' => [
				'type'  => 'switch',
				'label' => __( 'Header Dark Shadow', 'newsfit' ),
			],

			'rt_header_border' => [
				'type'    => 'switch',
				'label'   => __( 'Header Border', 'newsfit' ),
				'default' => 1
			],
			'rt_header_sep1'   => [
				'type' => 'separator',
			],

			'rt_header_login_link' => [
				'type'    => 'switch',
				'label'   => __( 'User Login ?', 'newsfit' ),
				'default' => 1,
			],

			'rt_header_search' => [
				'type'    => 'switch',
				'label'   => __( 'Search Icon ?', 'newsfit' ),
				'default' => 1,
			],

			'rt_header_bar' => [
				'type'        => 'switch',
				'label'       => __( 'Header Bar ?', 'newsfit' ),
				'description' => __( 'It will be hide only for desktop.', 'newsfit' ),
				'default'     => 1,
			],

			'rt_header_separator' => [
				'type'    => 'switch',
				'label'   => __( 'Icon Separator', 'newsfit' ),
				'default' => 1,
			],

			'rt_header_sep2' => [
				'type' => 'separator',
			],

			'rt_get_started_button' => [
				'type'    => 'switch',
				'label'   => __( 'Get Started Button ?', 'newsfit' ),
				'default' => 1
			],


		] );

	}


}
