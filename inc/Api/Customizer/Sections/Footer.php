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
class Footer extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_footer_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'title'       => __( 'Footer', 'newsfit' ),
				'description' => __( 'Newsfit Footer Section', 'newsfit' ),
				'priority'    => 38,
			]
		);

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_footer_controls',
			[

				'rt_footer_style'          => [
					'type'    => 'image_select',
					'label'   => __( 'Choose Layout', 'newsfit' ),
					'default' => '1',
					'choices' => Fns::image_placeholder( 'footer', 2 ),
				],

				'rt_footer_width'          => [
					'type'    => 'select',
					'label'   => __( 'Footer Width', 'newsfit' ),
					'default' => '',
					'choices' => [
						''       => __( 'Box Width', 'newsfit' ),
						'-fluid' => __( 'Full Width', 'newsfit' ),
					],
				],

				'rt_footer_max_width'      => [
					'type'        => 'number',
					'label'       => __( 'Footer Max Width (PX)', 'newsfit' ),
					'description' => __( 'Enter a number greater than 992.', 'newsfit' ),
					'condition'   => [ 'rt_footer_width', '==', '-fluid' ],
				],

				'rt_sticy_footer'          => [
					'type'        => 'switch',
					'label'       => __( 'Sticky Footer', 'newsfit' ),
					'description' => __( 'Show footer at the top when scrolling down', 'newsfit' ),
				],

				'rt_footer_copyright'      => [
					'type'        => 'tinymce',
					'label'       => __( 'Footer Copyright Text', 'newsfit' ),
					'default'     => __( 'Copyright© [y] Newsfit by <a href="https://radiustheme.com/">RadiusTheme</a>', 'newsfit' ),
					'description' => __( 'Add [y] flag anywhere for dynamic year.', 'newsfit' ),
				],

				'rt_footer_heading1'       => [
					'type'  => 'heading',
					'label' => __( 'Footer Menu Section', 'newsfit' ),
				],

				'rt_footer_menu_alignment' => [
					'type'    => 'select',
					'label'   => __( 'Footer Menu Alignment', 'newsfit' ),
					'default' => 'align-default',
					'choices' => [
						'align-default'          => __( 'Default from style', 'newsfit' ),
						'justify-content-start'  => __( 'Left', 'newsfit' ),
						'justify-content-center' => __( 'Center', 'newsfit' ),
						'justify-content-end'    => __( 'Right', 'newsfit' ),
					],
				],

			]
		);
	}
}
