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
class Footer extends Customizer {
	protected string $section_footer = 'newsfit_footer_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_section( [
			'id'          => $this->section_footer,
			'title'       => __( 'Footer', 'newsfit' ),
			'description' => __( 'NewsFit Footer Section', 'newsfit' ),
			'priority'    => 38
		] );

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
				'choices' => Fns::image_placeholder( 'footer', 2 )
			],

			'rt_footer_schema' => [
				'type'    => 'select',
				'label'   => __( 'Footer Schema', 'newsfit' ),
				'default' => 'schema-default',
				'choices' => [
					'schema-default' => __( 'Default', 'newsfit' ),
					'footer-light'   => __( 'Light Footer', 'newsfit' ),
					'footer-dark'    => __( 'Dark Footer', 'newsfit' ),
				]
			],

			'rt_footer_width' => [
				'type'    => 'select',
				'label'   => __( 'Footer Width', 'newsfit' ),
				'default' => '',
				'choices' => [
					''       => __( 'Box Width', 'newsfit' ),
					'-fluid' => __( 'Full Width', 'newsfit' ),
				]
			],

			'rt_footer_max_width' => [
				'type'        => 'number',
				'label'       => __( 'Footer Max Width (PX)', 'newsfit' ),
				'description' => __( 'Enter a number greater than 1440. Remove value for 100%', 'newsfit' ),
				'condition'   => [ 'rt_footer_width', '==', '-fluid' ]
			],

			'rt_sticy_footer' => [
				'type'        => 'switch',
				'label'       => __( 'Sticky Footer', 'newsfit' ),
				'description' => __( 'Show footer at the top when scrolling down', 'newsfit' ),
			],

			'rt_footer_copyright' => [
				'type'        => 'tinymce',
				'label'       => __( 'Footer Copyright Text', 'newsfit' ),
				'default'     => __( 'Copyright© [y] Newsfit by <a href="https://radiustheme.com/">RadiusTheme</a>', 'newsfit' ),
				'description' => __( 'Add [y] flag anywhere for dynamic year.', 'newsfit' ),
			],

			'rt_footer_heading1' => [
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
				]
			],

		] );

	}


}
