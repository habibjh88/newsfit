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
class Socials extends Customizer {

	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_socials = 'newsfit_socials_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_socials,
				'panel'       => 'rt_contact_social_panel',
				'title'       => __( 'Socials Information', 'newsfit' ),
				'description' => __( 'Newsfit Socials Section', 'newsfit' ),
				'priority'    => 2,
			]
		);

		Customize::add_controls( $this->section_socials, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {
		$social_list      = Fns::get_socials();
		$social_icon_list = [];
		$count            = 1;
		foreach ( $social_list as $id => $social ) {
			$social_icon_list[ $id ] = [
				'type'    => 'text',
				'label'   => $social['title'],
				'default' => in_array( $id, [ 'facebook', 'twitter', 'linkedin' ] ) ? '#' : '',
			];
			if ( $count == 1 ) {
				$social_icon_list[ $id ]['edit-link'] = '.topbar-row .social-icon, .footer-social';
			}
			$count++;
		}

		return apply_filters( 'newsfit_socials_controls', $social_icon_list );
	}
}
