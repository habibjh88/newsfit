<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newsfit
 */


use RT\Newsfit\Helpers\Fns;

if ( is_singular() && is_active_sidebar( Fns::sidebar( 'single' ) ) ) {
	newsfit_sidebar( Fns::sidebar( 'single' ) );
} else {
	newsfit_sidebar( Fns::sidebar( 'main' ) );
}
