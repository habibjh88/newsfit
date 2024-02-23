<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newsfit
 */


use RT\Newsfit\Helpers\Fns;

if ( is_singular() && is_active_sidebar( Fns::default_sidebar( 'single' ) ) ) {
	newsfit_sidebar( Fns::default_sidebar( 'single' ) );
} else {
	newsfit_sidebar( Fns::default_sidebar( 'main' ) );
}
