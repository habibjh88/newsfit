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
class Contact extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register(): void {
		Customize::add_controls( $this->section_contact, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls(): array {

		return apply_filters( 'newsfit_contact_controls', [

			'rt_phone' => [
				'type'  => 'text',
				'label' => __( 'Phone', 'newsfit' ),
			],

			'rt_email' => [
				'type'  => 'text',
				'label' => __( 'Email', 'newsfit' ),
			],

			'rt_website' => [
				'type'  => 'text',
				'label' => __( 'Website', 'newsfit' ),
			],

			'rt_contact_address' => [
				'type'        => 'textarea',
				'label'       => __( 'Address', 'newsfit' ),
				'description' => __( 'Enter company address here.', 'newsfit' ),
			],


		] );


	}

}
