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
class SiteIdentity extends Customizer {

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_controls( 'title_tagline', $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_title_tagline_controls',
			[

				'rt_logo'              => [
					'type'         => 'image',
					'label'        => __( 'Main Logo', 'newsfit' ),
					'description'  => __( 'Upload main logo for your site.', 'newsfit' ),
					'button_label' => __( 'Logo', 'newsfit' ),
				],

				'rt_logo_light'        => [
					'type'         => 'image',
					'label'        => __( 'Light Logo', 'newsfit' ),
					'description'  => __( 'Upload light logo for transparent header. It should a white logo', 'newsfit' ),
					'button_label' => __( 'Light Logo', 'newsfit' ),
				],

				'rt_logo_mobile'       => [
					'type'         => 'image',
					'label'        => __( 'Mobile Logo', 'newsfit' ),
					'description'  => __( 'Upload, if you need a different logo for mobile device..', 'newsfit' ),
					'button_label' => __( 'Mobile Logo', 'newsfit' ),
				],

				'rt_logo_width_height' => [
					'type'        => 'text',
					'label'       => __( 'Logo Dimension', 'newsfit' ),
					'description' => __( 'Enter the width and height value separate by comma (,). Eg. 180px,45px. This options won\'t work for the text logo', 'newsfit' ),
					'transport'   => '',
				],

			]
		);
	}
}
