<?php

namespace RT\NewsFit\Custom;

use RT\NewsFit\Traits\SingletonTraits;

class DynamicStyles {

	use SingletonTraits;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 1 );
	}

	public function enqueue_scripts() {
		$dynamic_css = $this->inline_style();
		wp_register_style( 'newsfit-dynamic', false );
		wp_enqueue_style( 'newsfit-dynamic' );
		wp_add_inline_style( 'newsfit-dynamic', $this->minify_css( $dynamic_css ) );
	}

	function minify_css( $css ) {
		$css = preg_replace( '/\/\*[^*]*\*+([^\/][^*]*\*+)*\//', '', $css ); // Remove comments
		$css = preg_replace( '/\s+/', ' ', $css ); // Remove multiple spaces
		$css = preg_replace( '/\s*([\{\};,:])\s*/', '$1', $css ); // Remove spaces around { } ; : ,

		return $css;
	}

	private function inline_style() {
		$logo_width          = '';
		$primary_color       = newsfit_option( 'rt_primary_color' ) ?? '#00c194';
		$primary_dark_color  = newsfit_option( 'rt_primary_dark_color' ) ?? '#091EF6';
		$primary_light_color = newsfit_option( 'rt_primary_light_color' ) ?? '#4AA2FF';
		$secondary_color     = newsfit_option( 'rt_secondary_color' ) ?? '#131619';
		$body_color          = newsfit_option( 'rt_body_color' ) ?? '#3D3E41';
		$title_color         = newsfit_option( 'rt_title_color' ) ?? '#161D25';
		$meta_color          = newsfit_option( 'rt_meta_color' ) ?? '#808993';
		$gray1_color         = newsfit_option( 'rt_gray1_color' ) ?? '#D0D0D0';
		$gray2_color         = newsfit_option( 'rt_gray2_color' ) ?? '#E6E6E6';
		$logo_dimension      = newsfit_option( 'rt_logo_width_height' );
		if ( strpos( $logo_dimension, ',' ) ) {
			$logo_width = explode( ',', $logo_dimension );
		}
		ob_start(); ?>

		:root {
		--rt-primary-color: <?php echo esc_html( $primary_color ); ?>;
		--rt-primary-dark: <?php echo esc_html( $primary_dark_color ); ?>;
		--rt-primary-light: <?php echo esc_html( $primary_light_color ); ?>;
		--rt-secondary-color: <?php echo esc_html( $secondary_color ); ?>;
		--rt-body-color: <?php echo esc_html( $body_color ); ?>;
		--rt-title-color: <?php echo esc_html( $title_color ); ?>;
		--rt-meta-color: <?php echo esc_html( $meta_color ); ?>;
		--rt-gray1-color: <?php echo esc_html( $gray1_color ); ?>;
		--rt-gray2-color: <?php echo esc_html( $gray2_color ); ?>;
		--rt-primary-rgb: <?php echo esc_html( newsfit_hex2rgb($primary_color) ); ?>;
		--rt-secondary-rgb: <?php echo esc_html( newsfit_hex2rgb($secondary_color) ); ?>;
		}

		body {
		color: <?php echo esc_html( $body_color ); ?>;
		}

		<?php if ( newsfit_option( 'rt_header_width' ) && newsfit_option( 'rt_header_max_width' ) > 1400 ) : ?>
			.header-container, .topbar-container {width: <?php echo newsfit_option( 'rt_header_max_width' ); ?>px;max-width: 100%;}
		<?php endif; ?>

		<?php if ( ! empty( $logo_width ) ) :?>
			.site-header .site-branding img {
			max-width: <?php echo esc_attr( $logo_width[0] ?? '100%' ) ?>;
			max-height: <?php echo esc_attr( $logo_width[1] ?? 'auto' ) ?>;
			object-fit: contain;
			}
		<?php endif; ?>

		<?php
		return ob_get_clean();
	}

}
