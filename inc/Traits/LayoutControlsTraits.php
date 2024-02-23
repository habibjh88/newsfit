<?php
/**
 * LayoutControls
 */

namespace RT\Newsfit\Traits;

// Do not allow directly accessing this file.
use RT\Newsfit\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

trait LayoutControlsTraits {
	public function get_layout_controls( $prefix = '' ) {

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

		return apply_filters(
			"newsfit_{$prefix}_layout_controls",
			[

				$prefix . '_layout'         => [
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
					],
				],

				$prefix . '_sidebar'        => [
					'type'    => 'select',
					'label'   => __( 'Choose a Sidebar', 'newsfit' ),
					'default' => 'default',
					'choices' => Fns::sidebar_lists(),
				],

				$prefix . '_header_heading' => [
					'type'  => 'heading',
					'label' => __( 'Header Settings', 'newsfit' ),
				],

				$prefix . '_header_style'   => [
					'type'    => 'select',
					'default' => 'default',
					'label'   => __( 'Header Layout', 'newsfit' ),
					'choices' => [
						'default' => __( '--Default--', 'newsfit' ),
						'1'       => __( 'Layout 1', 'newsfit' ),
						'2'       => __( 'Layout 2', 'newsfit' ),
						'3'       => __( 'Layout 3', 'newsfit' ),
					],
				],

				$prefix . '_top_bar'        => [
					'type'    => 'select',
					'label'   => __( 'Top Bar', 'newsfit' ),
					'default' => 'default',
					'choices' => [
						'default' => __( '--Default--', 'newsfit' ),
						'on'      => __( 'On', 'newsfit' ),
						'off'     => __( 'Off', 'newsfit' ),
					],
				],

				$prefix . '_banner_heading' => [
					'type'  => 'heading',
					'label' => __( 'Banner Settings', 'newsfit' ),
				],

				$prefix . '_banner'         => [
					'type'    => 'select',
					'default' => 'default',
					'label'   => __( 'Banner Visibility', 'newsfit' ),
					'choices' => [
						'default' => __( '--Default--', 'newsfit' ),
						'on'      => __( 'On', 'newsfit' ),
						'off'     => __( 'Off', 'newsfit' ),
					],
				],

				$prefix . '_breadcrumb'     => [
					'type'    => 'select',
					'default' => 'default',
					'label'   => __( 'Banner Content (Breadcrumb) Visibility', 'newsfit' ),
					'choices' => [
						'default' => __( '--Default--', 'newsfit' ),
						'on'      => __( 'On', 'newsfit' ),
						'off'     => __( 'Off', 'newsfit' ),
					],
				],

				$prefix . '_banner_image'   => [
					'type'         => 'image',
					'label'        => __( 'Banner Image', 'newsfit' ),
					'description'  => __( 'Upload Banner Image', 'newsfit' ),
					'button_label' => __( 'Banner Image', 'newsfit' ),
				],

				$prefix . '_footer_heading' => [
					'type'  => 'heading',
					'label' => __( 'Footer Settings', 'newsfit' ),
				],

				$prefix . '_footer_style'   => [
					'type'    => 'select',
					'default' => 'default',
					'label'   => __( 'Footer Layout', 'newsfit' ),
					'choices' => [
						'default' => __( '--Default--', 'newsfit' ),
						'1'       => __( 'Layout 1', 'newsfit' ),
						'2'       => __( 'Layout 2', 'newsfit' ),
					],
				],

			]
		);
	}
}
