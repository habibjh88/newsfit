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
class ZControllerExample extends Customizer {

	protected string $section_test = 'rt_test_test_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_test,
			'title'       => __( 'Test Controls', 'newsfit' ),
			'description' => __( 'Customize the Test', 'newsfit' ),
			'priority'    => 9999
		] );
		Customize::add_controls( $this->section_test, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {
		return apply_filters( 'rt_test_test_controls', [

			//Reset button
			'rt_reset_customize' => [
				'type'  => 'heading',
				'reset' => '1',
			],
			//Reset button

			'rt_test_heading1' => [
				'type'        => 'heading',
				'label'       => __( 'All controls', 'newsfit' ),
				'description' => __( 'All controls are here', 'newsfit' ),
			],

			'rt_test_switch' => [
				'type'  => 'switch',
				'label' => __( 'Choose switch', 'newsfit' ),
			],

			'rt_test_text' => [
				'type'      => 'text',
				'label'     => __( 'Text Default', 'newsfit' ),
				'default'   => __( 'Text Default', 'newsfit' ),
				'transport' => '',
				'condition' => [ 'rt_test_switch' ]
			],


			'rt_test_switch2' => [
				'type'  => 'switch',
				'label' => __( 'Choose switch2', 'newsfit' ),
			],
			'rt_test_url'     => [
				'type'      => 'url',
				'label'     => __( 'url', 'newsfit' ),
				'default'   => __( 'url Default', 'newsfit' ),
				'transport' => '',
				'condition' => [ 'rt_test_switch2', '!==', 1 ]
			],

			'rt_test_select'   => [
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
			'rt_test_textarea' => [
				'type'      => 'textarea',
				'label'     => __( 'Textarea', 'newsfit' ),
				'default'   => __( 'Textarea Default', 'newsfit' ),
				'transport' => '',
			],

			'rt_test_select5' => [
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

			'rt_test_textarea2' => [
				'type'      => 'textarea',
				'label'     => __( 'Textarea2', 'newsfit' ),
				'default'   => __( 'Textarea Default', 'newsfit' ),
				'transport' => '',
			],


			'rt_test_checkbox' => [
				'type'  => 'checkbox',
				'label' => __( 'Choose checkbox', 'newsfit' ),
			],

			'rt_test_textarea22' => [
				'type'      => 'textarea',
				'label'     => __( 'Checkbox Textarea2', 'newsfit' ),
				'transport' => '',
				'condition' => [ 'rt_test_checkbox', '==', '1' ]
			],


			'rt_test_radio' => [
				'type'    => 'radio',
				'label'   => __( 'Choose radio', 'newsfit' ),
				'choices' => [
					'menu-left'   => __( 'Left Alignment', 'newsfit' ),
					'menu-center' => __( 'Center Alignment', 'newsfit' ),
					'menu-right'  => __( 'Right Alignment', 'newsfit' ),
				]
			],

			'rt_test_textarea222' => [
				'type'      => 'textarea',
				'label'     => __( 'rt_test_radio Textarea2 - menu-center', 'newsfit' ),
				'transport' => '',
			],

			'rt_test_image_choose' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'newsfit' ),
				'default' => '1',
				'choices' => $this->get_header_presets()
			],

			'rt_test_image' => [
				'type'         => 'image',
				'label'        => __( 'Choose Image', 'newsfit' ),
				'button_label' => __( 'Logo', 'newsfit' ),
			],

			'rt_test_image_attr' => [
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

			'rt_test_number' => [
				'type'        => 'number',
				'label'       => __( 'Select a Number', 'newsfit' ),
				'description' => __( 'Select Number', 'newsfit' ),
				'default'     => '5',
			],

			'rt_test_pages' => [
				'type'  => 'pages',
				'label' => __( 'Choose page', 'newsfit' ),
			],


			'rt_test_color'      => [
				'type'  => 'color',
				'label' => __( 'Choose color', 'newsfit' ),
			],
			'rt_test_alfa_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Choose alfa_color', 'newsfit' ),
			],
			'rt_test_datetime'   => [
				'type'  => 'datetime',
				'label' => __( 'Choose datetime', 'newsfit' ),
			],


			'rt_test_select2' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'newsfit' ),
				'placeholder' => __( 'Choose Meta', 'newsfit' ),
				'multiselect' => true,
				'choices'     => [
					'author'   => __( 'Author', 'skyrocket' ),
					'date'     => __( 'Date', 'skyrocket' ),
					'category' => __( 'Category', 'skyrocket' ),
					'tag'      => __( 'Tag', 'skyrocket' ),
					'comment'  => __( 'Comment', 'skyrocket' ),
				],
			],

			'rt_test_repeater' => [
				'type'  => 'repeater',
				'label' => __( 'Choose repeater', 'newsfit' ),
			],

			'rt_test_blog_meta_order1' => [
				'type'    => 'repeater',
				'label'   => __( 'Meta Order', 'newsfit' ),
				'default' => 'one, two, three, four',
				'use_as'  => 'sort', //'sort','repeater'
			],

			'rt_test_blog_meta_order2' => [
				'type'    => 'repeater',
				'label'   => __( 'Meta Order', 'newsfit' ),
				'default' => 'one, two, three, four',
//				'use_as'  => 'repeater', //'sort','repeater'
			],

			'rt_test_typography2' => [
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

			'rt_test_typography3' => [
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
	public function get_header_presets() {
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
