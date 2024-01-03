<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newsfit
 */

use RT\NewsFit\Options\Opt;

?>

</div><!-- #content -->

<?php
if ( is_customize_preview() ) {
	echo '<div id="newsfit-footer-control" style="margin-top:-30px;position:absolute;"></div>';
}
?>

<footer class="site-footer" role="contentinfo">

	<div class="footer-area">
		<div class="container">
			<div class="footer-widgets row">
				<?php dynamic_sidebar('newsfit-footer-sidebar'); ?>
			</div>
		</div>
	</div><!-- .site-info -->

	<div id="newsfit-footer-copy-control" class="footer-copyright text-center">
		<?php
		printf(
			'<a href="%s">%s</a>',
			esc_url( __( 'https://radiustheme.com', 'newsfit' ) ),
			'&copy copyright '
		);
		?>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php

$layout = Opt::$layout;
$header_style = Opt::$header_style;
$has_tr_header = Opt::$has_tr_header;

var_dump($has_tr_header);


wp_footer(); ?>

</body>
</html>
