<?php
/**
 * Theme Customizer Pannels
 *
 * @package newsfit
 */

namespace RT\NewsFit\Api\Customizer;

use RT\NewsFit\Traits\SingletonTraits;
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
					'description' => esc_html__( 'NewsFit Header', 'newsfit' ),
					'priority'    => 22,
				],
				[
					'id'          => 'rt_typography_panel',
					'title'       => esc_html__( 'Typography', 'newsfit' ),
					'description' => esc_html__( 'NewsFit Typography', 'newsfit' ),
					'priority'    => 24,
				],
				[
					'id'          => 'rt_color_panel',
					'title'       => esc_html__( 'Colors', 'newsfit' ),
					'description' => esc_html__( 'NewsFit Color Settings', 'newsfit' ),
					'priority'    => 28,
				],
				[
					'id'          => 'rt_layouts_panel',
					'title'       => esc_html__( 'Layout Settings', 'newsfit' ),
					'description' => esc_html__( 'NewsFit Layout Settings', 'newsfit' ),
					'priority'    => 34,
				],
				[
					'id'          => 'rt_contact_social_panel',
					'title'       => esc_html__( 'Contact & Socials', 'newsfit' ),
					'description' => esc_html__( 'NewsFit Contact & Socials', 'newsfit' ),
					'priority'    => 24,
				],

			]
		);
	}

}
