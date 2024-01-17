<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newsfit
 */


if ( is_singular() && is_active_sidebar( 'rt-single-sidebar' ) ) {
	newsfit_sidebar( 'rt-single-sidebar' );
} else {
	newsfit_sidebar( 'rt-sidebar' );
}
