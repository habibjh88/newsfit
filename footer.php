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

	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<div class="footer-top">
			<div class="container">
				<div class="row justify-content-end">
					<div class="row ml-0 mr-0">
						<nav id="footer-menu" class="newsfit-navigation pr-10" role="navigation">
							<?php
							wp_nav_menu( [
								'theme_location' => 'footer',
								'menu_class'     => 'newsfit-navbar',
								'items_wrap'     => '<ul id="%1$s" class="%2$s newsfit-footer-menu">%3$s</ul>',
								'fallback_cb'    => 'newsfit_custom_menu_cb',
								'walker'         => has_nav_menu( 'footer' ) ? new RT\NewsFit\Core\WalkerNav() : '',
							] );
							?>
						</nav><!-- .footer-navigation -->

					</div>
				</div>
			</div>
		</div><!-- .footer-fop -->
	<?php endif; ?>

	<div class="footer-widgets-wrapper">
		<div class="container">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'rt-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->

	<div class="footer-copyright text-center">
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

$layout        = Opt::$layout;
$header_style  = Opt::$header_style;
$has_tr_header = Opt::$has_tr_header;

var_dump( $has_tr_header );


wp_footer(); ?>

</body>
</html>
