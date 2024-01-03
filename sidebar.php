<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newsfit
 */

if ( ! is_active_sidebar( 'rdt-sidebar' ) ) :
	return;
endif;
?>

<?php
if ( is_customize_preview() ) {
	echo '<div id="newsfit-sidebar-control"></div>';
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php
	dynamic_sidebar( 'rdt-sidebar' );
	?>
</aside><!-- #secondary -->
