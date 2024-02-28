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
class Contact extends Customizer {
	/**
	 * Section ID
	 *
	 * @var string
	 */
	protected string $section_id = 'newsfit_contact_section';

	/**
	 * Register controls
	 *
	 * @return void
	 */
	public function register() {
		Customize::add_section(
			[
				'id'          => $this->section_id,
				'panel'       => 'rt_contact_social_panel',
				'title'       => __( 'Contact Information', 'newsfit' ),
				'description' => __( 'Newsfit Contact Address Section', 'newsfit' ),
				'priority'    => 1,
			]
		);
		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 *
	 * @return array
	 */
	public function get_controls() {

		return apply_filters(
			'newsfit_contact_controls',
			[

				'rt_phone'           => [
					'type'  => 'text',
					'label' => __( 'Phone', 'newsfit' ),
				],

				'rt_email'           => [
					'type'  => 'text',
					'label' => __( 'Email', 'newsfit' ),
				],

				'rt_website'         => [
					'type'  => 'text',
					'label' => __( 'Website', 'newsfit' ),
				],

				'rt_contact_address' => [
					'type'        => 'textarea',
					'label'       => __( 'Address', 'newsfit' ),
					'description' => __( 'Enter company address here.', 'newsfit' ),
				],

			]
		);
	}
}
