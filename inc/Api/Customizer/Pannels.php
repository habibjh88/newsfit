<?php
/**
 * Theme Customizer Pannels
 *
 * @package newsfit
 */

namespace RT\Newsfit\Api\Customizer;

use RT\Newsfit\Traits\SingletonTraits;
use RTFramework\Customize;

/**
 * Customizer class
 */
class Pannels {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		$this->add_panels();
	}

	/**
	 * Add Panels
	 * @return void
	 */
	public function add_panels() {
		Customize::add_panels(
			[
				[
					'id'          => 'rt_header_panel',
					'title'       => esc_html__( 'Header - Topbar - Menu', 'newsfit' ),
					'description' => esc_html__( 'Newsfit Header', 'newsfit' ),
					'priority'    => 22,
				],
				[
					'id'          => 'rt_typography_panel',
					'title'       => esc_html__( 'Typography', 'newsfit' ),
					'description' => esc_html__( 'Newsfit Typography', 'newsfit' ),
					'priority'    => 24,
				],
				[
					'id'          => 'rt_color_panel',
					'title'       => esc_html__( 'Colors', 'newsfit' ),
					'description' => esc_html__( 'Newsfit Color Settings', 'newsfit' ),
					'priority'    => 28,
				],
				[
					'id'          => 'rt_layouts_panel',
					'title'       => esc_html__( 'Layout Settings', 'newsfit' ),
					'description' => esc_html__( 'Newsfit Layout Settings', 'newsfit' ),
					'priority'    => 34,
				],
				[
					'id'          => 'rt_contact_social_panel',
					'title'       => esc_html__( 'Contact & Socials', 'newsfit' ),
					'description' => esc_html__( 'Newsfit Contact & Socials', 'newsfit' ),
					'priority'    => 24,
				],

			]
		);
	}

}
