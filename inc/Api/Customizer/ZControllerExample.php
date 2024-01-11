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
class ZControllerExample extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_test, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {
		return apply_filters( 'newsfit_test_controls', [

			//Reset button
			'rt_reset_customize' => [
				'type'    => 'heading',
				'reset'    => '1',
			],
			//Reset button

			'newsfit_heading1' => [
				'type'        => 'heading',
				'label'       => __( 'All controls', 'newsfit' ),
				'description' => __( 'All controls are here', 'newsfit' ),
			],

			'newsfit_switch' => [
				'type'  => 'switch',
				'label' => __( 'Choose switch', 'newsfit' ),
			],

			'newsfit_text' => [
				'type'      => 'text',
				'label'     => __( 'Text Default', 'newsfit' ),
				'default'   => __( 'Text Default', 'newsfit' ),
				'transport' => '',
				'condition' => [ 'newsfit_switch' ]
			],


			'newsfit_switch2' => [
				'type'  => 'switch',
				'label' => __( 'Choose switch2', 'newsfit' ),
			],
			'newsfit_url'     => [
				'type'      => 'url',
				'label'     => __( 'url', 'newsfit' ),
				'default'   => __( 'url Default', 'newsfit' ),
				'transport' => '',
				'condition' => [ 'newsfit_switch2', '!==', 1 ]
			],

			'newsfit_select'   => [
				'type'        => 'select',
				'label'       => __( 'Select a Val', 'newsfit' ),
				'description' => __( 'Select Discription', 'newsfit' ),
				'default'     => 'menu-left',
				'choices'     => [
					'menu-left'   => __( 'Left Alignment', 'newsfit' ),
					'menu-center' => __( 'Center Alignment', 'newsfit' ),
					'menu-right'  => __( 'Right Alignment', 'newsfit' ),
				]
			],
			'newsfit_textarea' => [
				'type'      => 'textarea',
				'label'     => __( 'Textarea', 'newsfit' ),
				'default'   => __( 'Textarea Default', 'newsfit' ),
				'transport' => '',
			],

			'newsfit_select5' => [
				'type'        => 'select',
				'label'       => __( 'Select a Val2', 'newsfit' ),
				'description' => __( 'Select Discription', 'newsfit' ),
				'default'     => 'menu-center',
				'choices'     => [
					'menu-left'   => __( 'Left Alignment', 'newsfit' ),
					'menu-center' => __( 'Center Alignment', 'newsfit' ),
					'menu-right'  => __( 'Right Alignment', 'newsfit' ),
				]
			],

			'newsfit_textarea2' => [
				'type'      => 'textarea',
				'label'     => __( 'Textarea2', 'newsfit' ),
				'default'   => __( 'Textarea Default', 'newsfit' ),
				'transport' => '',
			],


			'newsfit_checkbox' => [
				'type'  => 'checkbox',
				'label' => __( 'Choose checkbox', 'newsfit' ),
			],

			'newsfit_textarea22' => [
				'type'      => 'textarea',
				'label'     => __( 'Checkbox Textarea2', 'newsfit' ),
				'transport' => '',
				'condition' => [ 'newsfit_checkbox', '==', '1' ]
			],


			'newsfit_radio' => [
				'type'    => 'radio',
				'label'   => __( 'Choose radio', 'newsfit' ),
				'choices' => [
					'menu-left'   => __( 'Left Alignment', 'newsfit' ),
					'menu-center' => __( 'Center Alignment', 'newsfit' ),
					'menu-right'  => __( 'Right Alignment', 'newsfit' ),
				]
			],

			'newsfit_textarea222' => [
				'type'      => 'textarea',
				'label'     => __( 'newsfit_radio Textarea2 - menu-center', 'newsfit' ),
				'transport' => '',
			],

			'newsfit_image_placeholder' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'newsfit' ),
				'default' => '1',
				'choices' => $this->get_header_presets()
			],

			'newsfit_image'          => [
				'type'         => 'image',
				'label'        => __( 'Choose Image', 'newsfit' ),
				'button_label' => __( 'Logo', 'newsfit' ),
			],

			'newsfit_image_attr' => [
				'type'      => 'bg_attribute',
				'condition' => [ 'rt_banner' ],
				'default'   => json_encode(
					[
						'position'   => 'center center',
						'attachment' => 'scroll',
						'repeat'     => 'no-repeat',
						'size'       => 'auto',
					]
				)
			],

			'newsfit_number' => [
				'type'        => 'number',
				'label'       => __( 'Select a Number', 'newsfit' ),
				'description' => __( 'Select Number', 'newsfit' ),
				'default'     => '5',
			],

			'newsfit_pages' => [
				'type'  => 'pages',
				'label' => __( 'Choose page', 'newsfit' ),
			],


			'newsfit_color'      => [
				'type'  => 'color',
				'label' => __( 'Choose color', 'newsfit' ),
			],
			'newsfit_alfa_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Choose alfa_color', 'newsfit' ),
			],
			'newsfit_datetime'   => [
				'type'  => 'datetime',
				'label' => __( 'Choose datetime', 'newsfit' ),
			],
			'newsfit_select2'    => [
				'type'  => 'select2',
				'label' => __( 'Choose select2', 'newsfit' ),
			],

			'newsfit_repeater' => [
				'type'  => 'repeater',
				'label' => __( 'Choose repeater', 'newsfit' ),
			],

			'newsfit_typography2' => [
				'type'    => 'typography',
				'label'   => __( 'Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => 'Open Sans',
						'regularweight' => 'normal',
						'size'          => '16',
						'lineheight'    => '26',
					]
				)
			],

			'newsfit_typography3' => [
				'type'    => 'typography',
				'label'   => __( 'Typography', 'newsfit' ),
				'default' => json_encode(
					[
						'font'          => 'Open Sans',
						'regularweight' => 'normal',
						'size'          => '16',
						'lineheight'    => '26',
					]
				)
			],
		] );
	}

	/**
	 * Get Header Presets
	 * @return array[]
	 */
	public function get_header_presets(): array {
		if ( ! defined( 'RT_FRAMEWORK_DIR_URL' ) ) {
			return [];
		}

		return [
			'1' => [
				'image' => RT_FRAMEWORK_DIR_URL . '/assets/images/header-1.png',
				'name'  => __( 'Style 1', 'newsfit' ),
			],
			'2' => [
				'image' => RT_FRAMEWORK_DIR_URL . '/assets/images/header-1.png',
				'name'  => __( 'Style 2', 'newsfit' ),
			],
			'3' => [
				'image' => RT_FRAMEWORK_DIR_URL . '/assets/images/header-1.png',
				'name'  => __( 'Style 3', 'newsfit' ),
			],
		];
	}

}
