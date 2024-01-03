<?php
/**
 * LayoutControls
 */

namespace RT\NewsFit\Traits;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

trait LayoutControlsTraits {
	public function get_layout_controls( $prefix = '' ): array {

		return apply_filters( "newsfit_{$prefix}_layout_controls", [

			$prefix . '_layout'      => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'newsfit' ),
				'default' => 'left-sidebar',
				'choices' => [
					'left-sidebar'  => [
						'image' => newsfit_get_img( 'sidebar-left.png' ),
						'name'  => __( 'Left Sidebar', 'newsfit' ),
					],
					'full-width'    => [
						'image' => newsfit_get_img( 'sidebar-full.png' ),
						'name'  => __( 'Full Width', 'newsfit' ),
					],
					'right-sidebar' => [
						'image' => newsfit_get_img( 'sidebar-right.png' ),
						'name'  => __( 'Right Sidebar', 'newsfit' ),
					],
				]
			],

			$prefix . '_separator1'     => [
				'type'    => 'separator',
			],

			$prefix . '_sidebar'     => [
				'type'    => 'select',
				'label'   => __( 'Choose a Sidebar', 'newsfit' ),
				'default' => 'sidebar',
				'choices' => newsfit_sidebar_lists()
			],

			$prefix . '_separator2'     => [
				'type'    => 'separator',
			],

			$prefix . '_header_style' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => esc_html__( 'Header Layout', 'homlisti' ),
				'choices' => [
					'default' => esc_html__( 'Default', 'homlisti' ),
					'1'       => esc_html__( 'Layout 1', 'homlisti' ),
					'2'       => esc_html__( 'Layout 2', 'homlisti' ),
					'3'       => esc_html__( 'Layout 3', 'homlisti' ),
				],
			],

			$prefix . '_top_bar' => [
				'type'    => 'select',
				'label'   => __( 'Top Bar', 'newsfit' ),
				'default' => 'default',
				'choices' => [
					'default' => esc_html__( 'Default', 'homlisti' ),
					'on'      => esc_html__( 'Enable', 'homlisti' ),
					'off'     => esc_html__( 'Disable', 'homlisti' ),
				]
			],

			$prefix . '_header_width' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Header Width', 'homlisti' ),
				'choices' => [
					'default'   => __( 'Default', 'homlisti' ),
					'box-width' => __( 'Box width', 'homlisti' ),
					'fullwidth' => __( 'Fullwidth', 'homlisti' ),
				],
			],

			$prefix . '_menu_alignment' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Menu Alignment', 'homlisti' ),
				'choices' => [
					'default'     => __( 'Default', 'homlisti' ),
					'menu-left'   => __( 'Left Alignment', 'homlisti' ),
					'menu-center' => __( 'Center Alignment', 'homlisti' ),
					'menu-right'  => __( 'Right Alignment', 'homlisti' ),
				],
			],

			$prefix . '_tr_header'  => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => esc_html__( 'Transparent Header', 'homlisti' ),
				'choices' => [
					'default' => esc_html__( 'Default', 'homlisti' ),
					'on'      => esc_html__( 'Enable', 'homlisti' ),
					'off'     => esc_html__( 'Disable', 'homlisti' ),
				],
			],
			$prefix . '_separator3'     => [
				'type'    => 'separator',
			],
			$prefix . '_breadcrumb' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => esc_html__( 'Breadcrumb', 'homlisti' ),
				'choices' => [
					'default' => esc_html__( 'Default', 'homlisti' ),
					'on'      => esc_html__( 'Enable', 'homlisti' ),
					'off'     => esc_html__( 'Disable', 'homlisti' ),
				],
			],

			$prefix . '_padding_top' => [
				'type'    => 'number',
				'label'   => esc_html__( 'Content Padding Top (px)', 'homlisti' ),
				'default' => '100',
			],

			$prefix . '_padding_bottom' => [
				'type'    => 'number',
				'label'   => esc_html__( 'Content Bottom Top (px)', 'homlisti' ),
				'default' => '100',
			],

			$prefix . '_footer_style' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => esc_html__( 'Footer Layout', 'homlisti' ),
				'choices' => [
					'default' => esc_html__( 'Default', 'homlisti' ),
					'1'       => esc_html__( 'Layout 1', 'homlisti' ),
					'2'       => esc_html__( 'Layout 2', 'homlisti' ),
				],
			],


		] );


	}


}
