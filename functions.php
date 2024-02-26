<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `inc/Custom/Custom.php` to write your custom functions
 *
 * @package newsfit
 */

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) :
	require_once __DIR__ . '/vendor/autoload.php';
endif;

if ( class_exists( 'RT\\Newsfit\\Init' ) ) :
	RT\Newsfit\Init::instance();
	do_action( 'newsfit_theme_init' );
endif;
