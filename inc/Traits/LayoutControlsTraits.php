<?php
/**
 * LayoutControls
 */

namespace RT\NewsFit\Traits;

// Do not allow directly accessing this file.
use RT\NewsFit\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

trait LayoutControlsTraits {
	public function get_layout_controls( $prefix = '' ): array {

		$_left_text  = __( 'Left Sidebar', 'newsfit' );
		$_right_text = __( 'Right Sidebar', 'newsfit' );
		$left_text   = $_left_text;
		$right_text  = $_right_text;
		$image_left  = 'sidebar-left.png';
		$image_right = 'sidebar-right.png';

		if ( is_rtl() ) {
			$left_text   = $_right_text;
			$right_text  = $_left_text;
			$image_left  = 'sidebar-right.png';
			$image_right = 'sidebar-left.png';
		}

		return apply_filters( "newsfit_{$prefix}_layout_controls", [

			$prefix . '_layout' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'newsfit' ),
				'default' => 'right-sidebar',
				'choices' => [
					'left-sidebar'  => [
						'image' => newsfit_get_img( $image_left ),
						'name'  => $left_text,
					],
					'full-width'    => [
						'image' => newsfit_get_img( 'sidebar-full.png' ),
						'name'  => __( 'Full Width', 'newsfit' ),
					],
					'right-sidebar' => [
						'image' => newsfit_get_img( $image_right ),
						'name'  => $right_text,
					],
				]
			],

			$prefix . '_sidebar' => [
				'type'    => 'select',
				'label'   => __( 'Choose a Sidebar', 'newsfit' ),
				'default' => 'default',
				'choices' => Fns::sidebar_lists()
			],

			$prefix . '_header_heading' => [
				'type'  => 'heading',
				'label' => __( 'Header Settings', 'homlisti' ),
			],

			$prefix . '_header_style' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Header Layout', 'homlisti' ),
				'choices' => [
					'default' => __( '--Default--', 'homlisti' ),
					'1'       => __( 'Layout 1', 'homlisti' ),
					'2'       => __( 'Layout 2', 'homlisti' ),
					'3'       => __( 'Layout 3', 'homlisti' ),
				],
			],

			$prefix . '_top_bar' => [
				'type'    => 'select',
				'label'   => __( 'Top Bar', 'newsfit' ),
				'default' => 'default',
				'choices' => [
					'default' => __( '--Default--', 'homlisti' ),
					'on'      => __( 'On', 'homlisti' ),
					'off'     => __( 'Off', 'homlisti' ),
				]
			],

			$prefix . '_header_width' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Header Width', 'homlisti' ),
				'choices' => [
					'default'   => __( '--Default--', 'homlisti' ),
					'box-width' => __( 'Box width', 'homlisti' ),
					'fullwidth' => __( 'Fullwidth', 'homlisti' ),
				],
			],

			$prefix . '_menu_alignment' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Menu Alignment', 'homlisti' ),
				'choices' => [
					'default'     => __( '--Default--', 'homlisti' ),
					'menu-left'   => __( 'Left Alignment', 'homlisti' ),
					'menu-center' => __( 'Center Alignment', 'homlisti' ),
					'menu-right'  => __( 'Right Alignment', 'homlisti' ),
				],
			],

			$prefix . '_tr_header'      => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Transparent Header', 'homlisti' ),
				'choices' => [
					'default' => __( '--Default--', 'homlisti' ),
					'on'      => __( 'On', 'homlisti' ),
					'off'     => __( 'Off', 'homlisti' ),
				],
			],
			$prefix . '_banner_heading' => [
				'type'  => 'heading',
				'label' => __( 'Banner Settings', 'homlisti' ),
			],

			$prefix . '_banner' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Visibility', 'homlisti' ),
				'choices' => [
					'default' => __( '--Default--', 'homlisti' ),
					'on'      => __( 'On', 'homlisti' ),
					'off'     => __( 'Off', 'homlisti' ),
				],
			],

			$prefix . '_breadcrumb' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Content (Breadcrumb) Visibility', 'homlisti' ),
				'choices' => [
					'default' => __( '--Default--', 'homlisti' ),
					'on'      => __( 'On', 'homlisti' ),
					'off'     => __( 'Off', 'homlisti' ),
				],
			],

			$prefix . '_banner_height' => [
				'type'  => 'number',
				'label' => __( 'Banner Height (px)', 'homlisti' ),
			],

			$prefix . '_banner_image' => [
				'type'         => 'image',
				'label'        => __( 'Banner Image', 'newsfit' ),
				'description'  => __( 'Upload Banner Image', 'newsfit' ),
				'button_label' => __( 'Banner Image', 'newsfit' ),
			],

			$prefix . '_others_heading' => [
				'type'  => 'heading',
				'label' => __( 'Others Settings', 'homlisti' ),
			],

//			$prefix . '_padding_top' => [
//				'type'    => 'number',
//				'label'   => __( 'Content Padding Top (px)', 'homlisti' ),
//				'default' => '100',
//			],
//
//			$prefix . '_padding_bottom' => [
//				'type'    => 'number',
//				'label'   => __( 'Content Bottom Top (px)', 'homlisti' ),
//				'default' => '100',
//			],

			$prefix . '_footer_style'  => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Footer Layout', 'homlisti' ),
				'choices' => [
					'default' => __( '--Default--', 'homlisti' ),
					'1'       => __( 'Layout 1', 'homlisti' ),
					'2'       => __( 'Layout 2', 'homlisti' ),
				],
			],
			$prefix . '_footer_schema' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Footer Schema', 'homlisti' ),
				'choices' => [
					'default'      => __( '--Default--', 'homlisti' ),
					'footer-light' => __( 'Light Footer', 'newsfit' ),
					'footer-dark'  => __( 'Dark Footer', 'newsfit' ),
				]
			],


		] );


	}


}
